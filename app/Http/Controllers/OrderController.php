<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('my-orders', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
        
        return view('my-orders-detail', compact('order'));
    }
    
    // Confirm order delivery (customer confirms order received)
    public function confirmDelivery($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
        
        if ($order->status == 'shipped') {
            $order->status = 'completed';
            $order->delivered_at = now();
            $order->save();
            
            return back()->with('success', 'Terima kasih! Pesanan Anda telah dikonfirmasi sampai.');
        }
        
        return back()->with('error', 'Pesanan tidak dapat dikonfirmasi.');
    }
}