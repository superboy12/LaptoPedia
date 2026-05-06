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
        border-color: rgba(212, 168, 67, 0.4); /* Gold glow */
    }

    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .card-title { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; letter-spacing: 0.02em; color: var(--white); }

    .badge-trend { font-size: 0.72rem; background: rgba(76, 175, 80, 0.12); color: #4ade80; padding: 4px 8px; border-radius: 4px; font-weight: 700; }
    
    .status-badge { padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; display: inline-block; }
    .status-paid { background: rgba(34, 197, 94, 0.12); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); box-shadow: 0 0 8px rgba(34, 197, 94, 0.15); }
    .status-pending { background: rgba(251, 146, 60, 0.12); color: #fb923c; border: 1px solid rgba(251, 146, 60, 0.3); box-shadow: 0 0 8px rgba(251, 146, 60, 0.15); }
    .status-cancelled { background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); box-shadow: 0 0 8px rgba(239, 68, 68, 0.15); }

    .admin-table { width: 100%; font-size: 0.85rem; border-collapse: collapse; }
    .admin-table th { padding: 12px 0; text-align: left; font-weight: 600; color: var(--muted); border-bottom: 1px solid var(--border); }
    .admin-table td { padding: 14px 0; border-bottom: 1px solid rgba(255, 255, 255, 0.04); color: var(--white); transition: background 0.2s; }
    .admin-table tr:hover td { background: rgba(255, 255, 255, 0.02); }

    .trending-item { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid rgba(255, 255, 255, 0.04); }
    .trending-item:last-child { border-bottom: none; }
    .trending-img { width: 48px; height: 48px; background: var(--deep); border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); }

    .fade-up { animation: fadeUp 0.5s var(--transition) both; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
</style>
@endpush

@section('content')

{{-- STATS CARDS --}}
<div class="dashboard-grid stats-grid">
    {{-- Revenue --}}
    <div class="admin-card fade-up">
        <div class="card-header" style="margin-bottom: 12px;">
            <i class="bi bi-currency-dollar" style="font-size: 1.8rem; color: var(--gold);"></i>
            <span class="badge-trend">+12.5%</span>
        </div>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 6px; font-family: 'DM Sans', sans-serif;">Total Revenue</p>
        <h3 style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--gold);">$128,430</h3>
    </div>

    {{-- Orders --}}
    <div class="admin-card fade-up delay-1">
        <div class="card-header" style="margin-bottom: 12px;">
            <i class="bi bi-bag" style="font-size: 1.8rem; color: var(--gold);"></i>
            <span class="badge-trend">+5.1%</span>
        </div>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 6px; font-family: 'DM Sans', sans-serif;">Total Orders</p>
        <h3 style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700;">1,240</h3>
    </div>

    {{-- Products --}}
    <div class="admin-card fade-up delay-2">
        <div class="card-header" style="margin-bottom: 12px;">
            <i class="bi bi-box" style="font-size: 1.8rem; color: var(--gold);"></i>
            <span class="badge-trend">+2.3%</span>
        </div>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 6px; font-family: 'DM Sans', sans-serif;">Total Products</p>
        <h3 style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700;">450</h3>
    </div>

    {{-- Customers --}}
    <div class="admin-card fade-up delay-3">
        <div class="card-header" style="margin-bottom: 12px;">
            <i class="bi bi-people" style="font-size: 1.8rem; color: var(--gold);"></i>
            <span class="badge-trend">+14.7%</span>
        </div>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 6px; font-family: 'DM Sans', sans-serif;">Total Customers</p>
        <h3 style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700;">8,200</h3>
    </div>
</div>

{{-- CHARTS SECTION --}}
<div class="dashboard-grid bottom-grid fade-up delay-4">
    {{-- Revenue Chart --}}
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Revenue Over Time</h3>
            <div style="display:flex; gap:8px;">
                <button style="background:var(--gold-dim); border:1px solid rgba(212,168,67,0.3); color:var(--gold); padding:6px 12px; border-radius:6px; font-size:0.75rem; cursor:pointer;">Monthly</button>
            </div>
        </div>
        <div style="position: relative; height: 250px; width: 100%;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Orders Chart --}}
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Orders per Day</h3>
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
                    <tr>
                        <td style="color: var(--gold); font-weight: 600;">#ORD-73829</td>
                        <td>Jess Cohen</td>
                        <td style="color: var(--muted);">MacBook Pro M2</td>
                        <td style="font-weight: 600;">$3,499.00</td>
                        <td><span class="status-badge status-paid">Paid</span></td>
                    </tr>
                    <tr>
                        <td style="color: var(--gold); font-weight: 600;">#ORD-73828</td>
                        <td>Alex Morgan</td>
                        <td style="color: var(--muted);">Dell XPS 15</td>
                        <td style="font-weight: 600;">$2,150.00</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                    </tr>
                    <tr>
                        <td style="color: var(--gold); font-weight: 600;">#ORD-73827</td>
                        <td>David Chen</td>
                        <td style="color: var(--muted);">ASUS ROG Zephyrus</td>
                        <td style="font-weight: 600;">$1,650.00</td>
                        <td><span class="status-badge status-cancelled">Cancelled</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Top Trending Laptops --}}
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Top Trending Laptops</h3>
        </div>
        <div class="trending-list">
            <div class="trending-item">
                <div class="trending-img"><i class="bi bi-laptop" style="color: var(--muted); font-size: 1.5rem;"></i></div>
                <div style="flex: 1;">
                    <h4 style="font-size: 0.85rem; font-weight: 700; color: var(--white); margin-bottom: 2px;">MacBook Pro M2</h4>
                    <p style="font-size: 0.75rem; color: var(--muted);">Apple • 124 sold</p>
                </div>
                <div style="font-weight: 700; color: var(--gold); font-size: 0.85rem;">#1</div>
            </div>
            <div class="trending-item">
                <div class="trending-img"><i class="bi bi-laptop" style="color: var(--muted); font-size: 1.5rem;"></i></div>
                <div style="flex: 1;">
                    <h4 style="font-size: 0.85rem; font-weight: 700; color: var(--white); margin-bottom: 2px;">Dell XPS 15 OLED</h4>
                    <p style="font-size: 0.75rem; color: var(--muted);">Dell • 98 sold</p>
                </div>
                <div style="font-weight: 700; color: var(--muted); font-size: 0.85rem;">#2</div>
            </div>
            <div class="trending-item">
                <div class="trending-img"><i class="bi bi-laptop" style="color: var(--muted); font-size: 1.5rem;"></i></div>
                <div style="flex: 1;">
                    <h4 style="font-size: 0.85rem; font-weight: 700; color: var(--white); margin-bottom: 2px;">Lenovo ThinkPad X1</h4>
                    <p style="font-size: 0.75rem; color: var(--muted);">Lenovo • 76 sold</p>
                </div>
                <div style="font-weight: 700; color: var(--muted); font-size: 0.85rem;">#3</div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
{{-- Memuat Library Chart.js dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    Chart.defaults.color = 'rgba(255, 255, 255, 0.45)';
    Chart.defaults.font.family = "'DM Sans', sans-serif";

    const ctxRev = document.getElementById('revenueChart').getContext('2d');

    let gradientGold = ctxRev.createLinearGradient(0, 0, 0, 250);
    gradientGold.addColorStop(0, 'rgba(212, 168, 67, 0.4)'); // Gold transparan
    gradientGold.addColorStop(1, 'rgba(212, 168, 67, 0)');   // Memudar ke bawah

    new Chart(ctxRev, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Revenue ($)',
                data: [45000, 52000, 48000, 61000, 59000, 75000, 82000],
                borderColor: '#d4a843', // Solid Gold
                backgroundColor: gradientGold,
                borderWidth: 2,
                tension: 0.4, // Membuat garis melengkung halus
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
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false, drawBorder: false } },
                y: { grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false }, beginAtZero: true }
            }
        }
    });

    const ctxOrd = document.getElementById('ordersChart').getContext('2d');
    new Chart(ctxOrd, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Orders',
                data: [45, 62, 55, 78, 112, 125, 85],
                backgroundColor: '#d4a843', // Gold
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
                y: { grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false }, beginAtZero: true }
            }
        }
    });
</script>
@endpush