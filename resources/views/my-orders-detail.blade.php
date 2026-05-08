@extends('layouts.app')

@push('styles')
<style>
    .order-detail-container {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--gold);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 24px;
        transition: gap 0.2s;
    }
    
    .back-link:hover {
        gap: 12px;
        color: var(--gold-light);
    }
    
    .order-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
    }
    
    .order-header {
        padding: 28px 32px;
        background: linear-gradient(135deg, rgba(212,168,67,0.05) 0%, rgba(212,168,67,0) 100%);
        border-bottom: 1px solid var(--border);
    }
    
    .order-number {
        font-family: 'Manrope', sans-serif;
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 6px;
    }
    
    .order-number span {
        color: var(--gold);
    }
    
    .order-date {
        font-size: 0.8rem;
        color: var(--muted);
    }
    
    /* Timeline */
    .timeline-section {
        padding: 32px;
        border-bottom: 1px solid var(--border);
    }
    
    .section-title {
        font-family: 'Manrope', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--gold);
        margin-bottom: 24px;
    }
    
    .timeline {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 40px 0 20px;
    }
    
    .timeline-item {
        flex: 1;
        text-align: center;
        position: relative;
        z-index: 2;
    }
    
    .timeline-dot {
        width: 44px;
        height: 44px;
        background: var(--surface-2);
        border: 2px solid var(--border);
        border-radius: 50%;
        margin: 0 auto 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: all 0.3s;
    }
    
    .timeline-dot.active {
        background: var(--gold);
        border-color: var(--gold);
        color: #000;
        box-shadow: 0 0 0 4px rgba(212,168,67,0.2);
    }
    
    .timeline-dot.completed {
        background: var(--gold);
        border-color: var(--gold);
        color: #000;
    }
    
    .timeline-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 4px;
    }
    
    .timeline-label.active {
        color: var(--gold);
    }
    
    .timeline-date {
        font-size: 0.7rem;
        color: var(--muted);
    }
    
    .timeline-line {
        position: absolute;
        top: 22px;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--border);
        z-index: 1;
    }
    
    .timeline-line-progress {
        position: absolute;
        top: 22px;
        left: 0;
        height: 2px;
        background: var(--gold);
        transition: width 0.5s ease;
        z-index: 1;
    }
    
    /* Status Card */
    .status-card {
        background: rgba(0,0,0,0.2);
        border-radius: 14px;
        padding: 20px;
        margin-top: 28px;
    }
    
    .status-message {
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 8px;
    }
    
    .status-message.pending { color: #fbbf24; }
    .status-message.paid { color: #10b981; }
    .status-message.processing { color: #60a5fa; }
    .status-message.shipped { color: #60a5fa; }
    .status-message.completed { color: #22c55e; }
    
    .tracking-info {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    .tracking-detail {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .tracking-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .tracking-label {
        font-size: 0.7rem;
        color: var(--muted);
        text-transform: uppercase;
    }
    
    .tracking-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text);
    }
    
    .btn-track {
        background: transparent;
        border: 1px solid var(--gold);
        color: var(--gold);
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-track:hover {
        background: rgba(212,168,67,0.1);
        border-color: var(--gold-light);
    }
    
    .btn-confirm {
        background: #10b981;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-confirm:hover {
        background: #059669;
        transform: translateY(-1px);
    }
    
    /* Detail Section */
    .detail-section {
        padding: 32px;
        border-bottom: 1px solid var(--border);
    }
    
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .detail-label {
        font-size: 0.8rem;
        color: var(--muted);
    }
    
    .detail-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text);
    }
    
    .detail-value.total {
        font-size: 1.2rem;
        color: var(--gold);
    }
    
    /* Product List */
    .product-list {
        padding: 32px;
    }
    
    .product-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    
    .product-item:last-child {
        border-bottom: none;
    }
    
    .product-name {
        font-weight: 600;
        color: var(--text);
        margin-bottom: 4px;
    }
    
    .product-meta {
        font-size: 0.75rem;
        color: var(--muted);
    }
    
    .product-price {
        font-weight: 700;
        color: var(--gold);
    }
    
    /* Button Pay */
    .pay-button {
        display: block;
        text-align: center;
        background: linear-gradient(135deg, #f0d080, #d4a843);
        color: #000;
        padding: 14px 24px;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        margin: 0 32px 32px 32px;
    }
    
    .pay-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(212,168,67,0.3);
    }
    
    @media (max-width: 600px) {
        .detail-grid { grid-template-columns: 1fr; gap: 12px; }
        .tracking-info { flex-direction: column; align-items: flex-start; }
        .timeline-dot { width: 36px; height: 36px; font-size: 0.9rem; }
        .timeline-label { font-size: 0.65rem; }
    }
</style>
@endpush

@section('content')
<div style="min-height: 100vh; background: var(--bg); padding: 100px 20px;">
    <div class="order-detail-container">
        
        <a href="{{ route('my-orders') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>
        
        <div class="order-card">
            <!-- Header -->
            <div class="order-header">
                <div class="order-number">
                    Pesanan <span>#{{ $order->order_number }}</span>
                </div>
                <div class="order-date">
                    {{ $order->created_at->format('d F Y') }} • {{ $order->created_at->format('H:i') }} WIB
                </div>
            </div>
            
            <!-- Timeline -->
            <div class="timeline-section">
                <div class="section-title">Status Pesanan</div>
                
                @php
                    $statuses = [
                        'pending' => ['label' => 'Pesanan Dibuat', 'icon' => 'bi-cart'],
                        'paid' => ['label' => 'Dibayar', 'icon' => 'bi-credit-card'],
                        'processing' => ['label' => 'Diproses', 'icon' => 'bi-arrow-repeat'],
                        'shipped' => ['label' => 'Dikirim', 'icon' => 'bi-truck'],
                        'completed' => ['label' => 'Selesai', 'icon' => 'bi-check2-circle']
                    ];
                    $statusKeys = array_keys($statuses);
                    $currentIndex = array_search($order->status, $statusKeys);
                    if ($currentIndex === false) $currentIndex = 0;
                    $progressPercent = ($currentIndex / (count($statusKeys) - 1)) * 100;
                @endphp
                
                <div class="timeline">
                    <div class="timeline-line"></div>
                    <div class="timeline-line-progress" style="width: {{ $progressPercent }}%;"></div>
                    
                    @foreach($statuses as $key => $status)
                        @php $isActive = array_search($key, $statusKeys) <= $currentIndex; @endphp
                        <div class="timeline-item">
                            <div class="timeline-dot {{ $isActive ? 'active' : '' }} {{ $key == $order->status ? 'active' : '' }}">
                                @if($isActive && $key != $order->status)
                                    <i class="bi bi-check"></i>
                                @else
                                    <i class="{{ $status['icon'] }}"></i>
                                @endif
                            </div>
                            <div class="timeline-label {{ $isActive ? 'active' : '' }}">
                                {{ $status['label'] }}
                            </div>
                            @if($key == $order->status)
                                <div class="timeline-date">
                                    {{ $order->updated_at->format('d M') }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <!-- Status Detail Card -->
                <div class="status-card">
                    @if($order->status == 'pending')
                        <div class="status-message pending">
                            Menunggu pembayaran
                        </div>
                        <p style="font-size: 0.8rem; color: var(--muted); margin-top: 8px;">
                            Silakan selesaikan pembayaran Anda sebelum batas waktu yang ditentukan.
                        </p>
                        
                    @elseif($order->status == 'paid')
                        <div class="status-message paid">
                            Pembayaran telah dikonfirmasi
                        </div>
                        <p style="font-size: 0.8rem; color: var(--muted); margin-top: 8px;">
                            Pesanan Anda sedang dipersiapkan untuk dikirim. Terima kasih telah berbelanja.
                        </p>
                        
                    @elseif($order->status == 'processing')
                        <div class="status-message processing">
                            Pesanan sedang diproses
                        </div>
                        <p style="font-size: 0.8rem; color: var(--muted); margin-top: 8px;">
                            Tim kami sedang memproses pesanan Anda. Proses ini membutuhkan waktu 1-2 hari kerja.
                        </p>
                        
                    @elseif($order->status == 'shipped')
                        <div class="status-message shipped">
                            Pesanan dalam perjalanan
                        </div>
                        <p style="font-size: 0.8rem; color: var(--muted); margin-top: 8px;">
                            Pesanan Anda telah dikirim dan sedang menuju alamat tujuan.
                        </p>
                        
                        @if($order->tracking_number)
                        <div class="tracking-info">
                            <div class="tracking-detail">
                                <div class="tracking-item">
                                    <span class="tracking-label">Kurir</span>
                                    <span class="tracking-value">{{ $order->courier_name ?? 'JNE' }}</span>
                                </div>
                                <div class="tracking-item">
                                    <span class="tracking-label">Nomor Resi</span>
                                    <span class="tracking-value">{{ $order->tracking_number }}</span>
                                </div>
                            </div>
                            <button class="btn-track" onclick="trackOrder('{{ $order->tracking_number }}', '{{ $order->courier_name }}')">
                                <i class="bi bi-box-seam"></i> Lacak Pesanan
                            </button>
                        </div>
                        @endif
                        
                        <form action="{{ route('order.confirm', $order->id) }}" method="POST" style="margin-top: 20px;">
                            @csrf
                            <button type="submit" class="btn-confirm">
                                <i class="bi bi-check2-circle"></i> Konfirmasi Pesanan Sudah Sampai
                            </button>
                        </form>
                        
                    @elseif($order->status == 'completed')
                        <div class="status-message completed">
                            Pesanan selesai
                        </div>
                        <p style="font-size: 0.8rem; color: var(--muted); margin-top: 8px;">
                            Terima kasih telah berbelanja di LaptoPedia. Semoga Anda puas dengan produk kami.
                        </p>
                    @endif
                </div>
            </div>
            
            <!-- Detail Pembayaran -->
            <div class="detail-section">
                <div class="section-title">Detail Pembayaran</div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Status</span>
                        <span class="detail-value" style="color: #10b981;">
                            @if($order->status == 'pending') Menunggu Pembayaran
                            @else Lunas
                            @endif
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Metode</span>
                        <span class="detail-value">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Subtotal</span>
                        <span class="detail-value">Rp {{ number_format($order->total_price - 30000, 0, ',', '.') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Ongkir & Asuransi</span>
                        <span class="detail-value">Rp 30.000</span>
                    </div>
                    <div class="detail-item" style="border-top: 1px solid var(--border); padding-top: 12px; margin-top: 8px;">
                        <span class="detail-label" style="font-weight: 700;">Total</span>
                        <span class="detail-value total">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Produk -->
          <!-- Produk -->
<div class="product-list">
    <div class="section-title">Produk yang Dibeli</div>
    @php
        $cartData = is_string($order->cart_data) ? json_decode($order->cart_data, true) : $order->cart_data;
        $orderItems = $order->items; // Pastikan relasi items sudah ada di model Order
    @endphp
    
    @if($orderItems && $orderItems->count() > 0)
        @foreach($orderItems as $item)
        <div class="product-item">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 60px; height: 60px; background: var(--surface-2); border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    @if($item->product_image)
                        <img src="{{ asset('storage/' . $item->product_image) }}" alt="{{ $item->product_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="bi bi-laptop" style="font-size: 1.8rem; color: var(--muted);"></i>
                    @endif
                </div>
                <div>
                    <div class="product-name">{{ $item->product_name }}</div>
                    <div class="product-meta">Kuantitas: {{ $item->quantity }}</div>
                </div>
            </div>
            <div class="product-price">
                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
            </div>
        </div>
        @endforeach
    @elseif($cartData && is_array($cartData))
        {{-- Fallback ke cart_data jika order_items kosong --}}
        @foreach($cartData as $item)
        <div class="product-item">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 60px; height: 60px; background: var(--surface-2); border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    @if(isset($item['image']) && $item['image'])
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="bi bi-laptop" style="font-size: 1.8rem; color: var(--muted);"></i>
                    @endif
                </div>
                <div>
                    <div class="product-name">{{ $item['name'] }}</div>
                    <div class="product-meta">Kuantitas: {{ $item['quantity'] }}</div>
                </div>
            </div>
            <div class="product-price">
                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
            </div>
        </div>
        @endforeach
    @endif
</div>
            
            <!-- Tombol Lanjutkan Pembayaran -->
            @if($order->status == 'pending')
            <a href="{{ route('payment.index', $order->id) }}" class="pay-button">
                <i class="bi bi-credit-card"></i> Lanjutkan Pembayaran
            </a>
            @endif
            
        </div>
    </div>
</div>

<script>
function trackOrder(resi, courier) {
    let url = '';
    courier = courier ? courier.toLowerCase() : '';
    
    if (courier.includes('jne')) {
        url = 'https://www.jne.co.id/id/tracking/view?noresi=' + resi;
    } else if (courier.includes('jnt')) {
        url = 'https://jet.co.id/tracking?awb=' + resi;
    } else if (courier.includes('sicepat')) {
        url = 'https://www.sicepat.com/tracking?awb=' + resi;
    } else {
        url = 'https://www.cekresi.com/' + resi;
    }
    
    window.open(url, '_blank');
}
</script>
@endsection