<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
{
    \Midtrans\Config::$serverKey    = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = config('midtrans.is_production');
    \Midtrans\Config::$isSanitized  = config('midtrans.is_sanitized');
    \Midtrans\Config::$is3ds        = config('midtrans.is_3ds');
}

    /**
     * Halaman payment — generate Snap Token dari Midtrans lalu tampilkan view.
     */
    public function index($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Order tidak ditemukan atau bukan milik Anda.');
        }

        // Generate snap_token hanya jika belum ada
        if (empty($order->snap_token)) {
            $snapToken = $this->generateSnapToken($order);

            if (!$snapToken) {
                return back()->with('error', 'Gagal terhubung ke Midtrans. Coba lagi atau hubungi admin.');
            }

            $order->snap_token = $snapToken;
            $order->save();
        }

        $clientKey = config('midtrans.client_key');

        return view('payment', compact('order', 'clientKey'));
    }

    /**
     * Generate Snap Token dari Midtrans API.
     */
    private function generateSnapToken(Order $order): ?string
    {
        $user = Auth::user();

        // Siapkan item_details dari order items
        $itemDetails = [];
        $itemTotal   = 0;

        foreach ($order->items as $item) {
            $lineTotal     = (int) $item->price * (int) $item->quantity;
            $itemTotal    += $lineTotal;
            $itemDetails[] = [
                'id'       => (string) ($item->product_id ?? 'ITEM-' . $item->id),
                'price'    => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name'     => mb_substr($item->product_name, 0, 50),
            ];
        }

        $orderTotal = (int) $order->total_price;

        // Jika ada selisih (ongkir + asuransi), tambahkan sebagai item terpisah
        if ($orderTotal > $itemTotal) {
            $diff          = $orderTotal - $itemTotal;
            $itemDetails[] = [
                'id'       => 'SHIPPING-INS',
                'price'    => $diff,
                'quantity' => 1,
                'name'     => 'Ongkir & Asuransi',
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,   // pakai order_number agar unik & readable
                'gross_amount' => $orderTotal,
            ],
            'customer_details' => [
                'first_name' => $user->nama_lengkap ?? $user->name ?? 'Customer',
                'email'      => $user->email,
                'phone'      => $order->phone ?? ($user->no_telepon ?? ''),
            ],
            'item_details' => $itemDetails,
            'callbacks'    => [
                'finish' => route('payment.finish', $order->id),
            ],
        ];

        try {
            return \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Midtrans getSnapToken error: ' . $e->getMessage(), [
                'order_id'     => $order->id,
                'order_number' => $order->order_number,
            ]);
            return null;
        }
    }

    /**
     * Halaman finish — dipanggil setelah user selesai di popup Midtrans Snap.
     * Midtrans redirect ke sini dengan query string transaction_status & payment_type.
     */
    public function finish(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $transactionStatus = $request->get('transaction_status', '');
        $paymentType       = $request->get('payment_type', '');

        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            $order->status          = 'paid';
            $order->midtrans_status = $transactionStatus;
            if ($paymentType) {
                $order->payment_method = $paymentType;
            }
            $order->save();

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
        }

        if ($transactionStatus === 'pending') {
            $order->midtrans_status = 'pending';
            $order->save();

            return redirect()->route('payment.index', $order->id)
                ->with('info', 'Pembayaran Anda sedang diproses. Selesaikan pembayaran sebelum batas waktu.');
        }

        // cancel / deny / expire / atau finish tanpa transaction_status
        return redirect()->route('payment.index', $order->id)
            ->with('warning', 'Pembayaran dibatalkan. Silakan coba lagi.');
    }

    /**
     * Webhook dari server Midtrans (server-to-server notification).
     * Route ini HARUS dikecualikan dari CSRF.
     */
    public function notification(Request $request)
    {
        try {
            $notification = new \Midtrans\Notification();

            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status;
            $orderId           = $notification->order_id; // ini adalah order_number kita

            $order = Order::where('order_number', $orderId)->first();

            if (!$order) {
                Log::warning('Midtrans notification: order not found', ['order_id' => $orderId]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transactionStatus === 'capture') {
                $order->status          = ($fraudStatus === 'accept') ? 'paid' : 'pending';
                $order->midtrans_status = $transactionStatus;
            } elseif ($transactionStatus === 'settlement') {
                $order->status          = 'paid';
                $order->midtrans_status = 'settlement';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->status          = 'pending';
                $order->midtrans_status = $transactionStatus;
            } elseif ($transactionStatus === 'pending') {
                $order->status          = 'pending';
                $order->midtrans_status = 'pending';
            }

            $order->save();

            Log::info('Midtrans notification processed', [
                'order_number'      => $orderId,
                'transaction_status'=> $transactionStatus,
                'new_order_status'  => $order->status,
            ]);

            return response()->json(['message' => 'OK']);

        } catch (\Exception $e) {
            Log::error('Midtrans notification error: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Kept untuk backward compat — tidak digunakan lagi.
     */
    public function uploadProof(Request $request, $orderId)
    {
        return redirect()->route('payment.index', $orderId)
            ->with('info', 'Silakan selesaikan pembayaran melalui tombol di bawah.');
    }
}
