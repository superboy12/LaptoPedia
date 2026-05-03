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
        $cart     = session()->get('cart', []);
        $key      = (string) $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = min($cart[$key]['quantity'] + $qty, 99);
        } else {
            $cart[$key] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'quantity' => $qty,
            ];
        }

        session()->put('cart', $cart);
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

        // TODO: Save to orders & order_items tables, then redirect to payment page.
        // For now, clear the cart and return a success message.
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Order placed successfully! Thank you for shopping with us.');
    }
}
