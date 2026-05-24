<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Pastikan hanya admin yang bisa akses
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    /**
     * Dashboard Overview
     */
    public function index()
    {
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_price');
        $totalOrders = Order::count();
        $totalStock = Product::sum('stock');
        $totalCustomers = User::where('role', 'customer')->count();

        $stats = [
            'total_revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
            'total_revenue_change' => '+12.5%', // Dummy change
            'total_orders' => number_format($totalOrders, 0, ',', '.'),
            'total_orders_change' => '+4.3%', // Dummy change
            'total_stock' => number_format($totalStock, 0, ',', '.'),
            'total_stock_change' => '+2.1%', // Dummy change
            'total_customers' => number_format($totalCustomers, 0, ',', '.'),
            'total_customers_change' => '+14%', // Dummy change
        ];

        // Sample data untuk grafik (statis)
        $revenueData = [
            ['date' => 'Jan', 'value' => 45000],
            ['date' => 'Feb', 'value' => 52000],
            ['date' => 'Mar', 'value' => 48000],
            ['date' => 'Apr', 'value' => 61000],
            ['date' => 'May', 'value' => 55000],
            ['date' => 'Jun', 'value' => 67000],
            ['date' => 'Jul', 'value' => 72000],
        ];

        $ordersData = [
            ['day' => 'Mon', 'value' => 120],
            ['day' => 'Tue', 'value' => 150],
            ['day' => 'Wed', 'value' => 100],
            ['day' => 'Thu', 'value' => 180],
            ['day' => 'Fri', 'value' => 200],
            ['day' => 'Sat', 'value' => 160],
            ['day' => 'Sun', 'value' => 140],
        ];

        $recentOrders = [
            [
                'order_id' => '#ORD-001',
                'customer' => 'John Doe',
                'product' => 'MacBook Pro M2',
                'payment' => 'Credit Card',
                'amount' => '$2,400',
                'status' => 'Paid',
                'date' => 'Oct 24, 2024',
            ],
            [
                'order_id' => '#ORD-002',
                'customer' => 'Sarah Wilson',
                'product' => 'Dell XPS 15',
                'payment' => 'PayPal',
                'amount' => '$1,750',
                'status' => 'Pending',
                'date' => 'Oct 23, 2024',
            ],
            [
                'order_id' => '#ORD-003',
                'customer' => 'Michael Chen',
                'product' => 'Lenovo ThinkPad X1',
                'payment' => 'Bank Transfer',
                'amount' => '$1,450',
                'status' => 'Cancelled',
                'date' => 'Oct 22, 2024',
            ],
            [
                'order_id' => '#ORD-004',
                'customer' => 'Emily Watson',
                'product' => 'ASUS ROG Zephyrus G14',
                'payment' => 'Credit Card',
                'amount' => '$1,800',
                'status' => 'Pending',
                'date' => 'Oct 21, 2024',
            ],
            [
                'order_id' => '#ORD-005',
                'customer' => 'Robert James',
                'product' => 'HP Spectre x360',
                'payment' => 'QRIS',
                'amount' => '$1,600',
                'status' => 'Paid',
                'date' => 'Oct 20, 2024',
            ],
        ];

        return view('admin.dashboard', compact('stats', 'revenueData', 'ordersData', 'recentOrders'));
    }

    /**
     * Endpoint untuk AJAX Polling statistik real-time
     */
    public function stats()
    {
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_price');
        $totalOrders = Order::count();
        $totalStock = Product::sum('stock');
        $totalCustomers = User::where('role', 'customer')->count();

        return response()->json([
            'total_revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
            'total_orders' => number_format($totalOrders, 0, ',', '.'),
            'total_stock' => number_format($totalStock, 0, ',', '.'),
            'total_customers' => number_format($totalCustomers, 0, ',', '.')
        ]);
    }

    /**
     * Product Management Page
     */
    public function products()
    {
        $products = [
            [
                'id' => 1,
                'name' => 'MacBook Pro M2',
                'category' => 'Apple',
                'price' => '$1,999',
                'stock' => 45,
                'image' => 'macbook-pro.jpg',
            ],
            [
                'id' => 2,
                'name' => 'Dell XPS 15',
                'category' => 'Dell',
                'price' => '$1,799',
                'stock' => 32,
                'image' => 'dell-xps.jpg',
            ],
            [
                'id' => 3,
                'name' => 'Lenovo ThinkPad X1',
                'category' => 'Lenovo',
                'price' => '$1,599',
                'stock' => 28,
                'image' => 'lenovo-thinkpad.jpg',
            ],
            [
                'id' => 4,
                'name' => 'ASUS ROG Zephyrus G14',
                'category' => 'ASUS',
                'price' => '$1,899',
                'stock' => 18,
                'image' => 'asus-rog.jpg',
            ],
        ];

        return view('admin.products', compact('products'));
    }

    /**
     * Orders Management Page
     */
    public function orders()
    {
        $orders = [
            [
                'order_id' => '#ORD-73829',
                'customer' => 'Jess Cohen',
                'product' => 'MacBook Pro M2',
                'payment_method' => 'BCA Transfer',
                'total_price' => '$3,499.00',
                'status' => 'Paid',
                'date' => 'Oct 24, 2023',
            ],
            [
                'order_id' => '#ORD-73828',
                'customer' => 'Alex Morgan',
                'product' => 'Dell XPS 15 OLED',
                'payment_method' => 'QRIS',
                'total_price' => '$2,150.00',
                'status' => 'Pending',
                'date' => 'Oct 24, 2023',
            ],
            [
                'order_id' => '#ORD-73827',
                'customer' => 'Sarah Rogers',
                'product' => 'Lenovo ThinkPad X1',
                'payment_method' => 'DANA',
                'total_price' => '$1,890.00',
                'status' => 'Shipped',
                'date' => 'Oct 23, 2023',
            ],
            [
                'order_id' => '#ORD-73826',
                'customer' => 'David Chen',
                'product' => 'ASUS ROG Zephyrus G14',
                'payment_method' => 'BCA Transfer',
                'total_price' => '$1,650.00',
                'status' => 'Cancelled',
                'date' => 'Oct 23, 2023',
            ],
            [
                'order_id' => '#ORD-73825',
                'customer' => 'Michael King',
                'product' => 'MacBook Air M2 13"',
                'payment_method' => 'QRIS',
                'total_price' => '$1,350.00',
                'status' => 'Paid',
                'date' => 'Oct 22, 2023',
            ],
        ];

        return view('admin.orders', compact('orders'));
    }
}
