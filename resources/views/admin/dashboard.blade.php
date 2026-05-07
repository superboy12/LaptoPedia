@extends('layouts.admin')

@section('page_title', 'Dashboard Overview')
@section('page_desc', 'Track your store performance and key metrics')

@push('styles')
<style>
    /* ── LAYOUT GRIDS ── */
    .dashboard-grid { display: grid; gap: 20px; margin-bottom: 32px; }
    .stats-grid { grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
    .bottom-grid { grid-template-columns: 2fr 1fr; }
    
    @media (max-width: 1024px) {
        .bottom-grid { grid-template-columns: 1fr; }
    }

    .admin-card {
        background: rgba(26, 26, 26, 0.4);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        padding: 24px;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.4s ease, border-color 0.4s ease;
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    }
    
    .admin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
        border-color: rgba(212, 168, 67, 0.4);
    }

    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .card-title { font-family: 'Manrope', sans-serif; font-size: 1.15rem; font-weight: 800; letter-spacing: -0.02em; color: var(--white); }

    .badge-trend { font-size: 0.72rem; padding: 4px 8px; border-radius: 4px; font-weight: 700; }
    .badge-trend.positive { background: rgba(76, 175, 80, 0.12); color: #4ade80; }
    .badge-trend.negative { background: rgba(239, 68, 68, 0.12); color: #f87171; }
    .badge-trend.neutral  { background: rgba(255,255,255,0.08); color: var(--muted); }
    
    .status-badge { padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; display: inline-block; }
    .status-paid      { background: rgba(34, 197, 94, 0.12);  color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3);  box-shadow: 0 0 8px rgba(34, 197, 94, 0.15); }
    .status-pending   { background: rgba(251, 146, 60, 0.12); color: #fb923c; border: 1px solid rgba(251, 146, 60, 0.3); box-shadow: 0 0 8px rgba(251, 146, 60, 0.15); }
    .status-shipped   { background: rgba(99, 179, 237, 0.12); color: #63b3ed; border: 1px solid rgba(99, 179, 237, 0.3); box-shadow: 0 0 8px rgba(99, 179, 237, 0.15); }
    .status-completed { background: rgba(167, 139, 250, 0.12); color: #a78bfa; border: 1px solid rgba(167, 139, 250, 0.3); box-shadow: 0 0 8px rgba(167, 139, 250, 0.15); }
    .status-cancelled { background: rgba(239, 68, 68, 0.12);  color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3);  box-shadow: 0 0 8px rgba(239, 68, 68, 0.15); }

    .admin-table { width: 100%; font-size: 0.85rem; border-collapse: collapse; }
    .admin-table th { padding: 12px 0; text-align: left; font-weight: 600; color: var(--muted); border-bottom: 1px solid var(--border); }
    .admin-table td { padding: 14px 0; border-bottom: 1px solid rgba(255, 255, 255, 0.04); color: var(--white); transition: background 0.2s; }
    .admin-table tr:hover td { background: rgba(255, 255, 255, 0.02); }

    .trending-item { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid rgba(255, 255, 255, 0.04); }
    .trending-item:last-child { border-bottom: none; }
    .trending-img { width: 48px; height: 48px; background: var(--deep); border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); overflow: hidden; flex-shrink: 0; }
    .trending-img img { width: 100%; height: 100%; object-fit: cover; }

    .fade-up { animation: fadeUp 0.5s var(--transition) both; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

    .empty-state { text-align: center; padding: 32px 0; color: var(--muted); font-size: 0.9rem; }
</style>
@endpush

@section('content')

{{-- STATS CARDS --}}
<div class="dashboard-grid stats-grid">

    {{-- Revenue --}}
    @php
        $revenueChange = $stats['total_revenue_change'];
        $revClass = str_starts_with($revenueChange, '+') ? 'positive' : (str_starts_with($revenueChange, '-') ? 'negative' : 'neutral');
    @endphp
    <div class="admin-card fade-up">
        <div class="card-header" style="margin-bottom: 12px;">
            <i class="bi bi-currency-dollar" style="font-size: 1.8rem; color: var(--gold);"></i>
            <span class="badge-trend {{ $revClass }}">{{ $revenueChange }}</span>
        </div>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 6px; font-family: 'DM Sans', sans-serif;">Total Revenue</p>
        <h3 style="font-family: 'Manrope', sans-serif; font-size: 2rem; font-weight: 800; color: var(--gold); letter-spacing: -0.02em;">
            Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
        </h3>
    </div>

    {{-- Orders --}}
    @php
        $ordChange = $stats['total_orders_change'];
        $ordClass = str_starts_with($ordChange, '+') ? 'positive' : (str_starts_with($ordChange, '-') ? 'negative' : 'neutral');
    @endphp
    <div class="admin-card fade-up delay-1">
        <div class="card-header" style="margin-bottom: 12px;">
            <i class="bi bi-bag" style="font-size: 1.8rem; color: var(--gold);"></i>
            <span class="badge-trend {{ $ordClass }}">{{ $ordChange }}</span>
        </div>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 6px; font-family: 'DM Sans', sans-serif;">Total Orders</p>
        <h3 style="font-family: 'Manrope', sans-serif; font-size: 2rem; font-weight: 800; letter-spacing: -0.02em;">
            {{ number_format($stats['total_orders']) }}
        </h3>
    </div>

    {{-- Products --}}
    @php
        $prodChange = $stats['total_products_change'];
        $prodClass = str_starts_with($prodChange, '+') ? 'positive' : (str_starts_with($prodChange, '-') ? 'negative' : 'neutral');
    @endphp
    <div class="admin-card fade-up delay-2">
        <div class="card-header" style="margin-bottom: 12px;">
            <i class="bi bi-box" style="font-size: 1.8rem; color: var(--gold);"></i>
            <span class="badge-trend {{ $prodClass }}">{{ $prodChange }}</span>
        </div>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 6px; font-family: 'DM Sans', sans-serif;">Total Products</p>
        <h3 style="font-family: 'Manrope', sans-serif; font-size: 2rem; font-weight: 800; letter-spacing: -0.02em;">
            {{ number_format($stats['total_products']) }}
        </h3>
    </div>

    {{-- Customers --}}
    @php
        $custChange = $stats['total_customers_change'];
        $custClass = str_starts_with($custChange, '+') ? 'positive' : (str_starts_with($custChange, '-') ? 'negative' : 'neutral');
    @endphp
    <div class="admin-card fade-up delay-3">
        <div class="card-header" style="margin-bottom: 12px;">
            <i class="bi bi-people" style="font-size: 1.8rem; color: var(--gold);"></i>
            <span class="badge-trend {{ $custClass }}">{{ $custChange }}</span>
        </div>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 6px; font-family: 'DM Sans', sans-serif;">Total Customers</p>
        <h3 style="font-family: 'Manrope', sans-serif; font-size: 2rem; font-weight: 800; letter-spacing: -0.02em;">
            {{ number_format($stats['total_customers']) }}
        </h3>
    </div>

</div>

{{-- CHARTS SECTION --}}
<div class="dashboard-grid bottom-grid fade-up delay-4">
    {{-- Revenue Chart --}}
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Revenue Over Time</h3>
            <span style="font-size:0.75rem; color:var(--muted);">Last 6 months</span>
        </div>
        <div style="position: relative; height: 250px; width: 100%;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Orders Chart --}}
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Orders per Day</h3>
            <span style="font-size:0.75rem; color:var(--muted);">Last 7 days</span>
        </div>
        <div style="position: relative; height: 250px; width: 100%;">
            <canvas id="ordersChart"></canvas>
        </div>
    </div>
</div>

{{-- BOTTOM ROW: RECENT ORDERS & TRENDING PRODUCTS --}}
<div class="dashboard-grid bottom-grid fade-up delay-4">
    
    {{-- Recent Orders Table --}}
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Recent Orders</h3>
            <a href="{{ route('admin.orders') }}" style="font-size: 0.85rem; color: var(--gold); font-weight: 600;">View All →</a>
        </div>
        <div style="overflow-x: auto;">
            @if($recentOrders->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-inbox" style="font-size: 2rem; display:block; margin-bottom:8px;"></i>
                    No orders yet.
                </div>
            @else
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td style="color: var(--gold); font-weight: 600;">{{ $order->order_number }}</td>
                        <td>{{ $order->user->nama_lengkap ?? '-' }}</td>
                        <td style="color: var(--muted);">
                            {{ $order->items->first()?->product?->name ?? '-' }}
                            @if($order->items->count() > 1)
                                <span style="font-size:0.72rem; color:var(--muted);"> +{{ $order->items->count() - 1 }} more</span>
                            @endif
                        </td>
                        <td style="font-weight: 600;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    {{-- Top Trending Laptops --}}
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Top Trending Laptops</h3>
        </div>
        <div class="trending-list">
            @forelse($trendingProducts as $index => $product)
            <div class="trending-item">
                <div class="trending-img">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="bi bi-laptop" style="color: var(--muted); font-size: 1.5rem;"></i>
                    @endif
                </div>
                <div style="flex: 1; min-width: 0;">
                    <h4 style="font-size: 0.85rem; font-weight: 700; color: var(--white); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $product->name }}
                    </h4>
                    <p style="font-size: 0.75rem; color: var(--muted);">{{ number_format($product->total_sold) }} sold</p>
                </div>
                <div style="font-weight: 700; font-size: 0.85rem; flex-shrink: 0; color: {{ $index === 0 ? 'var(--gold)' : 'var(--muted)' }};">
                    #{{ $index + 1 }}
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="bi bi-bar-chart" style="font-size: 2rem; display:block; margin-bottom:8px;"></i>
                No sales data yet.
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    Chart.defaults.color = 'rgba(255, 255, 255, 0.45)';
    Chart.defaults.font.family = "'DM Sans', sans-serif";

    // ── REVENUE CHART ──────────────────────────────────────────────────
    const revenueRaw  = @json($revenueData);
    const revenueLabels = revenueRaw.map(r => r.date);
    const revenueValues = revenueRaw.map(r => r.value);

    const ctxRev = document.getElementById('revenueChart').getContext('2d');
    let gradientGold = ctxRev.createLinearGradient(0, 0, 0, 250);
    gradientGold.addColorStop(0, 'rgba(212, 168, 67, 0.4)');
    gradientGold.addColorStop(1, 'rgba(212, 168, 67, 0)');

    new Chart(ctxRev, {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Revenue (Rp)',
                data: revenueValues,
                borderColor: '#d4a843',
                backgroundColor: gradientGold,
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#1a1a1a',
                pointBorderColor: '#d4a843',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: { grid: { display: false, drawBorder: false } },
                y: {
                    grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
                    beginAtZero: true,
                    ticks: {
                        callback: val => 'Rp ' + (val >= 1000000 ? (val/1000000).toFixed(1) + 'M' : val.toLocaleString('id-ID'))
                    }
                }
            }
        }
    });

    const ordersRaw    = @json($ordersData);
    const ordersLabels = ordersRaw.map(r => r.day);
    const ordersValues = ordersRaw.map(r => r.value);

    const ctxOrd = document.getElementById('ordersChart').getContext('2d');
    new Chart(ctxOrd, {
        type: 'bar',
        data: {
            labels: ordersLabels,
            datasets: [{
                label: 'Orders',
                data: ordersValues,
                backgroundColor: '#d4a843',
                borderRadius: 4,
                barThickness: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false, drawBorder: false } },
                y: {
                    grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endpush
