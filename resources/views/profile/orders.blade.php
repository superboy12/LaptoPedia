@extends('layouts.app')

@push('styles')
<style>
.orders-page {
    padding-top: 100px;
    padding-bottom: 100px;
    min-height: 100vh;
}
.orders-header {
    text-align: center;
    margin-bottom: 60px;
}
.orders-header h1 {
    font-family: 'Manrope', sans-serif;
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    font-weight: 800;
    margin-bottom: 15px;
    letter-spacing: -0.04em;
}
.orders-header h1 span {
    background: linear-gradient(to right, #f0d080, #d4a843);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.orders-header p {
    color: var(--text-muted);
    font-size: 1.1rem;
}

.orders-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 24px;
}
.empty-icon {
    font-size: 4rem;
    color: var(--gold-dim);
    margin-bottom: 20px;
    display: block;
}
.empty-state h3 {
    font-family: 'Manrope', sans-serif;
    font-size: 1.5rem;
    font-weight: 800;
    margin-bottom: 10px;
}
.empty-state p {
    color: var(--text-muted);
    margin-bottom: 30px;
}
.btn-browse {
    display: inline-block;
    background: linear-gradient(135deg, #f0d080, #d4a843);
    color: #000;
    padding: 14px 32px;
    border-radius: 100px;
    font-weight: 800;
    font-family: 'Manrope', sans-serif;
    transition: transform 0.3s, box-shadow 0.3s;
}
.btn-browse:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(212,168,67,0.3);
}

/* Order Card */
.order-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    margin-bottom: 30px;
    overflow: hidden;
    transition: transform 0.3s, border-color 0.3s;
}
.order-card:hover {
    border-color: var(--border-hover);
    transform: translateY(-2px);
}
.order-header {
    padding: 20px 30px;
    border-bottom: 1px solid var(--border);
    background: rgba(255,255,255,0.02);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}
.oh-left div {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-bottom: 5px;
}
.oh-left strong {
    font-size: 1.1rem;
    color: var(--text);
    font-weight: 800;
    font-family: 'Manrope', sans-serif;
}

/* Badges */
.status-badge {
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.status-pending { background: rgba(212, 168, 67, 0.1); color: var(--gold); border: 1px solid rgba(212, 168, 67, 0.2); }
.status-paid { background: rgba(34, 197, 94, 0.1); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.2); }
.status-shipped { background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); }
.status-completed { background: rgba(168, 85, 247, 0.1); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.2); }

.order-body {
    padding: 30px;
}
.order-item {
    display: flex;
    gap: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 20px;
}
.order-item:last-child {
    padding-bottom: 0;
    border-bottom: none;
    margin-bottom: 0;
}
.oi-img {
    width: 80px; height: 80px;
    border-radius: 12px;
    background: var(--surface-2);
    display: flex; align-items: center; justify-content: center;
    padding: 10px;
    flex-shrink: 0;
}
.oi-img img { max-width: 100%; max-height: 100%; object-fit: contain; }
.oi-img i { font-size: 2rem; color: var(--text-muted); opacity: 0.5; }
.oi-detail { flex: 1; }
.oi-name { font-weight: 700; color: var(--text); margin-bottom: 8px; font-size: 1.05rem; }
.oi-meta { font-size: 0.9rem; color: var(--text-muted); display: flex; gap: 15px; }
.oi-price { font-weight: 800; color: var(--gold); }

.order-footer {
    padding: 20px 30px;
    background: rgba(255,255,255,0.02);
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.of-total span { font-size: 0.9rem; color: var(--text-muted); display: block; margin-bottom: 4px;}
.of-total strong { font-size: 1.3rem; color: var(--text); font-weight: 900; font-family: 'Manrope', sans-serif;}
.btn-pay {
    background: linear-gradient(135deg, #f0d080, #d4a843);
    color: #000;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 800;
    font-family: 'Manrope', sans-serif;
    transition: transform 0.2s, box-shadow 0.2s;
    border: none;
    display: inline-flex; align-items: center; gap: 8px;
}
.btn-pay:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(212,168,67,0.25);
}
.btn-detail {
    background: transparent;
    color: var(--text);
    border: 1px solid var(--border);
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 700;
    transition: all 0.2s;
}
.btn-detail:hover { background: var(--search-bg); border-color: var(--border-hover); }

@media(max-width: 600px) {
    .order-header { flex-direction: column; align-items: flex-start; }
    .order-footer { flex-direction: column; align-items: stretch; gap: 15px; }
    .btn-pay, .btn-detail { width: 100%; justify-content: center; }
}
</style>
@endpush

@section('content')
<div class="orders-page">
    <div class="orders-header">
        <h1><span>Pesanan</span> Saya</h1>
        <p>Lacak dan kelola riwayat transaksi Anda di LaptoPedia.</p>
    </div>

    <div class="orders-container">
        @if($orders->isEmpty())
            <div class="empty-state">
                <i class="bi bi-bag-x empty-icon"></i>
                <h3>Belum Ada Pesanan</h3>
                <p>Anda belum pernah melakukan pemesanan apa pun. Yuk, mulai jelajahi koleksi laptop premium kami!</p>
                <a href="{{ url('/products') }}" class="btn-browse">Belanja Sekarang</a>
            </div>
        @else
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="oh-left">
                            <div>Tanggal Pemesanan: {{ $order->created_at->format('d M Y, H:i') }}</div>
                            <strong>{{ $order->order_number }}</strong>
                        </div>
                        <div class="oh-right">
                            @if($order->status === 'pending')
                                <span class="status-badge status-pending"><i class="bi bi-hourglass-split"></i> Menunggu Pembayaran</span>
                            @elseif($order->status === 'paid')
                                <span class="status-badge status-paid"><i class="bi bi-check-circle-fill"></i> Sudah Dibayar</span>
                            @elseif($order->status === 'shipped')
                                <span class="status-badge status-shipped"><i class="bi bi-truck"></i> Dikirim</span>
                            @elseif($order->status === 'completed')
                                <span class="status-badge status-completed"><i class="bi bi-box-seam"></i> Selesai</span>
                            @else
                                <span class="status-badge status-pending">{{ ucfirst($order->status) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="order-body">
                        @foreach($order->items as $item)
                            <div class="order-item">
                                <div class="oi-img">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                    @else
                                        <i class="bi bi-laptop"></i>
                                    @endif
                                </div>
                                <div class="oi-detail">
                                    <div class="oi-name">{{ $item->product ? $item->product->name : 'Produk Tidak Diketahui' }}</div>
                                    <div class="oi-meta">
                                        <span>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="oi-price">
                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-footer">
                        <div class="of-total">
                            <span>Total Belanja</span>
                            <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                        </div>
                        <div class="of-actions">
                            @if($order->status === 'pending')
                                <a href="{{ route('checkout.success', $order->order_number) }}" class="btn-pay">
                                    <i class="bi bi-wallet2"></i> Selesaikan Pembayaran
                                </a>
                            @else
                                <a href="{{ route('checkout.success', $order->order_number) }}" class="btn-detail">
                                    Lihat Detail
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
