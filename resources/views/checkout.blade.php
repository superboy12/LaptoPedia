{{-- resources/views/checkout.blade.php --}}
@extends('layouts.app')

@push('styles')
<style>
    /* ===== PAGE WRAPPER ===== */
    .checkout-page {
        min-height: 100vh;
        background: var(--black);
        padding: 52px 0 0;
    }

    .page-wrap {
        max-width: 1280px;
        margin: 0 auto;
        padding: 64px 48px 120px;
    }

    /* ===== BREADCRUMB ===== */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 48px;
    }
    .breadcrumb a {
        font-size: 0.78rem;
        color: var(--muted);
        transition: color 0.2s;
        text-decoration: none;
    }
    .breadcrumb a:hover { color: var(--white); }
    .breadcrumb i { font-size: 0.65rem; color: rgba(255,255,255,0.2); }
    .breadcrumb span {
        font-size: 0.78rem;
        color: var(--gold);
        font-weight: 600;
    }

    /* ===== PROGRESS STEPS ===== */
    .checkout-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        margin-bottom: 64px;
    }

    .step {
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
    }

    .step-line {
        width: 80px;
        height: 1px;
        background: rgba(255,255,255,0.1);
        margin: 0 4px;
    }
    .step-line.active { background: var(--gold); }

    .step-num {
        width: 34px; height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Manrope', sans-serif;
        font-size: 0.75rem;
        font-weight: 800;
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--muted);
        background: var(--surface);
        transition: all 0.3s;
    }
    .step.active .step-num {
        background: var(--gold);
        border-color: var(--gold);
        color: #000;
    }
    .step.done .step-num {
        background: rgba(212,168,67,0.15);
        border-color: rgba(212,168,67,0.4);
        color: var(--gold);
    }

    .step-label {
        font-size: 0.73rem;
        font-weight: 600;
        color: var(--muted);
        white-space: nowrap;
    }
    .step.active .step-label { color: var(--white); }
    .step.done .step-label { color: var(--gold); }

    /* ===== LAYOUT GRID ===== */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 32px;
        align-items: start;
    }

    /* ===== CARDS ===== */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 20px;
        transition: border-color 0.3s;
    }
    .card:hover { border-color: rgba(255,255,255,0.12); }

    .card-title {
        font-family: 'Manrope', sans-serif;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .card-title i { font-size: 0.85rem; }

    /* ===== FORM ELEMENTS ===== */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 14px;
    }
    .form-row.full { grid-template-columns: 1fr; }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .form-label {
        font-size: 0.73rem;
        font-weight: 600;
        color: rgba(255,255,255,0.5);
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .form-input {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 12px 14px;
        color: var(--white);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem;
        transition: border-color 0.2s, background 0.2s;
        outline: none;
    }
    .form-input:focus {
        border-color: rgba(212,168,67,0.5);
        background: rgba(212,168,67,0.04);
    }
    .form-input::placeholder { color: rgba(255,255,255,0.2); }

    select.form-input option { background: #1a1a1a; }

    /* ===== PAYMENT METHODS ===== */
    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .payment-option {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 18px;
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }
    .payment-option:hover {
        border-color: rgba(255,255,255,0.15);
        background: rgba(255,255,255,0.05);
    }
    .payment-option.selected {
        border-color: rgba(212,168,67,0.45);
        background: rgba(212,168,67,0.05);
    }

    .payment-radio {
        width: 18px; height: 18px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: border-color 0.2s;
    }
    .payment-option.selected .payment-radio {
        border-color: var(--gold);
    }
    .payment-radio-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: var(--gold);
        display: none;
    }
    .payment-option.selected .payment-radio-dot { display: block; }

    .payment-icon-wrap {
        width: 42px; height: 32px;
        border-radius: 7px;
        background: rgba(255,255,255,0.07);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: var(--white);
    }

    .payment-info { flex: 1; }
    .payment-name {
        font-family: 'Manrope', sans-serif;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 2px;
    }
    .payment-desc { font-size: 0.75rem; color: var(--muted); }

    .payment-badge {
        font-size: 0.6rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 3px 8px;
        border-radius: 100px;
        background: rgba(16,185,129,0.15);
        color: #10b981;
        border: 1px solid rgba(16,185,129,0.2);
    }

    /* ===== ORDER SUMMARY ===== */
    .summary-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        position: sticky;
        top: 72px;
    }

    .summary-header {
        padding: 24px 28px;
        border-bottom: 1px solid var(--border);
    }

    .summary-title {
        font-family: 'Manrope', sans-serif;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--gold);
    }

    .summary-items {
        padding: 20px 28px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        border-bottom: 1px solid var(--border);
    }

    .summary-item {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .item-img {
        width: 54px; height: 42px;
        border-radius: 8px;
        background: linear-gradient(145deg, #222, #161616);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
        position: relative;
    }
    .item-img img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .item-info { flex: 1; }
    .item-name {
        font-family: 'Manrope', sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 3px;
    }
    .item-meta { font-size: 0.72rem; color: var(--muted); }

    .item-price {
        font-family: 'Manrope', sans-serif;
        font-size: 0.88rem;
        font-weight: 800;
        color: var(--white);
        white-space: nowrap;
    }

    /* Qty badge */
    .qty-badge {
        position: relative;
    }
    .qty-badge::after {
        content: attr(data-qty);
        position: absolute;
        top: -5px; right: -5px;
        background: var(--gold);
        color: #000;
        font-size: 0.58rem;
        font-weight: 800;
        min-width: 16px;
        height: 16px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 3px;
    }

    /* ===== SUMMARY ROWS ===== */
    .summary-rows {
        padding: 20px 28px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        border-bottom: 1px solid var(--border);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .row-label { font-size: 0.82rem; color: var(--muted); }
    .row-val { font-size: 0.82rem; color: var(--white); font-weight: 500; }
    .row-val.free { color: #10b981; font-weight: 700; }
    .row-val.discount { color: #f87171; }

    .summary-total {
        padding: 20px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border);
    }

    .total-label {
        font-family: 'Manrope', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--white);
    }

    .total-val {
        font-family: 'Manrope', sans-serif;
        font-size: 1.3rem;
        font-weight: 900;
        color: var(--gold);
        letter-spacing: -0.04em;
    }

    /* ===== CTA BUTTON ===== */
    .btn-checkout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        background: var(--white);
        color: #000;
        font-family: 'Manrope', sans-serif;
        font-weight: 800;
        font-size: 0.9rem;
        padding: 17px 28px;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        letter-spacing: -0.01em;
    }
    .btn-checkout:hover {
        background: #e8e8e8;
        transform: scale(1.01);
    }

    .btn-checkout-wrap { padding: 20px 28px; }

    .summary-note {
        padding: 0 28px 20px;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .summary-note i { font-size: 0.75rem; color: var(--muted); }
    .summary-note span { font-size: 0.72rem; color: var(--muted); line-height: 1.5; }

    /* ===== COUPON STRIP ===== */
    .coupon-strip {
        display: flex;
        gap: 10px;
        margin-top: 14px;
    }
    .coupon-input {
        flex: 1;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 11px 14px;
        color: var(--white);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.82rem;
        outline: none;
        transition: border-color 0.2s;
    }
    .coupon-input:focus { border-color: rgba(212,168,67,0.4); }
    .coupon-input::placeholder { color: rgba(255,255,255,0.2); }
    .btn-coupon {
        padding: 11px 18px;
        background: rgba(212,168,67,0.12);
        border: 1px solid rgba(212,168,67,0.3);
        border-radius: 10px;
        color: var(--gold);
        font-family: 'Manrope', sans-serif;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-coupon:hover {
        background: rgba(212,168,67,0.2);
        border-color: rgba(212,168,67,0.5);
    }

    /* Alert message */
    .alert-message {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 0.8rem;
    }
    .alert-error {
        background: rgba(220, 38, 38, 0.1);
        border: 1px solid rgba(220, 38, 38, 0.3);
        color: #f87171;
    }
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981;
    }

    /* Loading state */
    .btn-loading {
        opacity: 0.7;
        pointer-events: none;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 960px) {
        .checkout-grid { grid-template-columns: 1fr; }
        .summary-card { position: static; }
        .page-wrap { padding: 40px 24px 80px; }
    }
    @media (max-width: 600px) {
        .form-row { grid-template-columns: 1fr; }
        .checkout-steps { gap: 0; }
        .step-line { width: 40px; }
        .step-label { display: none; }
    }
</style>
@endpush

@section('content')
<div class="checkout-page">
<div class="page-wrap">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('cart.index') }}">Keranjang</a>
        <i class="bi bi-chevron-right"></i>
        <span>Checkout</span>
    </div>

    <!-- PROGRESS STEPS -->
    <div class="checkout-steps">
        <div class="step done">
            <div class="step-num"><i class="bi bi-check-lg"></i></div>
            <div class="step-label">Keranjang</div>
        </div>
        <div class="step-line active"></div>
        <div class="step active">
            <div class="step-num">2</div>
            <div class="step-label">Checkout</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-num">3</div>
            <div class="step-label">Pembayaran</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-num">4</div>
            <div class="step-label">Selesai</div>
        </div>
    </div>

    <!-- Alert Messages -->
    <div id="alertContainer"></div>

    <!-- MAIN GRID -->
    <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="checkout-grid">

            <!-- LEFT: FORMS -->
            <div>

                <!-- ALAMAT PENGIRIMAN -->
                <div class="card">
                    <div class="card-title">
                        <i class="bi bi-geo-alt"></i> Alamat Pengiriman
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nama Depan</label>
                            <input type="text" name="first_name" class="form-input" placeholder="John" value="{{ old('first_name', $user->nama_depan ?? '') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Belakang</label>
                            <input type="text" name="last_name" class="form-input" placeholder="Doe" value="{{ old('last_name', $user->nama_belakang ?? '') }}">
                        </div>
                    </div>

                    <div class="form-row full">
                        <div class="form-group">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="tel" name="phone" class="form-input" placeholder="+62 812 3456 7890" value="{{ old('phone', $user->phone ?? '') }}" required>
                        </div>
                    </div>

                    <div class="form-row full" style="margin-bottom:14px;">
                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap</label>
                            <input type="text" name="address" class="form-input" placeholder="Jl. Merdeka No. 17, RT 02/RW 05" value="{{ old('address') }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kota</label>
                            <input type="text" name="city" class="form-input" placeholder="Bandar Lampung" value="{{ old('city') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="postal_code" class="form-input" placeholder="35145" value="{{ old('postal_code') }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Provinsi</label>
                            <select name="province" class="form-input" id="provinceSelect" required>
                                <option value="">Pilih Provinsi</option>
                                <option value="lampung" {{ old('province') == 'lampung' ? 'selected' : '' }}>Lampung</option>
                                <option value="jakarta" {{ old('province') == 'jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                                <option value="jabar" {{ old('province') == 'jabar' ? 'selected' : '' }}>Jawa Barat</option>
                                <option value="jateng" {{ old('province') == 'jateng' ? 'selected' : '' }}>Jawa Tengah</option>
                                <option value="jatim" {{ old('province') == 'jatim' ? 'selected' : '' }}>Jawa Timur</option>
                                <option value="bali" {{ old('province') == 'bali' ? 'selected' : '' }}>Bali</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Layanan Pengiriman</label>
                            <select name="shipping_service" class="form-input" id="shippingSelect" required>
                                <option value="jne_reg" {{ old('shipping_service') == 'jne_reg' ? 'selected' : '' }}>JNE REG (2-3 hari)</option>
                                <option value="jne_yes" {{ old('shipping_service') == 'jne_yes' ? 'selected' : '' }}>JNE YES (1 hari)</option>
                                <option value="jnt" {{ old('shipping_service') == 'jnt' ? 'selected' : '' }}>J&T Express (2-4 hari)</option>
                                <option value="sicepat" {{ old('shipping_service') == 'sicepat' ? 'selected' : '' }}>SiCepat BEST</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- METODE PEMBAYARAN -->
                <div class="card">
                    <div class="card-title">
                        <i class="bi bi-credit-card"></i> Metode Pembayaran
                    </div>

                    <div class="payment-methods">
                        <div class="payment-option selected" data-payment="qris" onclick="selectPayment(this)">
                            <div class="payment-radio"><div class="payment-radio-dot"></div></div>
                            <div class="payment-icon-wrap">
                                <i class="bi bi-qr-code"></i>
                            </div>
                            <div class="payment-info">
                                <div class="payment-name">QRIS</div>
                                <div class="payment-desc">GoPay · OVO · DANA · ShopeePay · semua bank</div>
                            </div>
                            <span class="payment-badge">Direkomendasikan</span>
                        </div>

                        <div class="payment-option" data-payment="transfer_bank" onclick="selectPayment(this)">
                            <div class="payment-radio"><div class="payment-radio-dot"></div></div>
                            <div class="payment-icon-wrap">
                                <i class="bi bi-bank"></i>
                            </div>
                            <div class="payment-info">
                                <div class="payment-name">Transfer Bank</div>
                                <div class="payment-desc">BCA · Mandiri · BNI · BRI</div>
                            </div>
                        </div>

                        <div class="payment-option" data-payment="ewallet" onclick="selectPayment(this)">
                            <div class="payment-radio"><div class="payment-radio-dot"></div></div>
                            <div class="payment-icon-wrap">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <div class="payment-info">
                                <div class="payment-name">E-Wallet</div>
                                <div class="payment-desc">GoPay · OVO · DANA · ShopeePay</div>
                            </div>
                        </div>

                        <div class="payment-option" data-payment="cod" onclick="selectPayment(this)">
                            <div class="payment-radio"><div class="payment-radio-dot"></div></div>
                            <div class="payment-icon-wrap">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="payment-info">
                                <div class="payment-name">COD (Bayar di Tempat)</div>
                                <div class="payment-desc">Tersedia untuk area tertentu</div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="payment_method" id="paymentMethod" value="qris">

                    <!-- COUPON -->
                    <div style="margin-top:22px;padding-top:22px;border-top:1px solid var(--border);">
                        <div class="form-label" style="margin-bottom:8px;">Kode Kupon / Promo</div>
                        <div class="coupon-strip">
                            <input type="text" class="coupon-input" placeholder="Masukkan kode kupon…" id="couponInput">
                            <button type="button" class="btn-coupon" onclick="applyCoupon()">Terapkan</button>
                        </div>
                        <div id="couponMessage" style="font-size: 0.7rem; margin-top: 8px;"></div>
                    </div>
                </div>

                <!-- CATATAN -->
                <div class="card">
                    <div class="card-title">
                        <i class="bi bi-chat-square-text"></i> Catatan Pesanan (Opsional)
                    </div>
                    <textarea name="notes" class="form-input" rows="3" placeholder="Instruksi khusus untuk pengiriman, dll…" style="resize:vertical;min-height:80px;">{{ old('notes') }}</textarea>
                </div>

            </div>

            <!-- RIGHT: ORDER SUMMARY -->
            <div>
                <div class="summary-card">
                    <div class="summary-header">
                        <div class="summary-title">Ringkasan Pesanan</div>
                    </div>

                    <!-- ITEMS - Dynamic from cart -->
                    <div class="summary-items" id="cartItemsContainer">
                        @php
                            $subtotal = 0;
                        @endphp
                        @forelse($cartItems as $item)
                            @php
                                $itemTotal = $item->price * $item->quantity;
                                $subtotal += $itemTotal;
                            @endphp
                            <div class="summary-item" data-item-id="{{ $item->id }}">
                                <div class="item-img qty-badge" data-qty="{{ $item->quantity }}">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                    @else
                                        <i class="bi bi-cart" style="color: var(--muted);"></i>
                                    @endif
                                </div>
                                <div class="item-info">
                                    <div class="item-name">{{ $item->product->name ?? 'Product' }}</div>
                                    <div class="item-meta">{{ $item->variant ?? 'Standard' }}</div>
                                </div>
                                <div class="item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                            </div>
                        @empty
                            <div class="summary-item">
                                <div class="item-info">
                                    <div class="item-name">Keranjang belanja kosong</div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- ROWS - Dynamic -->
                    <div class="summary-rows">
                        <div class="summary-row">
                            <span class="row-label">Subtotal</span>
                            <span class="row-val" id="subtotalVal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="row-label">Ongkos Kirim</span>
                            <span class="row-val" id="shippingCostVal">Rp {{ number_format($shippingCost ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row" id="discountRow" style="{{ ($discount ?? 0) > 0 ? '' : 'display:none;' }}">
                            <span class="row-label">Diskon Promo</span>
                            <span class="row-val discount" id="discountVal">− Rp {{ number_format($discount ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="row-label">Asuransi Pengiriman</span>
                            <span class="row-val" id="insuranceVal">Rp {{ number_format($insurance ?? 15000, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- TOTAL -->
                    <div class="summary-total">
                        <span class="total-label">Total Pembayaran</span>
                        <span class="total-val" id="totalVal">Rp {{ number_format(($subtotal + ($shippingCost ?? 0) + ($insurance ?? 15000) - ($discount ?? 0)), 0, ',', '.') }}</span>
                    </div>

                    <!-- CTA -->
                    <div class="btn-checkout-wrap">
                        <button type="submit" class="btn-checkout" id="submitBtn">
                            Lanjut ke Pembayaran <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                    <div class="summary-note">
                        <i class="bi bi-shield-lock"></i>
                        <span>Transaksi aman & terenkripsi SSL 256-bit. Data Anda terlindungi.</span>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
</div>
@endsection

@push('scripts')
<script>
    // Variabel global untuk menyimpan state
    let currentSubtotal = {{ $subtotal ?? 0 }};
    let currentShipping = {{ $shippingCost ?? 0 }};
    let currentInsurance = {{ $insurance ?? 15000 }};
    let currentDiscount = {{ $discount ?? 0 }};
    let appliedCouponCode = null;

    // Select payment method
    function selectPayment(el) {
        document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('selected'));
        el.classList.add('selected');
        const paymentMethod = el.getAttribute('data-payment');
        document.getElementById('paymentMethod').value = paymentMethod;
        
        // Update shipping cost based on payment method? (optional)
        if (paymentMethod === 'cod') {
            // Maybe add COD fee
            updateShippingCost(currentShipping + 5000);
        } else {
            updateShippingCost(currentShipping);
        }
    }

    // Update shipping cost
    function updateShippingCost(newCost) {
        currentShipping = newCost;
        document.getElementById('shippingCostVal').innerText = formatRupiah(currentShipping);
        updateTotal();
    }

    // Update total display
    function updateTotal() {
        const total = currentSubtotal + currentShipping + currentInsurance - currentDiscount;
        document.getElementById('totalVal').innerHTML = formatRupiah(total);
    }

    // Format Rupiah
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }

    // Apply coupon via AJAX
    async function applyCoupon() {
        const couponCode = document.getElementById('couponInput').value.trim();
        if (!couponCode) {
            showMessage('Masukkan kode kupon terlebih dahulu!', 'error');
            return;
        }

        const btn = event.currentTarget;
        const originalText = btn.innerText;
        btn.innerText = 'Memproses...';
        btn.disabled = true;

        try {
            const response = await fetch('{{ route("checkout.applyCoupon") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ coupon_code: couponCode })
            });

            const data = await response.json();

            if (data.success) {
                currentDiscount = data.discount_amount;
                appliedCouponCode = couponCode;
                document.getElementById('discountRow').style.display = 'flex';
                document.getElementById('discountVal').innerHTML = '− ' + formatRupiah(currentDiscount);
                document.getElementById('couponMessage').innerHTML = '<span style="color: #10b981;">✓ ' + data.message + '</span>';
                updateTotal();
                showMessage(data.message, 'success');
            } else {
                document.getElementById('couponMessage').innerHTML = '<span style="color: #f87171;">✗ ' + data.message + '</span>';
                showMessage(data.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showMessage('Terjadi kesalahan, silakan coba lagi.', 'error');
        } finally {
            btn.innerText = originalText;
            btn.disabled = false;
        }
    }

    // Show alert message
    function showMessage(message, type) {
        const container = document.getElementById('alertContainer');
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert-message alert-${type}`;
        alertDiv.innerHTML = message;
        container.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }

    // Form validation before submit
    document.getElementById('checkoutForm')?.addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.classList.add('btn-loading');
        submitBtn.innerHTML = 'Memproses... <i class="bi bi-hourglass-split"></i>';
        
        // Basic validation
        const requiredFields = ['first_name', 'phone', 'address', 'city', 'postal_code'];
        let isValid = true;
        
        for (let field of requiredFields) {
            const input = document.querySelector(`[name="${field}"]`);
            if (input && !input.value.trim()) {
                isValid = false;
                showMessage(`Field ${field.replace('_', ' ')} harus diisi!`, 'error');
                e.preventDefault();
                submitBtn.classList.remove('btn-loading');
                submitBtn.innerHTML = 'Lanjut ke Pembayaran <i class="bi bi-arrow-right"></i>';
                break;
            }
        }
        
        if (!isValid) return;
        
        // Add coupon code to form if applied
        if (appliedCouponCode) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'coupon_code';
            hiddenInput.value = appliedCouponCode;
            this.appendChild(hiddenInput);
        }
    });

    // Update shipping cost when shipping service changes
    document.getElementById('shippingSelect')?.addEventListener('change', async function() {
        const shippingService = this.value;
        const province = document.getElementById('provinceSelect').value;
        
        if (!province) {
            showMessage('Pilih provinsi terlebih dahulu!', 'error');
            return;
        }
        
        try {
            const response = await fetch('{{ route("checkout.shippingCost") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    shipping_service: shippingService,
                    province: province,
                    subtotal: currentSubtotal
                })
            });
            
            const data = await response.json();
            if (data.success) {
                updateShippingCost(data.cost);
            }
        } catch (error) {
            console.error('Error fetching shipping cost:', error);
        }
    });

    // Initialize payment method on load
    document.addEventListener('DOMContentLoaded', function() {
        const selectedPayment = document.querySelector('.payment-option.selected');
        if (selectedPayment) {
            document.getElementById('paymentMethod').value = selectedPayment.getAttribute('data-payment');
        }
    });
</script>
@endpush