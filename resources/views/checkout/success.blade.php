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
    max-width: 600px;
    padding: 48px;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

.sc-icon {
    width: 80px; height: 80px;
    background: rgba(34, 197, 94, 0.1);
    color: #4ade80;
    font-size: 2.5rem;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px;
    box-shadow: 0 0 0 8px rgba(34, 197, 94, 0.05);
}

.sc-title {
    font-family: 'Manrope', sans-serif;
    font-size: 2rem;
    font-weight: 900;
    color: var(--text);
    margin-bottom: 8px;
    letter-spacing: -0.03em;
}
.sc-desc {
    color: var(--text-muted);
    font-size: 1rem;
    margin-bottom: 32px;
}

/* Order Info */
.order-info {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    text-align: left;
    margin-bottom: 32px;
}
.info-row {
    display: flex; justify-content: space-between;
    margin-bottom: 12px;
    font-size: 0.95rem;
}
.info-row:last-child { margin-bottom: 0; }
.info-label { color: var(--text-muted); }
.info-val { font-weight: 700; color: var(--text); }
.info-val.highlight { color: var(--gold); font-size: 1.1rem; }

/* Payment Instructions */
.payment-box {
    border: 2px dashed var(--gold);
    border-radius: 16px;
    padding: 32px;
    background: var(--gold-dim);
    margin-bottom: 32px;
}
.pb-title {
    font-family: 'Manrope', sans-serif;
    font-weight: 800;
    color: var(--gold);
    margin-bottom: 16px;
    font-size: 1.1rem;
}
.qris-img {
    width: 200px;
    height: 200px;
    background: #fff;
    padding: 10px;
    border-radius: 12px;
    margin: 0 auto 16px;
    display: block;
}
.pb-instruction {
    font-size: 0.85rem;
    color: var(--text);
    line-height: 1.6;
}

/* Buttons */
.btn-group { display: flex; gap: 16px; }
.btn-home {
    flex: 1;
    background: transparent;
    border: 1px solid var(--border);
    color: var(--text);
    padding: 14px;
    border-radius: 12px;
    font-weight: 700; font-family: 'DM Sans', sans-serif;
    transition: all 0.2s;
    text-decoration: none;
}
.btn-home:hover { background: var(--search-bg); border-color: var(--border-hover); }

.btn-confirm {
    flex: 1;
    background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
    color: #000;
    border: none;
    padding: 14px;
    border-radius: 12px;
    font-weight: 800; font-family: 'Manrope', sans-serif;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
}
.btn-confirm:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(212,168,67,0.3); }

@media (max-width: 600px) {
    .btn-group { flex-direction: column; }
}
</style>
@endpush

@section('content')
<div class="success-page">
    <div class="success-card">
        <div class="sc-icon">
            <i class="bi bi-check-lg"></i>
        </div>
        
        <h1 class="sc-title">Pesanan Berhasil Dibuat</h1>
        <p class="sc-desc">Terima kasih, pesanan Anda sedang kami proses.</p>

        <div class="order-info">
            <div class="info-row">
                <span class="info-label">Order ID</span>
                <span class="info-val">{{ $order->order_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal</span>
                <span class="info-val">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Metode Pembayaran</span>
                <span class="info-val" style="text-transform: uppercase;">{{ $order->payment_method }}</span>
            </div>
            <div style="border-top: 1px dashed var(--border); margin: 16px 0;"></div>
            <div class="info-row">
                <span class="info-label">Total Tagihan</span>
                <span class="info-val highlight">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->payment_method === 'qris')
        <div class="payment-box">
            <h3 class="pb-title">Scan QRIS untuk Membayar</h3>
            <!-- Dummy QRIS Image -->
            <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QRIS" class="qris-img">
            <div class="pb-instruction">
                Buka aplikasi e-Wallet atau M-Banking Anda (Gopay, OVO, Dana, BCA, dll). Scan kode QR di atas dan selesaikan pembayaran senilai <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>.
            </div>
        </div>
        @elseif($order->payment_method === 'transfer')
        <div class="payment-box">
            <h3 class="pb-title">Transfer Bank</h3>
            <div class="pb-instruction" style="font-size: 1rem;">
                Bank BCA<br>
                <strong>123-456-7890</strong><br>
                a/n LaptoPedia Store<br><br>
                Silakan transfer sesuai nominal tagihan.
            </div>
        </div>
        @endif

        <div class="btn-group">
            <a href="{{ route('home') }}" class="btn-home">Kembali ke Beranda</a>
            <a href="#" class="btn-confirm" onclick="alert('Ini hanya simulasi. Konfirmasi pembayaran Anda sedang diproses.'); return false;">
                Saya Sudah Bayar
            </a>
        </div>

    </div>
</div>
@endsection
