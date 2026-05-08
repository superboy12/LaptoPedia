<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Order tidak ditemukan atau bukan milik Anda.');
        }
        
        return view('payment', compact('order'));
    }
    
    public function uploadProof(Request $request, $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            
            if ($order->user_id !== Auth::id()) {
                return back()->with('error', 'Order tidak ditemukan.');
            }
            
            $request->validate([
                'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120'
            ]);
            
            // Hapus file lama jika ada
            if ($order->payment_proof && Storage::disk('public')->exists($order->payment_proof)) {
                Storage::disk('public')->delete($order->payment_proof);
            }
            
            // Upload file baru
            $file = $request->file('payment_proof');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = $file->storeAs('payment_proofs', $filename, 'public');
            
            // Update order - langsung paid tanpa validasi admin
            $order->payment_proof = $path;
            $order->status = 'paid';
            $order->save();
            
            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal upload: ' . $e->getMessage());
        }
    }
}