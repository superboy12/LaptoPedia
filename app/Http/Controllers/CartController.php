<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart page.
     */
    public function index()
    {
        $cart  = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Add a product to the cart (AJAX / form POST).
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'sometimes|integer|min:1|max:99',
        ]);

        $product  = Product::findOrFail($request->product_id);
        $qty      = (int) ($request->quantity ?? 1);
        $name     = $request->name ?? $product->name;
        $price    = $request->price ?? $product->price;
        $cart     = session()->get('cart', []);
        
        // Generate a unique key for this product+variation
        $key      = (string) $product->id . '_' . md5($name);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = min($cart[$key]['quantity'] + $qty, 99);
        } else {
            $cart[$key] = [
                'id'       => $product->id,
                'name'     => $name,
                'price'    => $price,
                'image'    => $product->image,
                'quantity' => $qty,
            ];
        }

        session()->put('cart', $cart);
        session()->save(); // Ensure session is saved for AJAX
        $cartCount = collect($cart)->sum('quantity');

        if ($request->wantsJson()) {
            return response()->json([
                'success'   => true,
                'cartCount' => $cartCount,
                'message'   => 'Product added to cart.',
            ]);
        }

        return back()->with('success', 'Product added to cart.');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $cart = session()->get('cart', []);

        if (isset($cart[(string) $id])) {
            $cart[(string) $id]['quantity'] = (int) $request->quantity;
            session()->put('cart', $cart);
            session()->save();
        }

        $total     = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $cartCount = collect($cart)->sum('quantity');
        $itemTotal = isset($cart[(string) $id])
            ? $cart[(string) $id]['price'] * $cart[(string) $id]['quantity']
            : 0;

        return response()->json([
            'success'   => true,
            'itemTotal' => number_format($itemTotal, 0, ',', '.'),
            'total'     => number_format($total, 0, ',', '.'),
            'cartCount' => $cartCount,
        ]);
    }

    /**
     * Remove a single item from the cart.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[(string) $id]);
        session()->put('cart', $cart);
        session()->save();

        $total     = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $cartCount = collect($cart)->sum('quantity');

        return response()->json([
            'success'   => true,
            'total'     => number_format($total, 0, ',', '.'),
            'cartCount' => $cartCount,
        ]);
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        session()->forget('cart');
        session()->save();

        return response()->json(['success' => true, 'cartCount' => 0]);
    }

    /**
     * Process checkout (placeholder — can be extended further).
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }

    /**
     * Sinkronisasi data cart localStorage (demo) ke session backend sebelum checkout.
     */
    public function syncDemoCart(Request $request)
    {
        $demoCart = $request->input('cart', []);
        $sessionCart = [];

        foreach ($demoCart as $index => $item) {
            $product = null;
            if (isset($item['id'])) {
                $product = \App\Models\Product::find($item['id']);
            } elseif (isset($item['baseName'])) {
                $product = \App\Models\Product::where('name', $item['baseName'])->first();
            } else {
                $product = \App\Models\Product::where('name', $item['name'])->first();
            }
            
            if ($product) {
                // Generate a unique key for the session cart to separate variations
                $cartKey = $product->id . '_' . md5($item['name']);
                $sessionCart[$cartKey] = [
                    'id'       => $product->id,
                    'name'     => $item['name'], // Contains variation string
                    'price'    => $item['price'] ?? $product->price,
                    'image'    => $product->image,
                    'quantity' => $item['quantity'],
                ];
            } else {
                // Fallback untuk dummy product
                $dummyId = 'demo_' . md5($item['name'] . $index);
                $price = $item['price'] ?? 15000000;
                $sessionCart[$dummyId] = [
                    'id'       => $dummyId,
                    'name'     => $item['name'],
                    'price'    => $price,
                    'image'    => null,
                    'quantity' => $item['quantity'],
                ];
            }
        }

        session()->put('cart', $sessionCart);

        return response()->json(['success' => true, 'redirect' => route('checkout.index')]);
    }
}
