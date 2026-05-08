@extends('layouts.app')

@push('styles')
<style>
    .success-page {
        padding: 100px 24px;
        min-height: 100vh;
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .success-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 24px;
        width: 100%;
        max-width: 550px;
        padding: 48px;
        text-align: center;
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: rgba(34, 197, 94, 0.1);
        color: #4ade80;
        font-size: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }

    .success-title {
        font-family: 'Manrope', sans-serif;
        font-size: 1.8rem;
        font-weight: 900;
        color: var(--white);
        margin-bottom: 8px;
    }

    .success-desc {
        color: var(--muted);
        font-size: 0.95rem;
        margin-bottom: 32px;
    }

    .order-info {
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px;
        text-align: left;
        margin-bottom: 32px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.9rem;
    }

    .info-row:last-child {
        margin-bottom: 0;
        padding-top: 12px;
        border-top: 1px solid var(--border);
    }

    .info-label {
        color: var(--muted);
    }

    .info-val {
        font-weight: 700;
        color: var(--white);
    }

    .info-val.total {
        color: var(--gold);
        font-size: 1.1rem;
    }

    .btn-group {
        display: flex;
        gap: 16px;
    }

    .btn-home {
        flex: 1;
        background: transparent;
        border: 1px solid var(--border);
        color: var(--white);
        padding: 14px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-home:hover {
        background: rgba(255,255,255,0.05);
        border-color: var(--gold);
    }

    .btn-orders {
        flex: 1;
        background: linear-gradient(135deg, #f0d080, #d4a843);
        color: #000;
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s;
    }

    .btn-orders:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 600px) {
        .success-card { padding: 32px 24px; }
        .btn-group { flex-direction: column; }
    }
</style>
@endpush

@section('content')
<div class="success-page">
    <div class="success-card">
        <div class="success-icon">
            <i class="bi bi-check-lg"></i>
        </div>

        <h1 class="success-title">Pesanan Berhasil!</h1>
        <p class="success-desc">Terima kasih telah berbelanja di LaptoPedia</p>

        <div class="order-info">
            <div class="info-row">
                <span class="info-label">Nomor Pesanan</span>
                <span class="info-val">{{ $order->order_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal</span>
                <span class="info-val">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
            </div>
            <div class="info-row">
                <span class="info-label">Metode Pembayaran</span>
                <span class="info-val">{{ strtoupper($order->payment_method) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Total Pembayaran</span>
                <span class="info-val total">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="btn-group">
            <a href="{{ route('home') }}" class="btn-home">
                <i class="bi bi-house"></i> Beranda
            </a>
            <a href="{{ route('my-orders') }}" class="btn-orders">
    <i class="bi bi-box-seam"></i> Lihat Pesanan Saya
</a>
        </div>
    </div>
</div>
@endsection