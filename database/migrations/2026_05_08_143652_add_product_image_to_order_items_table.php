<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class UpdateOrderStatus extends Command
{
    protected $signature = 'orders:update-status';
    protected $description = 'Update order status automatically based on time';

    public function handle()
    {
        // 1. Paid -> Processing (after 5 minutes)
        $paidOrders = Order::where('status', 'paid')
            ->where('updated_at', '<=', now()->subMinutes(5))
            ->get();
        
        foreach ($paidOrders as $order) {
            $order->status = 'processing';
            $order->save();
            $this->info("Order #{$order->order_number} status changed to PROCESSING");
        }
        
        // 2. Processing -> Shipped (after 30 minutes)
        $processingOrders = Order::where('status', 'processing')
            ->where('updated_at', '<=', now()->subMinutes(30))
            ->get();
        
        foreach ($processingOrders as $order) {
            $order->status = 'shipped';
            $order->shipped_at = now();
            $order->save();
            $this->info("Order #{$order->order_number} status changed to SHIPPED");
        }
        
        // 3. Shipped -> Completed (after 7 days) or admin manual
        // Biar admin atau user yang konfirmasi manual
        
        $this->info('Order status update completed!');
    }
}