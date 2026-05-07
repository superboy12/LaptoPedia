<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
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

        return view('checkout.index', compact('cart', 'total'));
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
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string',
            'latitude'       => 'required|numeric',
            'longitude'      => 'required|numeric',
            'payment_method' => 'required|in:qris,transfer',
        ]);

        $totalPrice = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $orderNumber = 'ORD-' . strtoupper(Str::random(10));

        // Gunakan transaksi database untuk memastikan Order & OrderItem tersimpan semua
        DB::beginTransaction();

        try {
            // 1. Buat Order
            $order = Order::create([
                'user_id'        => auth()->id(),
                'order_number'   => $orderNumber,
                'total_price'    => $totalPrice,
                'status'         => 'pending',
                'phone'          => $request->phone,
                'address'        => $request->address,
                'latitude'       => $request->latitude,
                'longitude'      => $request->longitude,
                'payment_method' => $request->payment_method,
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

            DB::commit();

            // 3. Kosongkan keranjang
            session()->forget('cart');

            // 4. Redirect ke halaman sukses
            return redirect()->route('checkout.success', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda: ' . $e->getMessage());
        }
    }

    /**
     * Halaman sukses setelah checkout (menampilkan QRIS dummy).
     */
    public function success($order_number)
    {
        $order = Order::where('order_number', $order_number)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}
