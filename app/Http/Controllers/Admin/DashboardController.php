<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    /**
     * Dashboard Overview — data dinamis dari database
     */
    public function index()
    {
        // ── STATS CARDS ──────────────────────────────────────────────────
        $totalRevenue        = Order::where('status', '!=', 'cancelled')->sum('total_price');
        $totalOrders         = Order::count();
        $totalProducts       = Product::count();
        $totalCustomers      = User::where('role', 'user')->count();

        // Perubahan bulan ini vs bulan lalu
        $thisMonth  = Carbon::now()->startOfMonth();
        $lastMonth  = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $revenueThisMonth = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $thisMonth)->sum('total_price');
        $revenueLastMonth = Order::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$lastMonth, $lastMonthEnd])->sum('total_price');

        $ordersThisMonth = Order::where('created_at', '>=', $thisMonth)->count();
        $ordersLastMonth = Order::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();

        $productsThisMonth = Product::where('created_at', '>=', $thisMonth)->count();
        $productsLastMonth = Product::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();

        $customersThisMonth = User::where('role', 'user')->where('created_at', '>=', $thisMonth)->count();
        $customersLastMonth = User::where('role', 'user')->whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();

        $stats = [
            'total_revenue'          => $totalRevenue,
            'total_revenue_change'   => $this->calcChange($revenueThisMonth, $revenueLastMonth),
            'total_orders'           => $totalOrders,
            'total_orders_change'    => $this->calcChange($ordersThisMonth, $ordersLastMonth),
            'total_products'         => $totalProducts,
            'total_products_change'  => $this->calcChange($productsThisMonth, $productsLastMonth),
            'total_customers'        => $totalCustomers,
            'total_customers_change' => $this->calcChange($customersThisMonth, $customersLastMonth),
        ];

        // ── REVENUE CHART — 7 bulan terakhir ─────────────────────────────
        $revenueData = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%b') as date"),
                DB::raw("MONTH(created_at) as month_num"),
                DB::raw("YEAR(created_at) as year_num"),
                DB::raw('SUM(total_price) as value')
            )
            ->groupBy('year_num', 'month_num', 'date')
            ->orderBy('year_num')
            ->orderBy('month_num')
            ->get()
            ->map(fn($r) => ['date' => $r->date, 'value' => (int) $r->value])
            ->toArray();

        // ── ORDERS CHART — 7 hari terakhir ───────────────────────────────
        $ordersData = Order::where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%a') as day"),
                DB::raw('DATE(created_at) as date_val'),
                DB::raw('COUNT(*) as value')
            )
            ->groupBy('date_val', 'day')
            ->orderBy('date_val')
            ->get()
            ->map(fn($r) => ['day' => $r->day, 'value' => (int) $r->value])
            ->toArray();

        // ── RECENT ORDERS ─────────────────────────────────────────────────
        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->limit(5)
            ->get();

        // ── TOP TRENDING PRODUCTS (by qty sold) ───────────────────────────
        $trendingProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'products.id',
                'products.name',
                'products.image',
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'revenueData',
            'ordersData',
            'recentOrders',
            'trendingProducts'
        ));
    }

    /**
     * Hitung perubahan persen antara dua nilai
     */
    private function calcChange(int|float $current, int|float $previous): string
    {
        if ($previous == 0) {
            return $current > 0 ? '+100%' : '0%';
        }
        $change = (($current - $previous) / $previous) * 100;
        $prefix = $change >= 0 ? '+' : '';
        return $prefix . number_format($change, 1) . '%';
    }
}
