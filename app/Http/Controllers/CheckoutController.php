<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // GET /checkout
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data cart dari database
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        
        // Hitung subtotal
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
        // Jika cart kosong, redirect ke halaman cart
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }
        
        // Default values
        $shippingCost = 15000;
        $insurance = 15000;
        $discount = session('discount', 0);
        
        return view('checkout', compact('user', 'cartItems', 'subtotal', 'shippingCost', 'insurance', 'discount'));
    }
    
    // POST /checkout/process
    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'province' => 'required|string',
            'shipping_service' => 'required|string',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
            'coupon_code' => 'nullable|string'
        ]);
        
        // Ambil cart items
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }
        
        // Hitung total
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
        $shippingCost = $this->calculateShippingCost($request->shipping_service, $request->province);
        $insurance = 15000;
        $discount = session('discount', 0);
        $total = $subtotal + $shippingCost + $insurance - $discount;
        
        // Generate order number
        $orderNumber = 'ORD-' . strtoupper(Str::random(8)) . '-' . date('YmdHis');
        
        DB::beginTransaction();
        
        try {
            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'province' => $request->province,
                'shipping_service' => $request->shipping_service,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'insurance' => $insurance,
                'discount' => $discount,
                'total' => $total,
                'status' => 'pending',
                'coupon_code' => $request->coupon_code
            ]);
            
            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity
                ]);
            }
            
            // Clear cart
            Cart::where('user_id', Auth::id())->delete();
            
            // Clear discount session
            session()->forget('discount');
            session()->forget('coupon_code');
            
            DB::commit();
            
            // Redirect to payment page or success page
            if ($request->payment_method === 'qris' || $request->payment_method === 'transfer_bank' || $request->payment_method === 'ewallet') {
                return redirect()->route('payment.index', ['order' => $order->id]);
            }
            
            return redirect()->route('checkout.success', $order->order_number);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
    
    // GET /checkout/success/{order_number}
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        return view('success', compact('order'));
    }
    
    // POST /checkout/coupon (tambahkan route baru)
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);
        
        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('expires_at', '>', now())
            ->where('is_active', true)
            ->first();
            
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kode kupon tidak valid atau sudah kadaluarsa.'
            ]);
        }
        
        // Simpan ke session
        session(['discount' => $coupon->amount, 'coupon_code' => $coupon->code]);
        
        return response()->json([
            'success' => true,
            'discount_amount' => $coupon->amount,
            'message' => 'Kupon berhasil diterapkan!'
        ]);
    }
    
    // POST /checkout/shipping-cost (tambahkan route baru)
    public function getShippingCost(Request $request)
    {
        $request->validate([
            'shipping_service' => 'required|string',
            'province' => 'required|string',
            'subtotal' => 'required|numeric'
        ]);
        
        $cost = $this->calculateShippingCost($request->shipping_service, $request->province);
        
        // Jika subtotal > 500000, gratis ongkir (optional)
        if ($request->subtotal > 500000 && $request->shipping_service === 'jne_reg') {
            $cost = 0;
        }
        
        return response()->json([
            'success' => true,
            'cost' => $cost
        ]);
    }
    
    private function calculateShippingCost($service, $province)
    {
        // Base costs
        $costs = [
            'jne_reg' => 15000,
            'jne_yes' => 35000,
            'jnt' => 12000,
            'sicepat' => 13000
        ];
        
        // Adjust by province (lebih mahal untuk luar Jawa)
        $jawaProvinces = ['jakarta', 'jabar', 'jateng', 'jatim', 'bali', 'lampung'];
        
        $cost = $costs[$service] ?? 15000;
        
        if (!in_array($province, $jawaProvinces)) {
            $cost += 20000; // tambahan untuk luar Jawa
        }
        
        return $cost;
    }
}