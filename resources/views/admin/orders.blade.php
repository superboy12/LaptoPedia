@extends('layouts.admin')

@section('page_title', 'Orders Management')
@section('page_desc', 'Manage and track all customer orders across your store')

@section('content')

{{-- STATS ROW --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px;animation:fadeUp 0.5s var(--transition);">
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:18px;text-align:center;">
        <div style="font-size:2.2rem;font-weight:800;color:var(--white);margin-bottom:4px;">1,248</div>
        <p style="font-size:0.8rem;color:var(--muted);">Total Orders</p>
    </div>
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:18px;text-align:center;">
        <div style="font-size:2.2rem;font-weight:800;color:#4ade80;margin-bottom:4px;">956</div>
        <p style="font-size:0.8rem;color:var(--muted);">Completed</p>
    </div>
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:18px;text-align:center;">
        <div style="font-size:2.2rem;font-weight:800;color:#fb923c;margin-bottom:4px;">24</div>
        <p style="font-size:0.8rem;color:var(--muted);">Pending Processing</p>
    </div>
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:18px;text-align:center;">
        <div style="font-size:2.2rem;font-weight:800;color:var(--gold);margin-bottom:4px;">$124,500</div>
        <p style="font-size:0.8rem;color:var(--muted);">Total Revenue</p>
    </div>
</div>

{{-- CONTROLS --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;animation:fadeUp 0.5s var(--transition) 0.08s both;">
    <div style="display:flex;align-items:center;gap:12px;flex:1;margin-right:20px;">
        <input type="text" placeholder="Search Order ID or Name..." style="flex:1;background:var(--surface);border:1px solid var(--border);color:var(--white);padding:10px 12px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:0.85rem;">
        <select style="background:var(--surface);border:1px solid var(--border);color:var(--muted);padding:10px 12px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:0.85rem;">
            <option>Status: All</option>
            <option>Paid</option>
            <option>Pending</option>
            <option>Cancelled</option>
            <option>Shipped</option>
        </select>
        <select style="background:var(--surface);border:1px solid var(--border);color:var(--muted);padding:10px 12px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:0.85rem;">
            <option>Payment: All</option>
            <option>Credit Card</option>
            <option>Bank Transfer</option>
            <option>QRIS</option>
            <option>E-Wallet</option>
        </select>
        <button style="background:none;border:1px solid var(--border);color:var(--muted);padding:10px 14px;border-radius:8px;font-size:0.85rem;cursor:pointer;font-family:'DM Sans',sans-serif;">
            <i class="bi bi-calendar3"></i> Last 30 Days
        </button>
        <button style="background:none;border:1px solid var(--border);color:var(--muted);padding:10px 12px;border-radius:8px;font-size:0.85rem;cursor:pointer;font-family:'DM Sans',sans-serif;">
            <i class="bi bi-funnel"></i>
        </button>
    </div>
    <button style="background:var(--gold);color:var(--black);padding:10px 16px;border:none;border-radius:8px;font-family:'Manrope',sans-serif;font-weight:700;font-size:0.85rem;cursor:pointer;">
        <i class="bi bi-plus-circle"></i> Create Order
    </button>
</div>

{{-- ORDERS TABLE --}}
<div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden;animation:fadeUp 0.5s var(--transition) 0.16s both;">
    <div style="overflow-x:auto;">
        <table style="width:100%;font-size:0.85rem;">
            <thead style="background:rgba(255,255,255,0.02);border-bottom:1px solid var(--border);">
                <tr>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);"><input type="checkbox"></th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">ORDER ID</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">CUSTOMER</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">PRODUCT</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">TOTAL PRICE</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">PAYMENT</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">STATUS</th>
                    <th style="padding:14px 16px;text-align:left;font-weight:600;color:var(--muted);">DATE</th>
                    <th style="padding:14px 16px;text-align:center;font-weight:600;color:var(--muted);">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.04);transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                        <td style="padding:14px 16px;"><input type="checkbox"></td>
                        <td style="padding:14px 16px;color:var(--gold);font-weight:600;">{{ $order['order_id'] }}</td>
                        <td style="padding:14px 16px;color:var(--white);">{{ $order['customer'] }}</td>
                        <td style="padding:14px 16px;color:var(--muted);">{{ $order['product'] }}</td>
                        <td style="padding:14px 16px;color:var(--white);font-weight:600;">{{ $order['total_price'] }}</td>
                        <td style="padding:14px 16px;color:var(--muted);">{{ $order['payment_method'] }}</td>
                        <td style="padding:14px 16px;">
                            <span style="padding:5px 11px;border-radius:6px;font-size:0.72rem;font-weight:700;
                                @if($order['status'] === 'Paid') background:rgba(34,197,94,0.12);color:#4ade80;
                                @elseif($order['status'] === 'Pending') background:rgba(251,146,60,0.12);color:#fb923c;
                                @elseif($order['status'] === 'Shipped') background:rgba(59,130,246,0.12);color:#60a5fa;
                                @else background:rgba(239,68,68,0.12);color:#f87171;
                                @endif
                            ">{{ $order['status'] }}</span>
                        </td>
                        <td style="padding:14px 16px;color:var(--muted);">{{ $order['date'] }}</td>
                        <td style="padding:14px 16px;text-align:center;">
                            <button style="background:none;border:none;color:var(--muted);cursor:pointer;font-size:1.1rem;transition:color 0.2s;" onmouseover="this.style.color='var(--white)'" onmouseout="this.style.color='var(--muted)'">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px;border-top:1px solid var(--border);font-size:0.85rem;color:var(--muted);">
        <span>Showing 5 of 1,248 items</span>
        <div style="display:flex;align-items:center;gap:6px;">
            <button style="background:none;border:1px solid var(--border);color:var(--muted);width:32px;height:32px;border-radius:6px;cursor:pointer;font-family:'DM Sans',sans-serif;">← Previous</button>
            <button style="background:var(--gold-dim);border:1px solid rgba(212,168,67,0.3);color:var(--gold);width:32px;height:32px;border-radius:6px;cursor:pointer;font-family:'DM Sans',sans-serif;font-weight:700;">1</button>
            <button style="background:none;border:1px solid var(--border);color:var(--muted);width:32px;height:32px;border-radius:6px;cursor:pointer;font-family:'DM Sans',sans-serif;">2</button>
            <button style="background:none;border:1px solid var(--border);color:var(--muted);width:32px;height:32px;border-radius:6px;cursor:pointer;font-family:'DM Sans',sans-serif;">3</button>
            <span style="color:var(--muted);">...</span>
            <button style="background:none;border:1px solid var(--border);color:var(--muted);width:32px;height:32px;border-radius:6px;cursor:pointer;font-family:'DM Sans',sans-serif;">12</button>
            <button style="background:none;border:1px solid var(--border);color:var(--muted);width:32px;height:32px;border-radius:6px;cursor:pointer;font-family:'DM Sans',sans-serif;">Next →</button>
        </div>
    </div>
</div>

@endsection
