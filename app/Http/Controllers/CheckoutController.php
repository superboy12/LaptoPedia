<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        $shippingCost = session('shipping_cost', 15000);
        $insurance = 15000;
        $discount = session('discount', 0);
        $total = $subtotal + $shippingCost + $insurance - $discount;

        return view('checkout', compact(
            'user',
            'cart',
            'subtotal',
            'shippingCost',
            'insurance',
            'discount',
            'total'
        ));
    }

    public function process(Request $request)
    {
        $request->validate([
            'province'         => 'required|string',
            'shipping_service' => 'required|string',
            'address'          => 'required|string',
            'phone'            => 'required|string|max:20',
            'payment_method'   => 'required|string',
            'notes'            => 'nullable|string|max:500',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shippingCost = $this->getShippingCostByProvince(
            $request->province,
            $request->shipping_service
        );

        $insurance = 15000;
        $discount = session('discount', 0);
        $total = $subtotal + $shippingCost + $insurance - $discount;

        $orderNumber = 'ORD-' . strtoupper(Str::random(8)) . '-' . date('YmdHis');

        DB::beginTransaction();

        try {

            $order = Order::create([
                'order_number'   => $orderNumber,
                'user_id'        => Auth::id(),
                'total_price'    => $total,
                'status'         => 'pending',
                'phone'          => $request->phone,
                'address'        => $request->address,
                'payment_method' => $request->payment_method,
                'cart_data'      => json_encode($cart),
                'notes'          => $request->notes,
            ]);

            foreach ($cart as $item) {

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => is_numeric($item['id']) ? $item['id'] : null,
                    'product_name'  => $item['name'],
                    'product_image' => $item['image'] ?? null,
                    'quantity'      => $item['quantity'],
                    'price'         => $item['price'],
                    'subtotal'      => $item['price'] * $item['quantity'],
                ]);
            }

            session()->forget('cart');
            session()->forget('discount');
            session()->forget('coupon_code');
            session()->forget('shipping_cost');

            DB::commit();

            return redirect()->route('payment.index', $order->id);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function getShippingCostByProvince($province, $service)
    {
        $baseCost = [
            'jakarta' => 15000,
            'jabar' => 15000,
            'jateng' => 15000,
            'jogja' => 15000,
            'jatim' => 15000,
            'banten' => 15000,
            'lampung' => 15000,
            'bali' => 15000,

            'aceh' => 35000,
            'sumut' => 35000,
            'sumbar' => 35000,
            'riau' => 35000,
            'kepri' => 35000,
            'jambi' => 35000,
            'bengkulu' => 35000,
            'sumsel' => 35000,

            'kalbar' => 35000,
            'kalteng' => 35000,
            'kalsel' => 35000,
            'kaltim' => 35000,

            'sulut' => 35000,
            'sulteng' => 35000,
            'sulsel' => 35000,
            'sultra' => 35000,

            'ntb' => 35000,
            'ntt' => 35000,

            'maluku' => 45000,
            'malut' => 45000,

            'papua' => 55000,
            'papuabarat' => 55000,
        ];

        $cost = $baseCost[$province] ?? 15000;

        if ($service === 'jne_yes') {
            $cost += 20000;
        } elseif ($service === 'sicepat') {
            $cost += 5000;
        }

        return $cost;
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }

    public function applyCoupon(Request $request)
    {
        $coupons = [
            'DISKON10' => 10000,
            'DISKON20' => 20000,
            'SPECIAL50' => 50000
        ];

        $code = strtoupper($request->coupon_code);

        if (isset($coupons[$code])) {

            session([
                'discount' => $coupons[$code],
                'coupon_code' => $code
            ]);

            return response()->json([
                'success' => true,
                'discount_amount' => $coupons[$code],
                'message' => 'Kupon berhasil!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Kupon tidak valid'
        ]);
    }

    public function getShippingCost(Request $request)
    {
        $cost = $this->getShippingCostByProvince(
            $request->province,
            $request->shipping_service
        );

        return response()->json([
            'success' => true,
            'cost' => $cost
        ]);
    }
}