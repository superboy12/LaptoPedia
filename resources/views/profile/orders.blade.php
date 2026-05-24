@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<style>
/* ── PAGE BASE ── */
.orders-page {
    padding-top: 52px;
    min-height: 100vh;
    background: var(--bg);
}

/* ── HERO HEADER ── */
.orders-hero {
    background: var(--bg-2);
    border-bottom: 1px solid var(--border);
    padding: 60px 48px 40px;
    text-align: center;
    transition: background 0.4s ease;
}
.orders-hero h1 {
    font-family: 'Manrope', sans-serif;
    font-size: clamp(2.2rem, 5vw, 3.2rem);
    font-weight: 900;
    letter-spacing: -0.04em;
    color: var(--text);
    margin-bottom: 8px;
}
.orders-hero h1 span {
    background: linear-gradient(135deg, #f0d080, #d4a843);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.orders-hero p {
    color: var(--text-muted);
    font-size: 1rem;
    margin-bottom: 48px;
}

/* ── STATS STRIP ── */
.stats-strip {
    display: flex;
    justify-content: center;
    gap: 24px;
    flex-wrap: wrap;
}
.stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 22px 32px;
    display: flex;
    align-items: center;
    gap: 18px;
    min-width: 180px;
    transition: all 0.3s;
    cursor: pointer;
    text-decoration: none;
}
.stat-card:hover { border-color: var(--border-hover); transform: translateY(-3px); }
.stat-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.stat-icon.pending-icon { background: rgba(212,168,67,0.12); color: var(--gold); }
.stat-icon.paid-icon    { background: rgba(34,197,94,0.1);   color: #4ade80; }
.stat-icon.shipped-icon { background: rgba(59,130,246,0.1);  color: #60a5fa; }
.stat-icon.done-icon    { background: rgba(168,85,247,0.1);  color: #c084fc; }
.stat-icon.total-icon   { background: rgba(255,255,255,0.06); color: var(--text-muted); }
.stat-num {
    font-family: 'Manrope', sans-serif;
    font-size: 1.9rem;
    font-weight: 900;
    letter-spacing: -0.04em;
    color: var(--text);
    line-height: 1;
}
.stat-lbl { font-size: 0.72rem; color: var(--text-muted); margin-top: 3px; font-weight: 500; }

/* ── BODY CONTAINER ── */
.orders-body {
    max-width: 980px;
    margin: 0 auto;
    padding: 40px 24px 100px;
}

/* ── TAB FILTER ── */
.orders-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 32px;
    border-bottom: 1px solid var(--border);
    padding-bottom: 16px;
}
.tab-btn {
    padding: 8px 20px;
    border-radius: 100px;
    font-size: 0.82rem;
    font-weight: 700;
    font-family: 'Manrope', sans-serif;
    cursor: pointer;
    border: 1px solid var(--border);
    background: none;
    color: var(--text-muted);
    transition: all 0.2s;
    display: flex; align-items: center; gap: 6px;
}
.tab-btn:hover { border-color: var(--border-hover); color: var(--text); }
.tab-btn.active {
    background: var(--gold-dim);
    border-color: rgba(212,168,67,0.4);
    color: var(--gold);
}

/* ── ORDER CARD ── */
.order-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    margin-bottom: 24px;
    overflow: hidden;
    transition: transform 0.3s, border-color 0.3s, box-shadow 0.3s;
}
.order-card:hover { border-color: var(--border-hover); transform: translateY(-2px); box-shadow: 0 12px 40px rgba(0,0,0,0.15); }

.order-top {
    padding: 20px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    border-bottom: 1px solid var(--border);
    background: rgba(255,255,255,0.02);
}
.order-num {
    font-family: 'Manrope', sans-serif;
    font-size: 0.95rem;
    font-weight: 900;
    color: var(--text);
    letter-spacing: -0.01em;
}
.order-date { font-size: 0.78rem; color: var(--text-muted); margin-top: 3px; }

/* Status Badges */
.status-badge {
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.status-pending  { background: rgba(212,168,67,0.1);  color: var(--gold);  border: 1px solid rgba(212,168,67,0.2); }
.status-paid     { background: rgba(34,197,94,0.1);   color: #4ade80; border: 1px solid rgba(34,197,94,0.2); }
.status-shipped  { background: rgba(59,130,246,0.1);  color: #60a5fa; border: 1px solid rgba(59,130,246,0.2); }
.status-completed{ background: rgba(168,85,247,0.1);  color: #c084fc; border: 1px solid rgba(168,85,247,0.2); }
.status-cancelled{ background: rgba(239,68,68,0.1);   color: #ef4444; border: 1px solid rgba(239,68,68,0.2); }

/* Progress Timeline */
.order-timeline {
    padding: 20px 28px;
    display: flex;
    align-items: center;
    gap: 0;
    border-bottom: 1px solid var(--border);
}
.tl-step {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    gap: 6px;
}
.tl-step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 16px;
    left: 50%;
    right: -50%;
    height: 2px;
    background: var(--border);
    z-index: 0;
}
.tl-step.done:not(:last-child)::after { background: var(--gold); }
.tl-dot {
    width: 32px; height: 32px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem;
    border: 2px solid var(--border);
    background: var(--surface);
    color: var(--text-muted);
    position: relative;
    z-index: 1;
    transition: all 0.3s;
}
.tl-step.done .tl-dot {
    background: var(--gold);
    border-color: var(--gold);
    color: #000;
    box-shadow: 0 0 0 4px rgba(212,168,67,0.15);
}
.tl-step.active .tl-dot {
    border-color: var(--gold);
    color: var(--gold);
    animation: tl-pulse 2s ease-in-out infinite;
}
@keyframes tl-pulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(212,168,67,0.3); }
    50%      { box-shadow: 0 0 0 8px rgba(212,168,67,0); }
}
.tl-label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--text-muted);
    text-align: center;
}
.tl-step.done .tl-label, .tl-step.active .tl-label { color: var(--text); }

/* Order items */
.order-body { padding: 20px 28px; }
.order-item {
    display: flex;
    gap: 16px;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px dashed var(--border);
}
.order-item:last-child { border-bottom: none; padding-bottom: 0; }
.oi-img {
    width: 60px; height: 60px;
    border-radius: 10px;
    background: var(--surface-2);
    display: flex; align-items: center; justify-content: center;
    padding: 8px; flex-shrink: 0; overflow: hidden;
}
.oi-img img { max-width: 100%; max-height: 100%; object-fit: contain; }
.oi-img i { font-size: 1.5rem; color: var(--text-muted); opacity: 0.4; }
.oi-name { font-weight: 700; color: var(--text); font-size: 0.9rem; margin-bottom: 4px; }
.oi-qty  { font-size: 0.8rem; color: var(--text-muted); }
.oi-price { margin-left: auto; font-weight: 800; color: var(--gold); font-family: 'Manrope', sans-serif; white-space: nowrap; }

/* Footer */
.order-footer {
    padding: 16px 28px;
    border-top: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: rgba(255,255,255,0.01);
    flex-wrap: wrap;
    gap: 12px;
}
.of-total span { font-size: 0.78rem; color: var(--text-muted); display: block; }
.of-total strong { font-size: 1.2rem; font-weight: 900; color: var(--text); font-family: 'Manrope', sans-serif; }
.of-actions { display: flex; gap: 10px; }

.btn-pay {
    background: linear-gradient(135deg, #f0d080, #d4a843);
    color: #000; padding: 9px 20px; border-radius: 8px;
    font-weight: 800; font-family: 'Manrope', sans-serif; font-size: 0.85rem;
    border: none; cursor: pointer; transition: all 0.2s;
    display: inline-flex; align-items: center; gap: 6px; text-decoration: none;
}
.btn-pay:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(212,168,67,0.25); color: #000; }

.btn-track {
    background: transparent; color: var(--text);
    border: 1px solid var(--border); padding: 9px 20px;
    border-radius: 8px; font-weight: 700; font-size: 0.85rem;
    cursor: pointer; transition: all 0.2s;
    display: inline-flex; align-items: center; gap: 6px; text-decoration: none;
}
.btn-track:hover { background: var(--search-bg); border-color: var(--border-hover); color: var(--text); }

/* ── MAP MODAL ── */
.map-modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.7);
    backdrop-filter: blur(6px);
    z-index: 9998;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity 0.3s ease;
}
.map-modal-overlay.open { opacity: 1; pointer-events: all; }

.map-modal {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 24px;
    width: 90vw; max-width: 780px;
    max-height: 90vh;
    overflow: hidden;
    display: flex; flex-direction: column;
    transform: scale(0.95) translateY(20px);
    transition: transform 0.3s ease;
    box-shadow: 0 40px 120px rgba(0,0,0,0.5);
}
.map-modal-overlay.open .map-modal { transform: scale(1) translateY(0); }

.map-modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
}
.map-modal-header h3 {
    font-family: 'Manrope', sans-serif;
    font-weight: 800; font-size: 1.1rem;
    color: var(--text); letter-spacing: -0.02em;
}
.map-modal-header p { font-size: 0.78rem; color: var(--text-muted); margin-top: 2px; }
.btn-close-modal {
    background: var(--search-bg); border: 1px solid var(--border);
    color: var(--text-muted); width: 34px; height: 34px;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 1rem; transition: all 0.2s;
}
.btn-close-modal:hover { color: var(--text); border-color: var(--border-hover); }

.map-modal-info {
    display: flex; gap: 16px; flex-wrap: wrap;
    padding: 16px 24px;
    border-bottom: 1px solid var(--border);
    background: rgba(255,255,255,0.02);
}
.mi-chip {
    display: flex; align-items: center; gap: 8px;
    font-size: 0.82rem; color: var(--text-muted);
}
.mi-chip i { color: var(--gold); }
.mi-chip strong { color: var(--text); }

#trackMap { flex: 1; min-height: 380px; }

.map-modal-footer {
    padding: 14px 24px;
    border-top: 1px solid var(--border);
    display: flex; align-items: center; gap: 10px;
    flex-shrink: 0;
}
.track-legend {
    display: flex; align-items: center; gap: 18px;
    font-size: 0.78rem; color: var(--text-muted);
}
.legend-dot {
    width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px;
}

/* Empty state */
.empty-state {
    text-align: center; padding: 80px 20px;
    background: var(--surface); border: 1px solid var(--border);
    border-radius: 24px;
}
.empty-state i { font-size: 4rem; color: var(--gold-dim); margin-bottom: 20px; display: block; }
.empty-state h3 { font-family: 'Manrope', sans-serif; font-size: 1.5rem; font-weight: 800; margin-bottom: 10px; }
.empty-state p { color: var(--text-muted); margin-bottom: 28px; }
.btn-browse {
    display: inline-flex; align-items: center; gap: 8px;
    background: linear-gradient(135deg, #f0d080, #d4a843);
    color: #000; padding: 13px 28px; border-radius: 100px;
    font-weight: 800; font-family: 'Manrope', sans-serif;
    transition: transform 0.3s, box-shadow 0.3s;
}
.btn-browse:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(212,168,67,0.3); color: #000; }

@media (max-width: 680px) {
    .orders-hero { padding: 60px 24px 32px; }
    .stats-strip { gap: 12px; }
    .stat-card { min-width: 140px; padding: 16px 20px; }
    .order-top, .order-footer { flex-direction: column; align-items: flex-start; }
    .of-actions { width: 100%; }
    .btn-pay, .btn-track { flex: 1; justify-content: center; }
    .order-timeline { display: none; }
}
</style>
@endpush

@section('content')
<div class="orders-page">

    {{-- HERO --}}
    <div class="orders-hero">
        <h1>Pesanan <span>Saya</span></h1>
        <p>Pantau status, riwayat belanja, dan lacak posisi pengiriman Anda secara real-time.</p>

        {{-- STATS STRIP --}}
        <div class="stats-strip">
            <div class="stat-card" onclick="filterTab('all')">
                <div class="stat-icon total-icon"><i class="bi bi-receipt"></i></div>
                <div>
                    <div class="stat-num">{{ $orders->count() }}</div>
                    <div class="stat-lbl">Total Pesanan</div>
                </div>
            </div>
            <div class="stat-card" onclick="filterTab('pending')">
                <div class="stat-icon pending-icon"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <div class="stat-num">{{ $orders->where('status', 'pending')->count() }}</div>
                    <div class="stat-lbl">Belum Dibayar</div>
                </div>
            </div>
            <div class="stat-card" onclick="filterTab('paid')">
                <div class="stat-icon paid-icon"><i class="bi bi-check-circle-fill"></i></div>
                <div>
                    <div class="stat-num">{{ $orders->where('status', 'paid')->count() }}</div>
                    <div class="stat-lbl">Sudah Dibayar</div>
                </div>
            </div>
            <div class="stat-card" onclick="filterTab('shipped')">
                <div class="stat-icon shipped-icon"><i class="bi bi-truck"></i></div>
                <div>
                    <div class="stat-num">{{ $orders->where('status', 'shipped')->count() }}</div>
                    <div class="stat-lbl">Sedang Dikirim</div>
                </div>
            </div>
            <div class="stat-card" onclick="filterTab('completed')">
                <div class="stat-icon done-icon"><i class="bi bi-box-seam"></i></div>
                <div>
                    <div class="stat-num">{{ $orders->where('status', 'completed')->count() }}</div>
                    <div class="stat-lbl">Selesai</div>
                </div>
            </div>
        </div>
    </div>

    <div class="orders-body">

        {{-- TAB FILTER --}}
        <div class="orders-tabs" id="orderTabs">
            <button class="tab-btn active" onclick="filterTab('all')" data-tab="all">
                <i class="bi bi-grid-3x3-gap"></i> Semua
            </button>
            <button class="tab-btn" onclick="filterTab('pending')" data-tab="pending">
                <i class="bi bi-hourglass-split"></i> Belum Bayar
            </button>
            <button class="tab-btn" onclick="filterTab('paid')" data-tab="paid">
                <i class="bi bi-check-circle"></i> Diproses
            </button>
            <button class="tab-btn" onclick="filterTab('shipped')" data-tab="shipped">
                <i class="bi bi-truck"></i> Dikirim
            </button>
            <button class="tab-btn" onclick="filterTab('completed')" data-tab="completed">
                <i class="bi bi-box-seam"></i> Selesai
            </button>
            <button class="tab-btn" onclick="filterTab('cancelled')" data-tab="cancelled">
                <i class="bi bi-x-circle"></i> Dibatalkan
            </button>
        </div>

        {{-- ORDER LIST --}}
        @if($orders->isEmpty())
            <div class="empty-state">
                <i class="bi bi-bag-x"></i>
                <h3>Belum Ada Pesanan</h3>
                <p>Anda belum pernah melakukan pemesanan. Yuk, mulai jelajahi laptop premium kami!</p>
                <a href="{{ url('/products') }}" class="btn-browse"><i class="bi bi-bag"></i> Belanja Sekarang</a>
            </div>
        @else
            @foreach($orders as $order)
            @php
                $steps = [
                    ['key' => 'pending',   'label' => 'Menunggu Bayar',   'icon' => 'bi-clock'],
                    ['key' => 'paid',      'label' => 'Diverifikasi',     'icon' => 'bi-check2'],
                    ['key' => 'shipped',   'label' => 'Dikirim',          'icon' => 'bi-truck'],
                    ['key' => 'completed', 'label' => 'Selesai',          'icon' => 'bi-box-seam'],
                ];
                $statusOrder = ['pending' => 0, 'paid' => 1, 'shipped' => 2, 'completed' => 3];
                $currentIdx  = $statusOrder[$order->status] ?? -1;
            @endphp
            <div class="order-card" data-status="{{ $order->status }}">

                {{-- TOP BAR --}}
                <div class="order-top">
                    <div>
                        <div class="order-num">{{ $order->order_number }}</div>
                        <div class="order-date"><i class="bi bi-calendar3" style="margin-right:4px;"></i>{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div>
                        @if($order->status === 'pending')
                            <span class="status-badge status-pending"><i class="bi bi-hourglass-split"></i> Menunggu Pembayaran</span>
                        @elseif($order->status === 'paid')
                            <span class="status-badge status-paid"><i class="bi bi-check-circle-fill"></i> Sudah Dibayar</span>
                        @elseif($order->status === 'shipped')
                            <span class="status-badge status-shipped"><i class="bi bi-truck"></i> Sedang Dikirim</span>
                        @elseif($order->status === 'completed')
                            <span class="status-badge status-completed"><i class="bi bi-box-seam"></i> Selesai</span>
                        @elseif($order->status === 'cancelled')
                            <span class="status-badge status-cancelled"><i class="bi bi-x-circle-fill"></i> Dibatalkan</span>
                        @endif
                    </div>
                </div>

                {{-- PROGRESS TIMELINE (hidden for cancelled) --}}
                @if($order->status !== 'cancelled')
                <div class="order-timeline">
                    @foreach($steps as $i => $step)
                    @php
                        $stepIdx = $i;
                        $isDone   = $currentIdx > $stepIdx;
                        $isActive = $currentIdx === $stepIdx;
                        $cls = $isDone ? 'done' : ($isActive ? 'active' : '');
                    @endphp
                    <div class="tl-step {{ $cls }}">
                        <div class="tl-dot">
                            @if($isDone)
                                <i class="bi bi-check-lg"></i>
                            @else
                                <i class="bi {{ $step['icon'] }}"></i>
                            @endif
                        </div>
                        <div class="tl-label">{{ $step['label'] }}</div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- ITEMS --}}
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
                        <div style="flex:1;">
                            <div class="oi-name">{{ $item->product ? $item->product->name : 'Produk Tidak Diketahui' }}</div>
                            <div class="oi-qty">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="oi-price">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>

                {{-- FOOTER --}}
                <div class="order-footer">
                    <div class="of-total">
                        <span>Total Belanja</span>
                        <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    </div>
                    <div class="of-actions">
                        @if($order->status === 'pending')
                            <a href="{{ route('checkout.success', $order->order_number) }}" class="btn-pay">
                                <i class="bi bi-wallet2"></i> Bayar Sekarang
                            </a>
                        @else
                            <a href="{{ route('checkout.success', $order->order_number) }}" class="btn-track">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        @endif
                        @if(in_array($order->status, ['shipped', 'completed']) && $order->latitude && $order->longitude)
                            <button class="btn-track" onclick="openTrackMap(
                                {{ $order->latitude }},
                                {{ $order->longitude }},
                                '{{ addslashes($order->order_number) }}',
                                '{{ addslashes($order->address) }}',
                                '{{ $order->status }}'
                            )">
                                <i class="bi bi-geo-alt-fill"></i> Lacak
                            </button>
                        @endif
                    </div>
                </div>

            </div>
            @endforeach

            <div id="emptyFilter" style="display:none;">
                <div class="empty-state">
                    <i class="bi bi-funnel"></i>
                    <h3>Tidak Ada Pesanan</h3>
                    <p>Tidak ada pesanan dengan status ini.</p>
                </div>
            </div>
        @endif

    </div>
</div>

{{-- MAP MODAL --}}
<div class="map-modal-overlay" id="mapModalOverlay" onclick="closeTrackMap(event)">
    <div class="map-modal">
        <div class="map-modal-header">
            <div>
                <h3><i class="bi bi-geo-alt-fill" style="color:var(--gold);margin-right:8px;"></i>Lacak Pengiriman</h3>
                <p id="mapOrderNum">-</p>
            </div>
            <button class="btn-close-modal" onclick="closeTrackMapDirect()"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="map-modal-info">
            <div class="mi-chip"><i class="bi bi-house-door-fill"></i> <span>Alamat: <strong id="mapAddress">-</strong></span></div>
            <div class="mi-chip"><i class="bi bi-circle-fill" style="color:#4ade80;font-size:0.6rem;"></i> <span id="mapStatus">-</span></div>
        </div>
        <div id="trackMap"></div>
        <div class="map-modal-footer">
            <div class="track-legend">
                <span><span class="legend-dot" style="background:#d4a843;"></span>Lokasi Pengiriman</span>
                <span><span class="legend-dot" style="background:#4ade80;"></span>Toko Asal</span>
            </div>
            <div style="margin-left:auto;font-size:0.75rem;color:var(--text-muted);">Peta diperbarui secara real-time</div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
// ── TAB FILTER ──────────────────────────────────────
function filterTab(status) {
    // Update buttons
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    const btn = document.querySelector(`.tab-btn[data-tab="${status}"]`);
    if (btn) btn.classList.add('active');

    // Filter cards
    const cards = document.querySelectorAll('.order-card');
    let visible = 0;
    cards.forEach(c => {
        const match = status === 'all' || c.dataset.status === status;
        c.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    const emptyFilter = document.getElementById('emptyFilter');
    if (emptyFilter) emptyFilter.style.display = visible === 0 ? '' : 'none';
}

// ── MAP MODAL ──────────────────────────────────────
let trackMapInstance = null;

function openTrackMap(lat, lng, orderNum, address, status) {
    document.getElementById('mapOrderNum').textContent  = orderNum;
    document.getElementById('mapAddress').textContent   = address;

    const statusLabels = {
        shipped:   '🚚 Pesanan sedang dalam perjalanan',
        completed: '✅ Pesanan telah sampai di tujuan'
    };
    document.getElementById('mapStatus').textContent = statusLabels[status] || status;

    document.getElementById('mapModalOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
        if (trackMapInstance) {
            trackMapInstance.remove();
            trackMapInstance = null;
        }

        trackMapInstance = L.map('trackMap').setView([lat, lng], 14);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '© OpenStreetMap © CARTO',
            subdomains: 'abcd', maxZoom: 20
        }).addTo(trackMapInstance);

        // Delivery pin (gold)
        const deliveryIcon = L.divIcon({
            className: '',
            html: `<div style="
                background: #d4a843; width: 38px; height: 38px;
                border-radius: 50% 50% 50% 0; transform: rotate(-45deg);
                border: 3px solid #fff; box-shadow: 0 4px 12px rgba(212,168,67,0.5);
                display:flex;align-items:center;justify-content:center;
            "><span style="transform:rotate(45deg);font-size:1rem;">📦</span></div>`,
            iconSize: [38, 38],
            iconAnchor: [19, 38],
        });

        // Store pin (green)
        const storeIcon = L.divIcon({
            className: '',
            html: `<div style="
                background: #4ade80; width: 34px; height: 34px;
                border-radius: 50%; border: 3px solid #fff;
                box-shadow: 0 4px 12px rgba(74,222,128,0.5);
                display:flex;align-items:center;justify-content:center;font-size:1rem;
            ">🏪</div>`,
            iconSize: [34, 34],
            iconAnchor: [17, 17],
        });

        // Store location (Jakarta Pusat as default origin)
        const storeLat = -6.175110;
        const storeLng = 106.827152;

        L.marker([lat, lng], { icon: deliveryIcon })
            .addTo(trackMapInstance)
            .bindPopup(`<b>📦 Lokasi Pengiriman</b><br><small>${address}</small>`, { maxWidth: 220 })
            .openPopup();

        L.marker([storeLat, storeLng], { icon: storeIcon })
            .addTo(trackMapInstance)
            .bindPopup('<b>🏪 LaptoPedia Store</b><br><small>Jakarta Pusat</small>', { maxWidth: 180 });

        // Draw dashed route line
        L.polyline([[storeLat, storeLng], [lat, lng]], {
            color: '#d4a843',
            weight: 3,
            dashArray: '8, 8',
            opacity: 0.7
        }).addTo(trackMapInstance);

        // Fit bounds
        trackMapInstance.fitBounds([[storeLat, storeLng], [lat, lng]], { padding: [40, 40] });
    }, 150);
}

function closeTrackMap(e) {
    if (e.target === document.getElementById('mapModalOverlay')) {
        closeTrackMapDirect();
    }
}
function closeTrackMapDirect() {
    document.getElementById('mapModalOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

// Escape to close
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeTrackMapDirect();
});
</script>
@endpush
