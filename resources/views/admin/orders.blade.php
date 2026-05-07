@extends('layouts.admin')

@section('page_title', 'Orders Management')
@section('page_desc', 'Manage and track all customer orders across your store')

@section('content')

{{-- STATS ROW --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px;animation:fadeUp 0.5s var(--transition);">
    @php
        $totalOrders = \App\Models\Order::count();
        $completed = \App\Models\Order::where('status', 'completed')->count();
        $pending = \App\Models\Order::where('status', 'pending')->count();
        $revenue = \App\Models\Order::where('status', '!=', 'cancelled')->sum('total_price');
    @endphp
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:18px;text-align:center;">
        <div style="font-size:2.2rem;font-weight:800;color:var(--white);margin-bottom:4px;">{{ number_format($totalOrders) }}</div>
        <p style="font-size:0.8rem;color:var(--muted);">Total Orders</p>
    </div>
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:18px;text-align:center;">
        <div style="font-size:2.2rem;font-weight:800;color:#4ade80;margin-bottom:4px;">{{ number_format($completed) }}</div>
        <p style="font-size:0.8rem;color:var(--muted);">Completed</p>
    </div>
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:18px;text-align:center;">
        <div style="font-size:2.2rem;font-weight:800;color:#fb923c;margin-bottom:4px;">{{ number_format($pending) }}</div>
        <p style="font-size:0.8rem;color:var(--muted);">Pending Processing</p>
    </div>
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:18px;text-align:center;">
        <div style="font-size:2.2rem;font-weight:800;color:var(--gold);margin-bottom:4px;">Rp {{ number_format($revenue, 0, ',', '.') }}</div>
        <p style="font-size:0.8rem;color:var(--muted);">Total Revenue</p>
    </div>
</div>

{{-- CONTROLS --}}
<form method="GET" action="{{ route('admin.orders') }}" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;animation:fadeUp 0.5s var(--transition) 0.08s both;">
    <div style="display:flex;align-items:center;gap:12px;flex:1;margin-right:20px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Order ID or Name..." style="flex:1;background:var(--surface);border:1px solid var(--border);color:var(--white);padding:10px 12px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:0.85rem;">
        <select name="status" onchange="this.form.submit()" style="background:var(--surface);border:1px solid var(--border);color:var(--muted);padding:10px 12px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:0.85rem;">
            <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Status: All</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" style="background:none;border:1px solid var(--border);color:var(--muted);padding:10px 12px;border-radius:8px;font-size:0.85rem;cursor:pointer;font-family:'DM Sans',sans-serif;">
            <i class="bi bi-search"></i>
        </button>
    </div>
</form>

{{-- ORDERS TABLE --}}
<div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden;animation:fadeUp 0.5s var(--transition) 0.16s both;">
    <div style="overflow-x:auto;">
        <table style="width:100%;font-size:0.85rem;">
            <thead style="background:rgba(255,255,255,0.02);border-bottom:1px solid var(--border);">
                <tr>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">ORDER ID</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">CUSTOMER</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">PRODUCT</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">TOTAL PRICE</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">PAYMENT</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">STATUS</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">DATE</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.04);transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                        <td style="padding:14px 16px;color:var(--gold);font-weight:600;">{{ $order->order_number }}</td>
                        <td style="padding:14px 16px;color:var(--white);">
                            {{ $order->user ? $order->user->nama_lengkap : 'Guest' }}<br>
                            <small style="color:var(--muted)">{{ $order->phone }}</small>
                        </td>
                        <td style="padding:14px 16px;color:var(--muted);">
                            @if($order->items && $order->items->count() > 0)
                                {{ $order->items->first()->product->name ?? 'Demo Product' }}
                                @if($order->items->count() > 1)
                                    <span style="font-size:0.7rem; background:rgba(255,255,255,0.1); padding:2px 6px; border-radius:4px; margin-left:4px;">+{{ $order->items->count() - 1 }}</span>
                                @endif
                            @else
                                N/A
                            @endif
                        </td>
                        <td style="padding:14px 16px;color:var(--white);font-weight:600;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td style="padding:14px 16px;color:var(--muted);text-transform:uppercase;">{{ $order->payment_method }}</td>
                        <td style="padding:14px 16px;">
                            <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" style="margin:0;">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" style="padding:4px 8px;border-radius:6px;font-size:0.75rem;font-weight:700;border:1px solid var(--border);outline:none;cursor:pointer;
                                    @if($order->status === 'paid' || $order->status === 'completed') background:rgba(34,197,94,0.12);color:#4ade80;
                                    @elseif($order->status === 'pending') background:rgba(251,146,60,0.12);color:#fb923c;
                                    @elseif($order->status === 'shipped') background:rgba(59,130,246,0.12);color:#60a5fa;
                                    @else background:rgba(239,68,68,0.12);color:#f87171;
                                    @endif
                                ">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td style="padding:14px 16px;color:var(--muted);">{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding:20px;text-align:center;color:var(--muted);">Tidak ada pesanan ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
    <div style="padding:16px;border-top:1px solid var(--border);">
        {{ $orders->links('pagination::simple-bootstrap-4') }}
    </div>
    @endif
</div>

@endsection
