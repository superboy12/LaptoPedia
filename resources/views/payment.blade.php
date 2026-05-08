@extends('layouts.app')

@push('styles')
<style>
    .payment-page {
        min-height: 100vh;
        background: var(--black);
        padding: 52px 0 0;
    }

    .page-wrap {
        max-width: 1280px;
        margin: 0 auto;
        padding: 64px 48px 120px;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 48px;
    }
    .breadcrumb a { font-size: 0.78rem; color: var(--muted); transition: color 0.2s; text-decoration: none; }
    .breadcrumb a:hover { color: var(--white); }
    .breadcrumb i { font-size: 0.65rem; color: rgba(255,255,255,0.2); }
    .breadcrumb span { font-size: 0.78rem; color: var(--gold); font-weight: 600; }

    .checkout-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        margin-bottom: 64px;
    }
    .step { display: flex; align-items: center; gap: 10px; }
    .step-line { width: 80px; height: 1px; background: rgba(255,255,255,0.1); margin: 0 4px; }
    .step-line.active { background: var(--gold); }
    .step-num {
        width: 34px; height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Manrope', sans-serif; font-size: 0.75rem; font-weight: 800;
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--muted); background: var(--surface); transition: all 0.3s;
    }
    .step.active .step-num { background: var(--gold); border-color: var(--gold); color: #000; }
    .step.done .step-num { background: rgba(212,168,67,0.15); border-color: rgba(212,168,67,0.4); color: var(--gold); }
    .step-label { font-size: 0.73rem; font-weight: 600; color: var(--muted); white-space: nowrap; }
    .step.active .step-label { color: var(--white); }
    .step.done .step-label { color: var(--gold); }

    .payment-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 32px;
        align-items: start;
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .card-body { padding: 32px; }
    .card-title {
        font-family: 'Manrope', sans-serif;
        font-size: 0.7rem; font-weight: 700;
        letter-spacing: 0.12em; text-transform: uppercase;
        color: var(--gold); margin-bottom: 22px;
        display: flex; align-items: center; gap: 8px;
    }

    .countdown-banner {
        background: linear-gradient(135deg, rgba(212,168,67,0.1) 0%, rgba(212,168,67,0.05) 100%);
        border: 1px solid rgba(212,168,67,0.2);
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 28px;
    }
    .countdown-icon { font-size: 1.4rem; color: var(--gold); }
    .countdown-text { flex: 1; }
    .countdown-label { font-size: 0.75rem; color: var(--muted); margin-bottom: 2px; }
    .countdown-timer {
        font-family: 'Manrope', sans-serif;
        font-size: 1.3rem;
        font-weight: 900;
        color: var(--gold);
        letter-spacing: 0.05em;
    }

    .qris-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0;
    }

    .qris-amount-label { font-size: 0.75rem; color: var(--muted); margin-bottom: 4px; }
    .qris-amount {
        font-family: 'Manrope', sans-serif;
        font-size: 2rem;
        font-weight: 900;
        color: var(--white);
        letter-spacing: -0.04em;
        margin-bottom: 28px;
    }

    .qris-frame {
        background: #fff;
        border-radius: 20px;
        padding: 22px;
        width: 220px; height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-bottom: 20px;
        box-shadow: 0 0 0 1px rgba(212,168,67,0.2), 0 24px 60px rgba(0,0,0,0.5);
    }
    .qris-frame svg { width: 176px; height: 176px; }
    .qris-logo {
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--gold);
        color: #000;
        font-family: 'Manrope', sans-serif;
        font-size: 0.65rem;
        font-weight: 900;
        letter-spacing: 0.1em;
        padding: 4px 14px;
        border-radius: 100px;
        white-space: nowrap;
    }

    .qris-instructions { margin-top: 28px; display: flex; flex-direction: column; gap: 10px; width: 100%; }
    .qris-step {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: rgba(255,255,255,0.03);
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.06);
    }
    .qris-step-num {
        width: 24px; height: 24px;
        border-radius: 50%;
        background: rgba(212,168,67,0.15);
        border: 1px solid rgba(212,168,67,0.3);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Manrope', sans-serif;
        font-size: 0.68rem; font-weight: 800;
        color: var(--gold);
        flex-shrink: 0;
    }
    .qris-step-text { font-size: 0.8rem; color: rgba(255,255,255,0.65); line-height: 1.4; }

    .upload-zone {
        border: 2px dashed rgba(255,255,255,0.12);
        border-radius: 16px;
        padding: 40px 24px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }
    .upload-zone:hover, .upload-zone.dragover {
        border-color: rgba(212,168,67,0.4);
        background: rgba(212,168,67,0.04);
    }
    .upload-icon {
        width: 56px; height: 56px;
        border-radius: 14px;
        background: rgba(212,168,67,0.1);
        border: 1px solid rgba(212,168,67,0.2);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
        font-size: 1.4rem;
        color: var(--gold);
    }
    .upload-title { font-family: 'Manrope', sans-serif; font-size: 0.92rem; font-weight: 700; color: var(--white); margin-bottom: 6px; }
    .upload-hint { font-size: 0.75rem; color: var(--muted); line-height: 1.5; }
    .upload-formats { display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 14px; }
    .upload-format-tag {
        font-size: 0.65rem; font-weight: 700;
        letter-spacing: 0.08em; text-transform: uppercase;
        padding: 3px 8px; border-radius: 5px;
        background: rgba(255,255,255,0.07);
        color: rgba(255,255,255,0.4);
        border: 1px solid rgba(255,255,255,0.08);
    }

    .upload-preview {
        display: none;
        margin-top: 20px;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
        position: relative;
    }
    .upload-preview img { width: 100%; max-height: 200px; object-fit: cover; display: block; }
    .upload-preview-overlay {
        position: absolute; bottom: 0; left: 0; right: 0;
        padding: 10px 14px;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        display: flex; align-items: center; justify-content: space-between;
    }
    .preview-name { font-size: 0.75rem; color: rgba(255,255,255,0.7); }
    .preview-remove { font-size: 0.72rem; color: #f87171; cursor: pointer; background: none; border: none; }

    .btn-submit {
        display: flex; align-items: center; justify-content: center;
        gap: 10px; width: 100%;
        background: var(--white); color: #000;
        font-family: 'Manrope', sans-serif; font-weight: 800;
        font-size: 0.9rem; padding: 17px 28px;
        border: none; border-radius: 14px; cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        margin-top: 20px;
    }
    .btn-submit:hover { background: #e8e8e8; transform: scale(1.01); }
    .btn-submit:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

    .status-card {
        background: var(--surface);
        border-radius: 20px;
        overflow: hidden;
        position: sticky; top: 72px;
    }
    .status-header { padding: 24px 28px; border-bottom: 1px solid var(--border); }
    .status-title {
        font-family: 'Manrope', sans-serif;
        font-size: 0.7rem; font-weight: 700;
        letter-spacing: 0.12em; text-transform: uppercase;
        color: var(--gold);
    }
    .status-timeline { padding: 28px; display: flex; flex-direction: column; gap: 0; }
    .timeline-item { display: flex; gap: 16px; position: relative; }
    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 15px; top: 32px;
        width: 2px; height: calc(100% - 4px);
        background: rgba(255,255,255,0.07);
    }
    .timeline-dot {
        width: 32px; height: 32px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.1);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; background: var(--surface-2);
        font-size: 0.72rem; color: var(--muted);
        z-index: 1;
    }
    .timeline-item.done .timeline-dot {
        border-color: rgba(212,168,67,0.5);
        background: rgba(212,168,67,0.1);
        color: var(--gold);
    }
    .timeline-item.active .timeline-dot {
        border-color: var(--gold);
        background: var(--gold);
        color: #000;
        box-shadow: 0 0 16px rgba(212,168,67,0.3);
    }
    .timeline-content { padding-bottom: 28px; padding-top: 4px; }
    .timeline-label { font-family: 'Manrope', sans-serif; font-size: 0.85rem; font-weight: 700; color: var(--white); margin-bottom: 3px; }
    .timeline-desc { font-size: 0.75rem; color: var(--muted); line-height: 1.5; }
    .timeline-time { font-size: 0.7rem; color: rgba(212,168,67,0.6); margin-top: 4px; }

    .status-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: 100px;
        font-family: 'Manrope', sans-serif;
        font-size: 0.72rem; font-weight: 700;
        letter-spacing: 0.06em; text-transform: uppercase;
    }
    .status-pill.pending {
        background: rgba(251,191,36,0.12);
        border: 1px solid rgba(251,191,36,0.25);
        color: #fbbf24;
    }
    .status-pill.paid {
        background: rgba(16,185,129,0.12);
        border: 1px solid rgba(16,185,129,0.25);
        color: #10b981;
    }
    .status-pill-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
        animation: blink 1.5s ease-in-out infinite;
    }
    @keyframes blink { 0%,100% { opacity: 1; } 50% { opacity: 0.3; } }

    .order-info-box { padding: 20px 28px; border-bottom: 1px solid var(--border); }
    .order-info-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .oinfo-label { font-size: 0.75rem; color: var(--muted); }
    .oinfo-val { font-size: 0.82rem; color: var(--white); font-weight: 600; }
    .oinfo-val.amount {
        font-family: 'Manrope', sans-serif;
        font-size: 1.1rem; font-weight: 900;
        color: var(--gold); letter-spacing: -0.03em;
    }

    .support-box { padding: 20px 28px; display: flex; align-items: center; gap: 12px; }
    .support-icon {
        width: 36px; height: 36px; border-radius: 9px;
        background: rgba(212,168,67,0.1);
        border: 1px solid rgba(212,168,67,0.2);
        display: flex; align-items: center; justify-content: center;
        color: var(--gold); font-size: 0.9rem;
    }
    .support-label { font-size: 0.72rem; color: var(--muted); }
    .support-link { font-size: 0.8rem; color: var(--gold); font-weight: 600; cursor: pointer; }

    @media (max-width: 960px) {
        .payment-grid { grid-template-columns: 1fr; }
        .status-card { position: static; }
        .page-wrap { padding: 40px 24px 80px; }
    }
    @media (max-width: 600px) {
        .checkout-steps .step-label { display: none; }
        .step-line { width: 40px; }
    }
</style>
@endpush

@section('content')
<div class="payment-page">
<div class="page-wrap">

    <div class="breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('cart.index') }}">Keranjang</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('checkout.index') }}">Checkout</a>
        <i class="bi bi-chevron-right"></i>
        <span>Pembayaran</span>
    </div>

    <div class="checkout-steps">
        <div class="step done"><div class="step-num"><i class="bi bi-check-lg"></i></div><div class="step-label">Keranjang</div></div>
        <div class="step-line active"></div>
        <div class="step done"><div class="step-num"><i class="bi bi-check-lg"></i></div><div class="step-label">Checkout</div></div>
        <div class="step-line active"></div>
        <div class="step active"><div class="step-num">3</div><div class="step-label">Pembayaran</div></div>
        <div class="step-line"></div>
        <div class="step"><div class="step-num">4</div><div class="step-label">Selesai</div></div>
    </div>

    <div class="payment-grid">

        <div>
            <div class="countdown-banner">
                <i class="bi bi-clock-history countdown-icon"></i>
                <div class="countdown-text">
                    <div class="countdown-label">Selesaikan pembayaran sebelum</div>
                    <div class="countdown-timer" id="countdownTimer">23:59:59</div>
                </div>
                <span class="status-pill {{ $order->status == 'paid' ? 'paid' : 'pending' }}">
                    <span class="status-pill-dot"></span> 
                    @if($order->status == 'paid')
                        Pembayaran Diterima
                    @else
                        {{ ucfirst($order->status) }}
                    @endif
                </span>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <i class="bi bi-qr-code"></i> Pembayaran via QRIS
                    </div>

                    <div class="qris-wrap">
                        <div class="qris-amount-label">Total Pembayaran</div>
                        <div class="qris-amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>

                        <div class="qris-frame">
                            <svg viewBox="0 0 176 176" xmlns="http://www.w3.org/2000/svg" fill="none">
                                <rect x="8" y="8" width="48" height="48" rx="4" fill="#000"/>
                                <rect x="14" y="14" width="36" height="36" rx="2" fill="#fff"/>
                                <rect x="20" y="20" width="24" height="24" rx="2" fill="#000"/>
                                <rect x="120" y="8" width="48" height="48" rx="4" fill="#000"/>
                                <rect x="126" y="14" width="36" height="36" rx="2" fill="#fff"/>
                                <rect x="132" y="20" width="24" height="24" rx="2" fill="#000"/>
                                <rect x="8" y="120" width="48" height="48" rx="4" fill="#000"/>
                                <rect x="14" y="126" width="36" height="36" rx="2" fill="#fff"/>
                                <rect x="20" y="132" width="24" height="24" rx="2" fill="#000"/>
                                <rect x="64" y="8" width="8" height="8" fill="#000"/>
                                <rect x="80" y="8" width="8" height="8" fill="#000"/>
                                <rect x="96" y="8" width="8" height="8" fill="#000"/>
                                <rect x="104" y="8" width="8" height="8" fill="#000"/>
                                <rect x="64" y="24" width="8" height="8" fill="#000"/>
                                <rect x="72" y="24" width="8" height="8" fill="#000"/>
                                <rect x="96" y="24" width="8" height="8" fill="#000"/>
                                <rect x="64" y="40" width="8" height="8" fill="#000"/>
                                <rect x="88" y="40" width="8" height="8" fill="#000"/>
                                <rect x="104" y="40" width="8" height="8" fill="#000"/>
                                <rect x="8" y="64" width="8" height="8" fill="#000"/>
                                <rect x="24" y="64" width="8" height="8" fill="#000"/>
                                <rect x="40" y="64" width="8" height="8" fill="#000"/>
                                <rect x="120" y="64" width="8" height="8" fill="#000"/>
                                <rect x="136" y="64" width="8" height="8" fill="#000"/>
                                <rect x="160" y="64" width="8" height="8" fill="#000"/>
                                <rect x="8" y="80" width="8" height="8" fill="#000"/>
                                <rect x="32" y="80" width="8" height="8" fill="#000"/>
                                <rect x="56" y="80" width="8" height="8" fill="#000"/>
                                <rect x="128" y="80" width="8" height="8" fill="#000"/>
                                <rect x="152" y="80" width="8" height="8" fill="#000"/>
                                <rect x="160" y="80" width="8" height="8" fill="#000"/>
                                <rect x="8" y="96" width="8" height="8" fill="#000"/>
                                <rect x="16" y="96" width="8" height="8" fill="#000"/>
                                <rect x="40" y="96" width="8" height="8" fill="#000"/>
                                <rect x="64" y="96" width="8" height="8" fill="#000"/>
                                <rect x="96" y="96" width="8" height="8" fill="#000"/>
                                <rect x="120" y="96" width="8" height="8" fill="#000"/>
                                <rect x="144" y="96" width="8" height="8" fill="#000"/>
                                <rect x="168" y="96" width="8" height="8" fill="#000"/>
                                <rect x="64" y="112" width="8" height="8" fill="#000"/>
                                <rect x="80" y="112" width="8" height="8" fill="#000"/>
                                <rect x="96" y="112" width="8" height="8" fill="#000"/>
                                <rect x="120" y="112" width="8" height="8" fill="#000"/>
                                <rect x="136" y="112" width="8" height="8" fill="#000"/>
                                <rect x="160" y="112" width="8" height="8" fill="#000"/>
                                <rect x="64" y="128" width="8" height="8" fill="#000"/>
                                <rect x="80" y="128" width="8" height="8" fill="#000"/>
                                <rect x="104" y="128" width="8" height="8" fill="#000"/>
                                <rect x="128" y="128" width="8" height="8" fill="#000"/>
                                <rect x="152" y="128" width="8" height="8" fill="#000"/>
                                <rect x="168" y="128" width="8" height="8" fill="#000"/>
                                <rect x="64" y="144" width="8" height="8" fill="#000"/>
                                <rect x="72" y="144" width="8" height="8" fill="#000"/>
                                <rect x="88" y="144" width="8" height="8" fill="#000"/>
                                <rect x="112" y="144" width="8" height="8" fill="#000"/>
                                <rect x="120" y="144" width="8" height="8" fill="#000"/>
                                <rect x="144" y="144" width="8" height="8" fill="#000"/>
                                <rect x="64" y="160" width="8" height="8" fill="#000"/>
                                <rect x="96" y="160" width="8" height="8" fill="#000"/>
                                <rect x="104" y="160" width="8" height="8" fill="#000"/>
                                <rect x="128" y="160" width="8" height="8" fill="#000"/>
                                <rect x="136" y="160" width="8" height="8" fill="#000"/>
                                <rect x="160" y="160" width="8" height="8" fill="#000"/>
                                <rect x="168" y="160" width="8" height="8" fill="#000"/>
                            </svg>
                            <div class="qris-logo">QRIS</div>
                        </div>

                        <div class="qris-instructions">
                            <div class="qris-step"><div class="qris-step-num">1</div><div class="qris-step-text">Buka aplikasi e-wallet atau mobile banking Anda</div></div>
                            <div class="qris-step"><div class="qris-step-num">2</div><div class="qris-step-text">Pilih menu <strong style="color:#fff;">Bayar / Scan QR</strong> lalu arahkan kamera ke QR code di atas</div></div>
                            <div class="qris-step"><div class="qris-step-num">3</div><div class="qris-step-text">Pastikan nominal <strong style="color:var(--gold);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> sudah benar</div></div>
                            <div class="qris-step"><div class="qris-step-num">4</div><div class="qris-step-text">Upload bukti pembayaran di bawah ini setelah transaksi berhasil</div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <i class="bi bi-cloud-upload"></i> Upload Bukti Pembayaran
                    </div>

                    <form id="paymentForm" action="{{ route('payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="upload-zone" id="uploadZone"
                             ondragover="handleDragOver(event)"
                             ondragleave="handleDragLeave(event)"
                             ondrop="handleDrop(event)">
                            <input type="file" id="fileInput" name="payment_proof" accept="image/*,.pdf" onchange="handleFileSelect(event)" style="display:none;">
                            <div class="upload-icon" onclick="document.getElementById('fileInput').click()">
                                <i class="bi bi-image"></i>
                            </div>
                            <div class="upload-title" onclick="document.getElementById('fileInput').click()">Klik atau seret file ke sini</div>
                            <div class="upload-hint">Screenshot atau foto struk pembayaran QRIS Anda</div>
                            <div class="upload-formats">
                                <span class="upload-format-tag">JPG</span>
                                <span class="upload-format-tag">PNG</span>
                                <span class="upload-format-tag">PDF</span>
                                <span class="upload-format-tag">Max 5MB</span>
                            </div>
                        </div>

                        <div class="upload-preview" id="uploadPreview">
                            <img id="previewImg" src="" alt="Preview">
                            <div class="upload-preview-overlay">
                                <span class="preview-name" id="previewName">bukti_bayar.jpg</span>
                                <button type="button" class="preview-remove" onclick="removeFile()">
                                    <i class="bi bi-x-circle"></i> Hapus
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit" id="submitBtn" disabled>
                            <i class="bi bi-send"></i> Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div>
            <div class="status-card">
                <div class="status-header">
                    <div class="status-title">Status Pembayaran</div>
                </div>

                <div class="order-info-box">
                    <div class="order-info-row">
                        <span class="oinfo-label">No. Pesanan</span>
                        <span class="oinfo-val">{{ $order->order_number }}</span>
                    </div>
                    <div class="order-info-row">
                        <span class="oinfo-label">Tanggal</span>
                        <span class="oinfo-val">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="order-info-row">
                        <span class="oinfo-label">Metode</span>
                        <span class="oinfo-val">QRIS</span>
                    </div>
                    <div class="order-info-row">
                        <span class="oinfo-label">Total</span>
                        <span class="oinfo-val amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="status-timeline">
                    <div class="timeline-item done">
                        <div class="timeline-dot"><i class="bi bi-check-lg"></i></div>
                        <div class="timeline-content">
                            <div class="timeline-label">Pesanan Dibuat</div>
                            <div class="timeline-desc">Pesanan berhasil dibuat</div>
                            <div class="timeline-time">{{ $order->created_at->format('H:i') }} WIB</div>
                        </div>
                    </div>

                    <div class="timeline-item" id="paymentStep">
                        <div class="timeline-dot"><i class="bi bi-clock"></i></div>
                        <div class="timeline-content">
                            <div class="timeline-label">Menunggu Pembayaran</div>
                            <div class="timeline-desc">Lakukan pembayaran via QRIS & upload bukti</div>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-dot"><i class="bi bi-shield-check"></i></div>
                        <div class="timeline-content">
                            <div class="timeline-label">Pembayaran Dikonfirmasi</div>
                            <div class="timeline-desc">Pembayaran diterima, pesanan segera diproses</div>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-dot"><i class="bi bi-truck"></i></div>
                        <div class="timeline-content">
                            <div class="timeline-label">Dikirim</div>
                            <div class="timeline-desc">Produk dalam perjalanan ke alamat Anda</div>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-dot"><i class="bi bi-check2-all"></i></div>
                        <div class="timeline-content">
                            <div class="timeline-label">Selesai</div>
                            <div class="timeline-desc">Pesanan telah sampai tujuan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
function startCountdown(seconds) {
    const el = document.getElementById('countdownTimer');
    const tick = () => {
        const h = String(Math.floor(seconds / 3600)).padStart(2,'0');
        const m = String(Math.floor((seconds % 3600) / 60)).padStart(2,'0');
        const s = String(seconds % 60).padStart(2,'0');
        el.textContent = h + ':' + m + ':' + s;
        if (seconds > 0) { seconds--; setTimeout(tick, 1000); }
        else { el.textContent = '00:00:00'; el.style.color = '#f87171'; }
    };
    tick();
}
startCountdown(86399);

function handleFileSelect(e) {
    const file = e.target.files[0];
    if (file) showPreview(file);
}

function handleDragOver(e) { e.preventDefault(); document.getElementById('uploadZone').classList.add('dragover'); }
function handleDragLeave(e) { document.getElementById('uploadZone').classList.remove('dragover'); }
function handleDrop(e) {
    e.preventDefault();
    document.getElementById('uploadZone').classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file) showPreview(file);
    document.getElementById('fileInput').files = e.dataTransfer.files;
}

function showPreview(file) {
    const preview = document.getElementById('uploadPreview');
    const img = document.getElementById('previewImg');
    const name = document.getElementById('previewName');
    name.textContent = file.name;
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; };
        reader.readAsDataURL(file);
    } else {
        img.src = 'https://via.placeholder.com/400x200?text=PDF+File';
    }
    preview.style.display = 'block';
    document.getElementById('submitBtn').disabled = false;
}

function removeFile() {
    document.getElementById('uploadPreview').style.display = 'none';
    document.getElementById('fileInput').value = '';
    document.getElementById('submitBtn').disabled = true;
}

// Update timeline after upload
@if($order->status == 'paid')
    document.getElementById('paymentStep').classList.remove('active');
    document.getElementById('paymentStep').classList.add('done');
    document.querySelector('.timeline-item.active').classList.remove('active');
    document.querySelectorAll('.timeline-item')[2].classList.add('active');
@endif
</script>
@endpush