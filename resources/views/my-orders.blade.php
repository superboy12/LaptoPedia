@extends('layouts.app')

@push('styles')
<style>
    .orders-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 16px;
    }
    
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }
    
    .orders-table th {
        padding: 15px;
        text-align: left;
        white-space: nowrap;
        background: rgba(255,255,255,0.03);
        color: var(--muted);
        font-weight: 600;
    }
    
    .orders-table td {
        padding: 15px;
        white-space: nowrap;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }
</style>
@endpush

@section('content')
<div style="min-height: 100vh; background: var(--bg); padding: 100px 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <h1 style="color: var(--text); margin-bottom: 30px;">Pesanan Saya</h1>
        
        @if($orders->count() > 0)
        <div class="orders-container">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td style="color: var(--gold);">{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            @if($order->status == 'pending')
                                <span class="status-badge" style="background: rgba(251,191,36,0.15); color: #fbbf24;">Menunggu Pembayaran</span>
                            @elseif($order->status == 'paid')
                                <span class="status-badge" style="background: rgba(16,185,129,0.15); color: #10b981;">Sudah Dibayar</span>
                            @elseif($order->status == 'shipped')
                                <span class="status-badge" style="background: rgba(59,130,246,0.15); color: #60a5fa;">Dikirim</span>
                            @elseif($order->status == 'completed')
                                <span class="status-badge" style="background: rgba(34,197,94,0.15); color: #22c55e;">Selesai</span>
                            @else
                                <span class="status-badge" style="background: rgba(239,68,68,0.15); color: #f87171;">Dibatalkan</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('my-orders.show', $order->id) }}" style="color: var(--gold); text-decoration: none;">Detail →</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 20px;">
           <div style="display: flex; gap: 8px; justify-content: center; align-items: center; margin-top: 30px; flex-wrap: wrap;">
    @if($orders->onFirstPage())
        <span style="padding: 8px 16px; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; opacity: 0.4; cursor: not-allowed;">
            ← Previous
        </span>
    @else
        <a href="{{ $orders->previousPageUrl() }}" style="padding: 8px 16px; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; text-decoration: none; color: var(--text); transition: all 0.2s;">
            ← Previous
        </a>
    @endif
    
    @php
        $currentPage = $orders->currentPage();
        $lastPage = $orders->lastPage();
        $start = max(1, $currentPage - 2);
        $end = min($lastPage, $currentPage + 2);
    @endphp
    
    @if($start > 1)
        <a href="{{ $orders->url(1) }}" class="pagination-link" style="padding: 8px 14px; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; text-decoration: none; color: var(--text);">1</a>
        @if($start > 2)
            <span style="padding: 8px 8px;">...</span>
        @endif
    @endif
    
    @for($i = $start; $i <= $end; $i++)
        @if($i == $currentPage)
            <span style="padding: 8px 14px; background: var(--gold); color: #000; border-radius: 8px; font-weight: bold;">{{ $i }}</span>
        @else
            <a href="{{ $orders->url($i) }}" style="padding: 8px 14px; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; text-decoration: none; color: var(--text);">{{ $i }}</a>
        @endif
    @endfor
    
    @if($end < $lastPage)
        @if($end < $lastPage - 1)
            <span style="padding: 8px 8px;">...</span>
        @endif
        <a href="{{ $orders->url($lastPage) }}" style="padding: 8px 14px; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; text-decoration: none; color: var(--text);">{{ $lastPage }}</a>
    @endif
    
    @if($orders->hasMorePages())
        <a href="{{ $orders->nextPageUrl() }}" style="padding: 8px 16px; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; text-decoration: none; color: var(--text);">
            Next →
        </a>
    @else
        <span style="padding: 8px 16px; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; opacity: 0.4;">
            Next →
        </span>
    @endif
</div>
        </div>
        
        @else
        <div style="text-align: center; padding: 60px; background: var(--surface); border-radius: 16px;">
            <i class="bi bi-inbox" style="font-size: 3rem; color: var(--muted);"></i>
            <p style="color: var(--muted); margin-top: 15px;">Belum ada pesanan</p>
            <a href="{{ route('products.index') }}" style="background: var(--gold); color: #000; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block; margin-top: 15px;">Mulai Belanja</a>
        </div>
        @endif
        
    </div>
</div>
@endsection