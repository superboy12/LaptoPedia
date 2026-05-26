@extends('layouts.app')

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
.checkout-page {
    padding-top: 52px;
    min-height: 100vh;
    background: var(--bg);
}

.checkout-header {
    background: var(--bg);
    padding: 100px 24px 60px;
    text-align: center;
}
.checkout-header h1 {
    font-family: 'Manrope', sans-serif;
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    color: var(--text);
    margin-bottom: 16px;
    letter-spacing: -0.04em;
}
.checkout-header h1 span {
    background: linear-gradient(to right, #f0d080, #d4a843);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.checkout-header p {
    color: var(--text-muted);
    font-size: 1rem;
    opacity: 0.8;
}

.checkout-layout {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 48px 120px;
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 60px;
    align-items: start;
}

/* Sections */
.co-section {
    background: var(--surface);
    backdrop-filter: blur(10px);
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 40px;
    margin-bottom: 32px;
}
.co-title {
    font-family: 'Manrope', sans-serif;
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--text);
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.co-title i { color: var(--gold); }

/* Form Group */
.form-group { margin-bottom: 25px; }
.form-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--text-muted);
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.form-input, .form-textarea {
    width: 100%;
    background: var(--bg);
    border: 1px solid var(--border);
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.95rem;
    padding: 14px 20px;
    border-radius: 12px;
    outline: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.form-input:focus, .form-textarea:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 4px rgba(212, 168, 67, 0.1);
    background: var(--surface-2);
}
.form-textarea { resize: vertical; min-height: 100px; }

/* Grid & Icons for detailed form */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
@media (max-width: 600px) {
    .form-row { grid-template-columns: 1fr; gap: 0; }
}
.input-with-icon { position: relative; }
.input-with-icon .form-input { padding-left: 48px; }
.input-with-icon i {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 1.1rem;
    transition: color 0.3s;
    pointer-events: none;
}
.input-with-icon .form-input:focus ~ i { color: var(--gold); }

.form-section-title {
    font-family: 'Manrope', sans-serif;
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--text);
    margin: 30px 0 20px;
    padding-bottom: 10px;
    border-bottom: 1px dashed var(--border);
    display: flex; align-items: center; gap: 8px;
}
.form-section-title i { color: var(--gold); }

/* ── CUSTOM SEARCHABLE DROPDOWN ── */
.csdd-wrap {
    position: relative;
}
.csdd-trigger {
    width: 100%;
    background: var(--bg);
    border: 1px solid var(--border);
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.95rem;
    padding: 14px 48px 14px 48px;
    border-radius: 12px;
    outline: none;
    cursor: pointer;
    text-align: left;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex; align-items: center; justify-content: space-between;
    gap: 8px;
    user-select: none;
}
.csdd-trigger.open,
.csdd-trigger:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 4px rgba(212, 168, 67, 0.1);
    background: var(--surface-2);
}
.csdd-trigger.disabled {
    opacity: 0.45;
    cursor: not-allowed;
}
.csdd-trigger .csdd-icon-left {
    position: absolute;
    left: 18px;
    color: var(--text-muted);
    font-size: 1.1rem;
    transition: color 0.3s;
    pointer-events: none;
}
.csdd-trigger.open .csdd-icon-left { color: var(--gold); }
.csdd-trigger .csdd-chevron {
    position: absolute;
    right: 16px;
    color: var(--text-muted);
    font-size: 0.85rem;
    transition: transform 0.25s ease;
    pointer-events: none;
}
.csdd-trigger.open .csdd-chevron { transform: rotate(180deg); color: var(--gold); }
.csdd-placeholder { color: var(--text-muted); }
.csdd-selected { color: var(--text); font-weight: 600; }

.csdd-panel {
    position: absolute;
    top: calc(100% + 8px);
    left: 0; right: 0;
    background: var(--surface);
    border: 1px solid rgba(212,168,67,0.3);
    border-radius: 14px;
    box-shadow: 0 24px 60px rgba(0,0,0,0.28);
    z-index: 9000;
    overflow: hidden;
    opacity: 0;
    transform: translateY(-6px);
    pointer-events: none;
    transition: opacity 0.2s ease, transform 0.2s ease;
}
.csdd-panel.open {
    opacity: 1;
    transform: translateY(0);
    pointer-events: all;
}
.csdd-search-wrap {
    padding: 10px 12px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--bg);
}
.csdd-search-wrap i { color: var(--text-muted); font-size: 0.9rem; flex-shrink: 0; }
.csdd-search {
    flex: 1;
    background: none;
    border: none;
    outline: none;
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.87rem;
}
.csdd-search::placeholder { color: var(--text-muted); }
.csdd-list {
    max-height: 220px;
    overflow-y: auto;
    padding: 6px 0;
}
.csdd-list::-webkit-scrollbar { width: 4px; }
.csdd-list::-webkit-scrollbar-thumb { background: var(--surface-2); border-radius: 2px; }
.csdd-option {
    padding: 10px 16px;
    font-size: 0.88rem;
    color: var(--text-muted);
    cursor: pointer;
    transition: background 0.15s, color 0.15s;
    display: flex; align-items: center; gap: 8px;
}
.csdd-option:hover { background: var(--search-bg); color: var(--text); }
.csdd-option.selected {
    background: var(--gold-dim);
    color: var(--gold);
    font-weight: 700;
}
.csdd-option .csdd-opt-check {
    margin-left: auto;
    opacity: 0;
    color: var(--gold);
    font-size: 0.8rem;
}
.csdd-option.selected .csdd-opt-check { opacity: 1; }
.csdd-loading, .csdd-empty {
    padding: 16px;
    text-align: center;
    font-size: 0.82rem;
    color: var(--text-muted);
}
.csdd-loading i { animation: spin 1s linear infinite; display: inline-block; }
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

/* Map */
#map {
    width: 100%;
    height: 350px;
    border-radius: 16px;
    border: 1px solid var(--border);
    margin-bottom: 15px;
}

/* Payment Options */
.payment-methods {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.pay-method-label { cursor: pointer; }
.pay-method-label input { display: none; }
.pay-method-box {
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    text-align: center;
    transition: all 0.3s;
    background: var(--bg);
}
.pay-method-label input:checked + .pay-method-box {
    border-color: var(--gold);
    background: rgba(212,168,67,0.05);
}
.pay-method-box i {
    font-size: 2rem;
    color: var(--text-muted);
    margin-bottom: 12px;
    display: block;
}
.pay-method-label input:checked + .pay-method-box i { color: var(--gold); }
.pay-method-box span {
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--text);
}

/* Order Summary Sidebar */
.summary-box {
    background: var(--surface);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border);
    border-radius: 32px;
    padding: 40px;
    position: sticky;
    top: 100px;
}
.summary-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding-bottom: 18px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 18px;
}
.summary-img {
    width: 60px; height: 60px;
    border-radius: 10px;
    background: var(--surface-2);
    display: flex; align-items: center; justify-content: center;
    padding: 8px;
}
.summary-img img { max-width: 100%; max-height: 100%; object-fit: contain; }
.summary-name { font-size: 0.9rem; font-weight: 700; color: var(--text); line-height: 1.4; }
.summary-qty { font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; }
.summary-price { font-weight: 800; font-size: 0.95rem; color: var(--gold); margin-left: auto; }

.summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.95rem;
    color: var(--text-muted);
    margin-bottom: 15px;
}
.summary-total {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--text);
    padding-top: 25px;
    border-top: 1px solid var(--border);
    margin-bottom: 30px;
}

.btn-checkout {
    width: 100%;
    background: linear-gradient(135deg, #f0d080, #d4a843);
    color: #000;
    border: none;
    padding: 18px;
    border-radius: 100px;
    font-family: 'Manrope', sans-serif;
    font-weight: 800;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
    display: flex; align-items: center; justify-content: center; gap: 10px;
}
.btn-checkout:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(212,168,67,0.3);
}


/* ── Kupon Input ── */
.coupon-input-wrap {
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px dashed var(--border);
}
.coupon-input-label {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.coupon-input-label i { color: var(--gold); }
.coupon-input-row {
    display: flex;
    gap: 8px;
}
.coupon-input-field {
    flex: 1;
    background: var(--bg);
    border: 1px solid var(--border);
    color: var(--text);
    font-family: 'Manrope', sans-serif;
    font-size: 0.88rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    padding: 11px 16px;
    border-radius: 10px;
    outline: none;
    text-transform: uppercase;
    transition: all 0.3s;
}
.coupon-input-field::placeholder {
    text-transform: none;
    font-weight: 400;
    letter-spacing: 0;
    color: var(--text-muted);
}
.coupon-input-field:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(212,168,67,0.12);
}
.coupon-input-field.is-valid {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
}
.coupon-input-field.is-invalid {
    border-color: #f87171;
    box-shadow: 0 0 0 3px rgba(248,113,113,0.1);
}
.coupon-apply-btn {
    background: linear-gradient(135deg, #f0d080, #d4a843);
    color: #000;
    border: none;
    font-family: 'Manrope', sans-serif;
    font-weight: 800;
    font-size: 0.82rem;
    padding: 11px 18px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s;
    white-space: nowrap;
}
.coupon-apply-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(212,168,67,0.3);
}
.coupon-apply-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}
.coupon-feedback {
    font-size: 0.78rem;
    font-weight: 600;
    margin-top: 8px;
    display: none;
    align-items: center;
    gap: 5px;
    line-height: 1.4;
}
.coupon-feedback.success { display: flex; color: #10b981; }
.coupon-feedback.error   { display: flex; color: #f87171; }
.coupon-feedback.freeship { display: flex; color: #60a5fa; }

.coupon-applied-badge {
    display: none;
    align-items: center;
    justify-content: space-between;
    background: rgba(16,185,129,0.08);
    border: 1px solid rgba(16,185,129,0.25);
    border-radius: 10px;
    padding: 10px 14px;
    margin-top: 10px;
    font-size: 0.8rem;
}
.coupon-applied-badge.show { display: flex; }
.coupon-applied-badge span { font-weight: 700; color: #10b981; }
.coupon-remove-btn {
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    font-size: 0.85rem;
    padding: 2px 4px;
    border-radius: 4px;
    transition: color 0.2s;
}
.coupon-remove-btn:hover { color: #f87171; }

@media (max-width: 1000px) {
    .checkout-layout { grid-template-columns: 1fr; padding: 0 24px 80px; }
    .summary-box { position: static; margin-top: 40px; }
}

@media (max-width: 900px) {
    .checkout-layout { grid-template-columns: 1fr; }
    .summary-box { position: static; }
}
</style>
@endpush

@section('content')
<div class="checkout-page">

    <div class="checkout-header">
        <h1><span>Proses</span> Checkout</h1>
        <p>Lengkapi detail pengiriman dan konfirmasi pesanan Anda.</p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="checkout-layout">

            {{-- LEFT: FORMS --}}
            <div class="co-left">
                
                {{-- Alamat Pengiriman --}}
                <div class="co-section">
                    <h2 class="co-title"><i class="bi bi-geo-alt"></i> Alamat Pengiriman</h2>
                    
                    <div class="form-group">
                        <label class="form-label">Tandai Lokasi di Peta</label>
                        <div id="map"></div>
                        <div class="map-hint">
                            <i class="bi bi-info-circle"></i> Geser pin untuk menentukan titik koordinat yang akurat.
                        </div>
                        <input type="hidden" name="latitude" id="latInput" required>
                        <input type="hidden" name="longitude" id="lngInput" required>
                    </div>

                    <div class="form-section-title"><i class="bi bi-person-lines-fill"></i> Informasi Kontak</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nama Penerima</label>
                            <div class="input-with-icon">
                                <input type="text" name="recipient_name" class="form-input" placeholder="Nama lengkap penerima" value="{{ old('recipient_name', auth()->user()->nama_lengkap) }}" required>
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor WhatsApp / Telepon</label>
                            <div class="input-with-icon">
                                <input type="tel" name="phone" class="form-input" placeholder="081234567890" value="{{ old('phone', auth()->user()->no_telepon) }}" required>
                                <i class="bi bi-telephone"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-section-title"><i class="bi bi-pin-map-fill"></i> Detail Alamat</div>
                    <div class="form-row">
                        {{-- PROVINSI DROPDOWN --}}
                        <div class="form-group">
                            <label class="form-label">Provinsi</label>
                            <input type="hidden" name="province" id="provinceVal" value="{{ old('province') }}" required>
                            <div class="csdd-wrap" id="csdd-province">
                                <button type="button" class="csdd-trigger" id="csdd-province-trigger" onclick="csddToggle('province')">
                                    <i class="bi bi-map csdd-icon-left"></i>
                                    <span class="csdd-placeholder" id="csdd-province-label">Pilih Provinsi</span>
                                    <i class="bi bi-chevron-down csdd-chevron"></i>
                                </button>
                                <div class="csdd-panel" id="csdd-province-panel">
                                    <div class="csdd-search-wrap">
                                        <i class="bi bi-search"></i>
                                        <input type="text" class="csdd-search" placeholder="Cari provinsi..." id="csdd-province-search" oninput="csddFilter('province', this.value)">
                                    </div>
                                    <div class="csdd-list" id="csdd-province-list">
                                        <div class="csdd-loading"><i class="bi bi-arrow-repeat"></i> Memuat data...</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- KOTA/KABUPATEN DROPDOWN --}}
                        <div class="form-group">
                            <label class="form-label">Kota / Kabupaten</label>
                            <input type="hidden" name="city" id="cityVal" value="{{ old('city') }}" required>
                            <div class="csdd-wrap" id="csdd-city">
                                <button type="button" class="csdd-trigger disabled" id="csdd-city-trigger" onclick="csddToggle('city')">
                                    <i class="bi bi-buildings csdd-icon-left"></i>
                                    <span class="csdd-placeholder" id="csdd-city-label">Pilih Provinsi dulu</span>
                                    <i class="bi bi-chevron-down csdd-chevron"></i>
                                </button>
                                <div class="csdd-panel" id="csdd-city-panel">
                                    <div class="csdd-search-wrap">
                                        <i class="bi bi-search"></i>
                                        <input type="text" class="csdd-search" placeholder="Cari kota/kabupaten..." id="csdd-city-search" oninput="csddFilter('city', this.value)">
                                    </div>
                                    <div class="csdd-list" id="csdd-city-list">
                                        <div class="csdd-empty">Pilih provinsi terlebih dahulu</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        {{-- KECAMATAN DROPDOWN --}}
                        <div class="form-group">
                            <label class="form-label">Kecamatan</label>
                            <input type="hidden" name="district" id="districtVal" value="{{ old('district') }}" required>
                            <div class="csdd-wrap" id="csdd-district">
                                <button type="button" class="csdd-trigger disabled" id="csdd-district-trigger" onclick="csddToggle('district')">
                                    <i class="bi bi-signpost-split csdd-icon-left"></i>
                                    <span class="csdd-placeholder" id="csdd-district-label">Pilih Kota dulu</span>
                                    <i class="bi bi-chevron-down csdd-chevron"></i>
                                </button>
                                <div class="csdd-panel" id="csdd-district-panel">
                                    <div class="csdd-search-wrap">
                                        <i class="bi bi-search"></i>
                                        <input type="text" class="csdd-search" placeholder="Cari kecamatan..." id="csdd-district-search" oninput="csddFilter('district', this.value)">
                                    </div>
                                    <div class="csdd-list" id="csdd-district-list">
                                        <div class="csdd-empty">Pilih kota/kabupaten terlebih dahulu</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kode Pos</label>
                            <div class="input-with-icon">
                                <input type="text" name="postal_code" id="postal_code_input" class="form-input" placeholder="Contoh: 12110" value="{{ old('postal_code') }}" required>
                                <i class="bi bi-mailbox"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Jalan, Gedung, No. Rumah</label>
                        <textarea name="street_address" class="form-textarea" placeholder="Detail alamat lengkap (Gedung, lantai, nomor rumah, blok, dsb.)" required>{{ old('street_address') }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Catatan untuk Kurir (Opsional)</label>
                        <div class="input-with-icon">
                            <input type="text" name="notes" class="form-input" placeholder="Contoh: Titip di pos satpam / Rumah pagar hitam" value="{{ old('notes') }}">
                            <i class="bi bi-chat-left-text"></i>
                        </div>
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div class="co-section">
                    <h2 class="co-title"><i class="bi bi-wallet2"></i> Metode Pembayaran</h2>
                    
                    <div class="payment-methods">
                        <label class="pay-method-label">
                            <input type="radio" name="payment_method" value="qris" required checked>
                            <div class="pay-method-box">
                                <i class="bi bi-qr-code-scan"></i>
                                <span>QRIS (E-Wallet & M-Banking)</span>
                            </div>
                        </label>
                        
                        <label class="pay-method-label">
                            <input type="radio" name="payment_method" value="transfer" required>
                            <div class="pay-method-box">
                                <i class="bi bi-bank"></i>
                                <span>Transfer Bank (Manual)</span>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            {{-- RIGHT: SUMMARY --}}
            <div class="co-right">
                <div class="summary-box">
                    <h2 class="co-title" style="font-size:1.1rem; margin-bottom:24px;">Ringkasan Pesanan</h2>
                    
                    <div class="summary-items-list" style="margin-bottom: 24px;">
                        @foreach($cart as $item)
                        <div class="summary-item">
                            <div class="summary-img">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                                @else
                                    <i class="bi bi-laptop" style="font-size:1.5rem;color:var(--text-muted);opacity:0.5;"></i>
                                @endif
                            </div>
                            <div class="summary-detail">
                                <div class="summary-name">{{ $item['name'] }}</div>
                                <div class="summary-qty">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                            </div>
                            <div class="summary-price">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- ── KUPON INPUT ── --}}
                    <div class="coupon-input-wrap">
                        <div class="coupon-input-label">
                            <i class="bi bi-ticket-perforated-fill"></i> Kode Kupon / Promo
                        </div>
                        <div class="coupon-input-row">
                            <input
                                type="text"
                                id="couponInput"
                                class="coupon-input-field"
                                placeholder="Masukkan kode promo"
                                maxlength="50"
                                value="{{ $appliedCoupon['code'] ?? '' }}"
                            >
                            <button type="button" class="coupon-apply-btn" id="couponApplyBtn" onclick="applyCoupon()">
                                <i class="bi bi-check-lg"></i> Pakai
                            </button>
                        </div>
                        <div class="coupon-feedback" id="couponFeedback"></div>
                        <div class="coupon-applied-badge {{ !empty($appliedCoupon) ? 'show' : '' }}" id="couponAppliedBadge">
                            <span id="couponAppliedText">{{ !empty($appliedCoupon) ? $appliedCoupon['code'] . ' — ' . $appliedCoupon['label'] : '' }}</span>
                            <button type="button" class="coupon-remove-btn" onclick="removeCoupon()" title="Hapus kupon">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                    {{-- Hidden input untuk dikirim bersama form --}}
                    <input type="hidden" name="coupon_code" id="couponCodeHidden" value="{{ $appliedCoupon['code'] ?? '' }}">

                    <div class="summary-row">
                        <span>Subtotal Produk</span>
                        <span id="summarySubtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Biaya Pengiriman</span>
                        <span style="color:#4ade80;">Gratis</span>
                    </div>
                    <div class="summary-row" id="discountRow" style="{{ !empty($appliedCoupon) && $appliedCoupon['discount'] > 0 ? '' : 'display:none;' }}">
                        <span style="color:#10b981;"><i class="bi bi-tag-fill" style="font-size:0.75rem;"></i> Diskon Kupon</span>
                        <span style="color:#10b981;" id="discountDisplay">- Rp {{ !empty($appliedCoupon) ? number_format($appliedCoupon['discount'], 0, ',', '.') : '0' }}</span>
                    </div>

                    <div class="summary-total">
                        <span>Total Pembayaran</span>
                        <span id="summaryTotal">Rp {{ !empty($appliedCoupon) ? number_format(max(0, $total - $appliedCoupon['discount']), 0, ',', '.') : number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn-checkout" id="btnSubmit">
                        <i class="bi bi-shield-lock"></i> Bayar Sekarang
                    </button>
                    
                    <p style="text-align:center; font-size:0.75rem; color:var(--text-muted); margin-top:16px;">
                        Dengan menekan tombol ini, Anda menyetujui Syarat &amp; Ketentuan kami.
                    </p>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
/* ── MAP INIT + REVERSE GEOCODING ── */
window.addEventListener('load', function () {
    // Default: Jakarta Pusat
    let defaultLat = -6.175110;
    let defaultLng = 106.827152;

    const map = L.map('map', { zoomControl: true }).setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap © CARTO',
        subdomains: 'abcd',
        maxZoom: 20
    }).addTo(map);

    // Force Leaflet to recalculate size after layout is ready
    setTimeout(() => map.invalidateSize(), 400);

    // Custom gold marker icon
    const goldIcon = L.divIcon({
        className: '',
        html: `<div style="
            width:34px;height:34px;
            background:linear-gradient(135deg,#f0d080,#d4a843);
            border:3px solid #fff;
            border-radius:50% 50% 50% 0;
            transform:rotate(-45deg);
            box-shadow:0 4px 14px rgba(212,168,67,0.5);
            display:flex;align-items:center;justify-content:center;
        "><span style="transform:rotate(45deg);font-size:1rem;line-height:1;">📍</span></div>`,
        iconSize: [34, 34],
        iconAnchor: [17, 34],
        popupAnchor: [0, -36]
    });

    let marker = L.marker([defaultLat, defaultLng], { draggable: true, icon: goldIcon }).addTo(map);
    updateLatLng(defaultLat, defaultLng);

    // ── Geocode & fill dropdowns when pin moves ──
    let geocodeTimer = null;
    function onPinMoved(lat, lng) {
        updateLatLng(lat, lng);
        clearTimeout(geocodeTimer);
        geocodeTimer = setTimeout(() => reverseGeocode(lat, lng), 600);
    }

    marker.on('dragend', () => {
        const p = marker.getLatLng();
        onPinMoved(p.lat, p.lng);
    });
    map.on('click', (e) => {
        marker.setLatLng(e.latlng);
        onPinMoved(e.latlng.lat, e.latlng.lng);
    });

    // Geolocation: move to user's real position
    if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(pos => {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            map.setView([lat, lng], 15);
            marker.setLatLng([lat, lng]);
            updateLatLng(lat, lng);
            reverseGeocode(lat, lng);
        }, () => {});
    }

    function updateLatLng(lat, lng) {
        document.getElementById('latInput').value = lat;
        document.getElementById('lngInput').value = lng;
    }

    // ── REVERSE GEOCODING via Nominatim ──────────────────
    async function reverseGeocode(lat, lng) {
        showMapToast('📍 Mendeteksi wilayah...', 'loading');
        try {
            const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&addressdetails=1&accept-language=id`;
            const res  = await fetch(url, { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            const addr = data.address || {};

            // Extract names (Nominatim uses different keys)
            const stateName  = addr.state || addr.province || '';
            const cityName   = addr.city || addr.regency || addr.county || addr.town || addr.municipality || '';
            const distName   = addr.suburb || addr.district || addr.village || addr.quarter || '';
            const postalCode = addr.postcode || '';

            if (!stateName) { showMapToast('⚠️ Wilayah tidak dikenali', 'warn'); return; }

            // ── Auto-fill postal code ──
            if (postalCode) {
                const pcEl = document.getElementById('postal_code_input');
                if (pcEl && !pcEl.value) pcEl.value = postalCode;
            }

            // ── Match & select Province ──────────────────
            await waitForProvinces();
            const matchedProv = fuzzyMatch(csddData.province, stateName);
            if (!matchedProv) { showMapToast('⚠️ Provinsi tidak cocok: ' + stateName, 'warn'); return; }

            csddSelect('province', matchedProv.id, matchedProv.name);

            // ── After city data loads, match City ────────
            await csddLoadCityAsync(matchedProv.id);
            if (cityName) {
                const matchedCity = fuzzyMatch(csddData.city, cityName);
                if (matchedCity) {
                    csddSelect('city', matchedCity.id, matchedCity.name);

                    // ── After district data loads, match District ──
                    await csddLoadDistrictAsync(matchedCity.id);
                    if (distName) {
                        const matchedDist = fuzzyMatch(csddData.district, distName);
                        if (matchedDist) csddSelect('district', matchedDist.id, matchedDist.name);
                    }
                }
            }

            showMapToast('✅ Lokasi terdeteksi: ' + matchedProv.name, 'success');
        } catch (err) {
            showMapToast('❌ Gagal deteksi lokasi', 'error');
            console.error('Reverse geocode error:', err);
        }
    }

    // Wait until province data is loaded
    function waitForProvinces(tries = 0) {
        return new Promise((resolve, reject) => {
            if (csddData.province.length > 0) return resolve();
            if (tries > 30) return reject('Provinces not loaded');
            setTimeout(() => waitForProvinces(tries + 1).then(resolve).catch(reject), 200);
        });
    }

    // Fuzzy text match — strips common prefixes (KOTA/KAB/KABUPATEN) and scores by substring
    function fuzzyMatch(list, query) {
        if (!query || !list || list.length === 0) return null;
        const normalize = s => s.toLowerCase()
            .replace(/^(provinsi|prov\.|kota|kabupaten|kab\.|kec\.|kecamatan)\s+/i, '')
            .replace(/[^a-z0-9\s]/g, '').trim();

        const q = normalize(query);
        let best = null, bestScore = -1;

        for (const item of list) {
            const n = normalize(item.name);
            // Exact match
            if (n === q) return item;
            // Contains match
            if (n.includes(q) || q.includes(n)) {
                const score = Math.min(n.length, q.length) / Math.max(n.length, q.length);
                if (score > bestScore) { bestScore = score; best = item; }
            }
        }
        // If no contains match, try word-level overlap
        if (!best) {
            const qWords = q.split(/\s+/);
            for (const item of list) {
                const nWords = normalize(item.name).split(/\s+/);
                const common = qWords.filter(w => nWords.some(nw => nw.includes(w) || w.includes(nw)));
                const score  = common.length / Math.max(qWords.length, nWords.length);
                if (score > bestScore) { bestScore = score; best = item; }
            }
        }
        return bestScore > 0.2 ? best : null;
    }

    // Toast notification inside map
    function showMapToast(msg, type = 'info') {
        let toast = document.getElementById('mapToast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'mapToast';
            toast.style.cssText = `
                position:absolute;bottom:12px;left:50%;transform:translateX(-50%);
                background:rgba(20,20,20,0.92);color:#fff;
                padding:8px 18px;border-radius:100px;font-size:0.8rem;
                font-family:'DM Sans',sans-serif;font-weight:600;
                z-index:9999;border:1px solid rgba(255,255,255,0.1);
                white-space:nowrap;pointer-events:none;
                box-shadow:0 4px 16px rgba(0,0,0,0.4);
                transition:opacity 0.3s ease;
            `;
            document.getElementById('map').style.position = 'relative';
            document.getElementById('map').appendChild(toast);
        }
        const colors = { success:'#4ade80', warn:'#fb923c', error:'#f87171', loading:'#d4a843', info:'#fff' };
        toast.style.color = colors[type] || '#fff';
        toast.textContent = msg;
        toast.style.opacity = '1';
        if (type !== 'loading') {
            clearTimeout(toast._timer);
            toast._timer = setTimeout(() => { toast.style.opacity = '0'; }, 3000);
        }
    }

    // Form submission animation
    document.getElementById('checkoutForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';
        btn.style.opacity = '0.7';
        btn.disabled = true;
    });
});
</script>

<script>
/* ══════════════════════════════════════════════════════════
   CUSTOM SEARCHABLE DROPDOWN — Indonesian Regions Cascader
   API: https://www.emsifa.com/api-wilayah-indonesia/api/
══════════════════════════════════════════════════════════ */
const WILAYAH_BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';

const csddData = {
    province: [],
    city: [],
    district: [],
};
const csddSelected = { province: null, city: null, district: null };

// ── Open / Close ─────────────────────────────────────────
function csddToggle(key) {
    const trigger = document.getElementById(`csdd-${key}-trigger`);
    const panel   = document.getElementById(`csdd-${key}-panel`);
    if (trigger.classList.contains('disabled')) return;

    const isOpen = panel.classList.contains('open');
    csddCloseAll();
    if (!isOpen) {
        trigger.classList.add('open');
        panel.classList.add('open');
        // Focus search
        setTimeout(() => {
            const s = document.getElementById(`csdd-${key}-search`);
            if (s) s.focus();
        }, 120);
    }
}

function csddCloseAll() {
    ['province','city','district'].forEach(k => {
        document.getElementById(`csdd-${k}-trigger`)?.classList.remove('open');
        document.getElementById(`csdd-${k}-panel`)?.classList.remove('open');
    });
}

// Close when clicking outside
document.addEventListener('click', function(e) {
    const wraps = document.querySelectorAll('.csdd-wrap');
    let inside = false;
    wraps.forEach(w => { if (w.contains(e.target)) inside = true; });
    if (!inside) csddCloseAll();
});

// ── Render list ───────────────────────────────────────────
function csddRender(key, items, query = '') {
    const list = document.getElementById(`csdd-${key}-list`);
    const filtered = query
        ? items.filter(i => i.name.toLowerCase().includes(query.toLowerCase()))
        : items;

    if (filtered.length === 0) {
        list.innerHTML = `<div class="csdd-empty"><i class="bi bi-search" style="display:block;margin-bottom:6px;opacity:0.3;font-size:1.5rem;"></i>Tidak ditemukan untuk "<strong>${query}</strong>"</div>`;
        return;
    }

    list.innerHTML = filtered.map(item => `
        <div class="csdd-option ${csddSelected[key]?.id === item.id ? 'selected' : ''}"
             onclick="csddSelect('${key}', '${item.id}', \`${item.name.replace(/`/g,'&#96;')}\`)">
            <i class="bi bi-${key === 'province' ? 'map' : key === 'city' ? 'buildings' : 'signpost-split'}" style="font-size:0.8rem;opacity:0.5;"></i>
            <span>${item.name}</span>
            <i class="bi bi-check2 csdd-opt-check"></i>
        </div>`).join('');
}

// ── Filter (search) ───────────────────────────────────────
function csddFilter(key, q) {
    csddRender(key, csddData[key], q);
}

// ── Select an option ──────────────────────────────────────
function csddSelect(key, id, name) {
    csddSelected[key] = { id, name };

    // Update hidden input
    document.getElementById(`${key}Val`).value = name;

    // Update trigger label
    const label = document.getElementById(`csdd-${key}-label`);
    label.className = 'csdd-selected';
    label.textContent = name;

    csddCloseAll();

    // Clear & reset downstream
    if (key === 'province') {
        // Reset city
        csddSelected.city = null;
        csddSelected.district = null;
        document.getElementById('cityVal').value = '';
        document.getElementById('districtVal').value = '';
        document.getElementById('csdd-city-label').className = 'csdd-placeholder';
        document.getElementById('csdd-city-label').textContent = 'Pilih Kota / Kabupaten';
        document.getElementById('csdd-district-label').className = 'csdd-placeholder';
        document.getElementById('csdd-district-label').textContent = 'Pilih Kota dulu';
        csddLoadCity(id);
    } else if (key === 'city') {
        csddSelected.district = null;
        document.getElementById('districtVal').value = '';
        document.getElementById('csdd-district-label').className = 'csdd-placeholder';
        document.getElementById('csdd-district-label').textContent = 'Pilih Kecamatan';
        csddLoadDistrict(id);
    }
}

// ── API Loaders (return Promise for async chaining) ───────
async function csddLoadProvinces() {
    const list = document.getElementById('csdd-province-list');
    list.innerHTML = '<div class="csdd-loading"><i class="bi bi-arrow-repeat"></i> Memuat provinsi...</div>';
    try {
        const r = await fetch(`${WILAYAH_BASE}/provinces.json`);
        csddData.province = await r.json();
        csddRender('province', csddData.province);
    } catch {
        list.innerHTML = '<div class="csdd-empty">Gagal memuat data. Cek koneksi internet.</div>';
    }
}

async function csddLoadCity(provinceId) {
    return csddLoadCityAsync(provinceId);
}
async function csddLoadCityAsync(provinceId) {
    const trigger = document.getElementById('csdd-city-trigger');
    const list    = document.getElementById('csdd-city-list');
    trigger.classList.add('disabled');
    list.innerHTML = '<div class="csdd-loading"><i class="bi bi-arrow-repeat"></i> Memuat kota/kabupaten...</div>';
    try {
        const r = await fetch(`${WILAYAH_BASE}/regencies/${provinceId}.json`);
        csddData.city = await r.json();
        trigger.classList.remove('disabled');
        csddRender('city', csddData.city);
        // Reset district
        const dTrigger = document.getElementById('csdd-district-trigger');
        dTrigger.classList.add('disabled');
        document.getElementById('csdd-district-list').innerHTML = '<div class="csdd-empty">Pilih kota/kabupaten terlebih dahulu</div>';
        csddData.district = [];
    } catch {
        list.innerHTML = '<div class="csdd-empty">Gagal memuat data.</div>';
    }
}

async function csddLoadDistrict(regencyId) {
    return csddLoadDistrictAsync(regencyId);
}
async function csddLoadDistrictAsync(regencyId) {
    const trigger = document.getElementById('csdd-district-trigger');
    const list    = document.getElementById('csdd-district-list');
    trigger.classList.add('disabled');
    list.innerHTML = '<div class="csdd-loading"><i class="bi bi-arrow-repeat"></i> Memuat kecamatan...</div>';
    try {
        const r = await fetch(`${WILAYAH_BASE}/districts/${regencyId}.json`);
        csddData.district = await r.json();
        trigger.classList.remove('disabled');
        csddRender('district', csddData.district);
    } catch {
        list.innerHTML = '<div class="csdd-empty">Gagal memuat data.</div>';
    }
}

// ── Init: Load provinces immediately ─────────────────────
csddLoadProvinces();
</script>

<script>
/* ══════════════════════════════════════════════════════════
   KUPON PROMO — Apply & Remove Logic
══════════════════════════════════════════════════════════ */

// Subtotal dari PHP (tanpa diskon)
const BASE_SUBTOTAL = {{ (int) $total }};

// State kupon yang sedang aktif
let activeCoupon = null;

// Tekan Enter di input kupon = apply
document.getElementById('couponInput').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        applyCoupon();
    }
});

async function applyCoupon() {
    const input   = document.getElementById('couponInput');
    const btn     = document.getElementById('couponApplyBtn');
    const feedback = document.getElementById('couponFeedback');
    const code    = input.value.trim().toUpperCase();

    if (!code) {
        showCouponFeedback('error', 'bi-exclamation-circle', 'Masukkan kode kupon terlebih dahulu.');
        input.classList.add('is-invalid');
        return;
    }

    // Loading state
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memeriksa...';
    input.classList.remove('is-valid', 'is-invalid');
    feedback.className = 'coupon-feedback';

    try {
        const response = await fetch('{{ route("coupon.apply") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    || document.querySelector('input[name="_token"]')?.value
                    || '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                code:  code,
                total: BASE_SUBTOTAL
            })
        });

        const data = await response.json();

        if (data.valid) {
            activeCoupon = data;
            input.classList.add('is-valid');
            document.getElementById('couponCodeHidden').value = data.code;

            // Kupon FREESHIPID (value=0) — tampilkan sebagai gratis ongkir
            if (data.discount === 0 || data.type === 'fixed' && data.value === 0) {
                showCouponFeedback('freeship', 'bi-truck', '✓ Gratis Ongkir aktif untuk pesanan ini!');
                updateSummary(0);
                showAppliedBadge(data.code, 'Gratis Ongkir');
            } else {
                showCouponFeedback('success', 'bi-check-circle-fill', data.message);
                updateSummary(data.discount);
                const label = data.type === 'percent'
                    ? `Diskon ${data.value}% (- Rp ${formatRupiah(data.discount)})`
                    : `Diskon - Rp ${formatRupiah(data.discount)}`;
                showAppliedBadge(data.code, label);
            }

        } else {
            activeCoupon = null;
            input.classList.add('is-invalid');
            document.getElementById('couponCodeHidden').value = '';
            showCouponFeedback('error', 'bi-x-circle-fill', data.message);
            updateSummary(0);
            hideAppliedBadge();
        }

    } catch (err) {
        showCouponFeedback('error', 'bi-wifi-off', 'Gagal menghubungi server. Cek koneksi Anda.');
        input.classList.add('is-invalid');
    }

    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-check-lg"></i> Pakai';
}

function removeCoupon() {
    activeCoupon = null;
    const input = document.getElementById('couponInput');
    input.value = '';
    input.classList.remove('is-valid', 'is-invalid');
    document.getElementById('couponCodeHidden').value = '';
    document.getElementById('couponFeedback').className = 'coupon-feedback';
    updateSummary(0);
    hideAppliedBadge();
}

function updateSummary(discount) {
    const finalTotal = Math.max(0, BASE_SUBTOTAL - discount);
    const discountRow = document.getElementById('discountRow');
    const discountDisplay = document.getElementById('discountDisplay');
    const summaryTotal = document.getElementById('summaryTotal');

    if (discount > 0) {
        discountRow.style.display = 'flex';
        discountDisplay.textContent = '- Rp ' + formatRupiah(discount);
    } else {
        discountRow.style.display = 'none';
    }

    summaryTotal.textContent = 'Rp ' + formatRupiah(finalTotal);
}

function showAppliedBadge(code, label) {
    const badge = document.getElementById('couponAppliedBadge');
    const text  = document.getElementById('couponAppliedText');
    text.textContent = code + ' — ' + label;
    badge.classList.add('show');
}

function hideAppliedBadge() {
    document.getElementById('couponAppliedBadge').classList.remove('show');
    document.getElementById('couponAppliedText').textContent = '';
}

function showCouponFeedback(type, icon, msg) {
    const el = document.getElementById('couponFeedback');
    el.className = 'coupon-feedback ' + type;
    el.innerHTML = `<i class="bi ${icon}"></i> ${msg}`;
}

function formatRupiah(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
</script>
@endpush
