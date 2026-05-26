<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Pastikan user sudah login
        $this->middleware('auth');
    }

    /**
     * Menampilkan halaman form checkout.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Ambil kupon yang sudah di-apply dari session (jika ada)
        $appliedCoupon = session()->get('applied_coupon', null);

        return view('checkout.index', compact('cart', 'total', 'appliedCoupon'));
    }

    /**
     * Memproses form checkout dan membuat order.
     */
    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Validasi input form
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'province'       => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'district'       => 'required|string|max:100',
            'postal_code'    => 'required|string|max:20',
            'street_address' => 'required|string',
            'notes'          => 'nullable|string',
            'latitude'       => 'required|numeric',
            'longitude'      => 'required|numeric',
            'payment_method' => 'required|in:qris,transfer',
            'coupon_code'    => 'nullable|string|max:50',
        ]);

        $fullAddress = "{$request->street_address}, Kec. {$request->district}, {$request->city}, Prov. {$request->province}, {$request->postal_code}";
        if (!empty($request->notes)) {
            $fullAddress .= " (Catatan: {$request->notes})";
        }

        $subtotal     = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $discountAmount = 0;
        $couponCode   = null;
        $coupon       = null;

        // ── Validasi & Hitung Diskon Kupon ────────────────────
        if (!empty($request->coupon_code)) {
            $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))->first();

            if ($coupon) {
                $result = $coupon->validate((int) $subtotal);
                if ($result['valid']) {
                    $discountAmount = $result['discount'];
                    $couponCode     = $coupon->code;
                }
            }
        }

        $totalPrice  = max(0, $subtotal - $discountAmount);
        $orderNumber = 'ORD-' . strtoupper(Str::random(10));

        // Gunakan transaksi database untuk memastikan Order & OrderItem tersimpan semua
        DB::beginTransaction();

        try {
            // 1. Buat Order
            $order = Order::create([
                'user_id'         => auth()->id(),
                'order_number'    => $orderNumber,
                'total_price'     => $totalPrice,
                'status'          => 'pending',
                'phone'           => $request->phone,
                'address'         => $fullAddress,
                'latitude'        => $request->latitude,
                'longitude'       => $request->longitude,
                'payment_method'  => $request->payment_method,
                'coupon_code'     => $couponCode,
                'discount_amount' => $discountAmount,
            ]);

            // 2. Buat OrderItems
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);
            }

            // 3. Konfigurasi Midtrans & Dapatkan Snap Token
            \Midtrans\Config::$serverKey    = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized  = config('midtrans.is_sanitized');
            \Midtrans\Config::$is3ds        = config('midtrans.is_3ds');

            $itemDetails = [];
            foreach ($cart as $item) {
                $itemDetails[] = [
                    'id'       => (string)$item['id'],
                    'price'    => (int)$item['price'],
                    'quantity' => (int)$item['quantity'],
                    'name'     => strlen($item['name']) > 50 ? substr($item['name'], 0, 47) . '...' : $item['name'],
                ];
            }

            // Tambahkan baris diskon kupon ke item_details Midtrans (nilai negatif)
            if ($discountAmount > 0 && $couponCode) {
                $itemDetails[] = [
                    'id'       => 'COUPON-' . $couponCode,
                    'price'    => -(int)$discountAmount,
                    'quantity' => 1,
                    'name'     => 'Diskon Kupon: ' . $couponCode,
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id'     => $orderNumber,
                    'gross_amount' => (int)$totalPrice,
                ],
                'item_details'    => $itemDetails,
                'customer_details' => [
                    'first_name' => $request->recipient_name,
                    'email'      => auth()->user()->email,
                    'phone'      => $request->phone,
                    'billing_address' => [
                        'first_name'  => $request->recipient_name,
                        'email'       => auth()->user()->email,
                        'phone'       => $request->phone,
                        'address'     => $request->street_address,
                        'city'        => $request->city,
                        'postal_code' => $request->postal_code,
                        'country_code' => 'IDN'
                    ],
                    'shipping_address' => [
                        'first_name'  => $request->recipient_name,
                        'email'       => auth()->user()->email,
                        'phone'       => $request->phone,
                        'address'     => $request->street_address,
                        'city'        => $request->city,
                        'postal_code' => $request->postal_code,
                        'country_code' => 'IDN'
                    ]
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update order dengan snap_token
            $order->update(['snap_token' => $snapToken]);

            // Increment usage count kupon
            if ($coupon) {
                $coupon->incrementUsage();
            }

            DB::commit();

            // Kosongkan keranjang dan data kupon dari session
            session()->forget(['cart', 'applied_coupon']);

            // Redirect ke halaman sukses
            return redirect()->route('checkout.success', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda: ' . $e->getMessage());
        }
    }

    /**
     * Halaman sukses setelah checkout (menampilkan detail pembayaran Midtrans).
     */
    public function success($order_number)
    {
        $order = Order::where('order_number', $order_number)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }

    /**
     * Webhook callback untuk menerima notifikasi status pembayaran dari Midtrans.
     */
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $signatureKey = $request->signature_key;

        // Verifikasi signature key
        $localSignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($localSignature !== $signatureKey) {
            return response()->json(['message' => 'Signature tidak valid'], 400);
        }

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $type = $request->payment_type;

        if ($transactionStatus == 'capture') {
            if ($type == 'credit_card') {
                if ($request->fraud_status == 'challenge') {
                    $order->update(['status' => 'pending']);
                } else {
                    $order->update(['status' => 'paid']);
                }
            }
        } elseif ($transactionStatus == 'settlement') {
            $order->update(['status' => 'paid']);
        } elseif ($transactionStatus == 'pending') {
            $order->update(['status' => 'pending']);
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $order->update(['status' => 'pending']);
        }

        return response()->json(['message' => 'Status berhasil diperbarui']);
    }
}
