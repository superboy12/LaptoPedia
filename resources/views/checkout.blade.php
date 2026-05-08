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

    /* ===== LAYOUT GRID - RINGKASAN DI SAMPING KANAN ===== */
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

    .form-input, .form-select {
        background: #1a1a1a;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 12px 14px;
        color: #ffffff;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem;
        transition: all 0.2s;
        outline: none;
        width: 100%;
    }
    .form-input:focus, .form-select:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 2px rgba(212,168,67,0.1);
    }
    .form-input::placeholder { color: rgba(255,255,255,0.3); }
    
    .form-select optgroup {
        background-color: #0d0d0d !important;
        color: #d4a843 !important;
        font-weight: 700;
        font-style: normal;
        padding: 10px;
    }
    .form-select option {
        background-color: #1a1a1a !important;
        color: #ffffff !important;
        padding: 8px;
    }
    .form-select option:hover {
        background-color: #d4a843 !important;
        color: #000000 !important;
    }

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
        max-height: 400px;
        overflow-y: auto;
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

    .qty-badge { position: relative; }
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
    }
    .coupon-input:focus { border-color: rgba(212,168,67,0.4); }
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

    .alert-message {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 0.8rem;
    }
    .alert-error { background: rgba(220,38,38,0.1); border: 1px solid rgba(220,38,38,0.3); color: #f87171; }
    .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #10b981; }

    /* RESPONSIVE: saat layar kecil, summary pindah ke bawah */
    @media (max-width: 960px) {
        .checkout-grid { 
            grid-template-columns: 1fr; 
        }
        .summary-card { 
            position: static; 
            margin-top: 20px;
        }
        .page-wrap { 
            padding: 40px 24px 80px; 
        }
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

    <!-- BREADCRUMB & PROGRESS STEPS (sama seperti sebelumnya) -->
    <div class="breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('cart.index') }}">Keranjang</a>
        <i class="bi bi-chevron-right"></i>
        <span>Checkout</span>
    </div>

    <div class="checkout-steps">
        <div class="step done"><div class="step-num"><i class="bi bi-check-lg"></i></div><div class="step-label">Keranjang</div></div>
        <div class="step-line active"></div>
        <div class="step active"><div class="step-num">2</div><div class="step-label">Checkout</div></div>
        <div class="step-line"></div>
        <div class="step"><div class="step-num">3</div><div class="step-label">Pembayaran</div></div>
        <div class="step-line"></div>
        <div class="step"><div class="step-num">4</div><div class="step-label">Selesai</div></div>
    </div>

    <div id="alertContainer"></div>

<form id="checkoutForm" action="/checkout-process" method="POST">
            @csrf
        
        {{-- GRID: FORM KIRI | SUMMARY KANAN --}}
        <div class="checkout-grid">

            {{-- KOLOM KIRI (FORM) --}}
            <div>
                <!-- CARD ALAMAT -->
                <div class="card">
                    <div class="card-title"><i class="bi bi-geo-alt"></i> Alamat Pengiriman</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="fullname" class="form-input" placeholder="John Doe" value="{{ old('fullname', Auth::user()->name ?? '') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="tel" name="phone" class="form-input" placeholder="081234567890" value="{{ old('phone') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <input type="text" name="address" class="form-input" placeholder="Jl. Merdeka No. 17, RT 02/RW 05" value="{{ old('address') }}" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Provinsi</label>
                            <select name="province" class="form-select" id="provinceSelect" required onchange="updateShippingCost()">
                                <option value="">Pilih Provinsi</option>
                                <optgroup label="PULAU JAWA">
                                    <option value="banten">Banten</option>
                                    <option value="jakarta">DKI Jakarta</option>
                                    <option value="jabar">Jawa Barat</option>
                                    <option value="jateng">Jawa Tengah</option>
                                    <option value="jogja">DI Yogyakarta</option>
                                    <option value="jatim">Jawa Timur</option>
                                </optgroup>
                                <optgroup label="PULAU SUMATRA">
                                    <option value="aceh">Aceh</option>
                                    <option value="sumut">Sumatera Utara</option>
                                    <option value="sumbar">Sumatera Barat</option>
                                    <option value="riau">Riau</option>
                                    <option value="kepri">Kepulauan Riau</option>
                                    <option value="jambi">Jambi</option>
                                    <option value="bengkulu">Bengkulu</option>
                                    <option value="sumsel">Sumatera Selatan</option>
                                    <option value="lampung">Lampung</option>
                                </optgroup>
                                <optgroup label="PULAU KALIMANTAN">
                                    <option value="kalbar">Kalimantan Barat</option>
                                    <option value="kalteng">Kalimantan Tengah</option>
                                    <option value="kalsel">Kalimantan Selatan</option>
                                    <option value="kaltim">Kalimantan Timur</option>
                                    <option value="kalut">Kalimantan Utara</option>
                                </optgroup>
                                <optgroup label="PULAU SULAWESI">
                                    <option value="sulut">Sulawesi Utara</option>
                                    <option value="gorontalo">Gorontalo</option>
                                    <option value="sulteng">Sulawesi Tengah</option>
                                    <option value="sulbar">Sulawesi Barat</option>
                                    <option value="sulsel">Sulawesi Selatan</option>
                                    <option value="sultra">Sulawesi Tenggara</option>
                                </optgroup>
                                <optgroup label="PULAU BALI & NUSA TENGGARA">
                                    <option value="bali">Bali</option>
                                    <option value="ntb">Nusa Tenggara Barat</option>
                                    <option value="ntt">Nusa Tenggara Timur</option>
                                </optgroup>
                                <optgroup label="PULAU MALUKU & PAPUA">
                                    <option value="maluku">Maluku</option>
                                    <option value="malut">Maluku Utara</option>
                                    <option value="papua">Papua</option>
                                    <option value="papuabarat">Papua Barat</option>
                                    <option value="papuaselatan">Papua Selatan</option>
                                    <option value="papuapegunungan">Papua Pegunungan</option>
                                    <option value="papuategah">Papua Tengah</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Layanan Pengiriman</label>
                            <select name="shipping_service" class="form-select" id="shippingSelect" required onchange="updateShippingCost()">
                                <option value="jne_reg">JNE REG (2-3 hari)</option>
                                <option value="jne_yes">JNE YES (1 hari)</option>
                                <option value="jnt">J&T Express (2-4 hari)</option>
                                <option value="sicepat">SiCepat BEST (2-3 hari)</option>
                                <option value="pos">POS Indonesia (3-5 hari)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- CARD PEMBAYARAN (HANYA QRIS) -->
                <div class="card">
                    <div class="card-title"><i class="bi bi-qr-code"></i> Metode Pembayaran</div>
                    <div class="payment-methods">
                        <div class="payment-option selected" data-payment="qris">
                            <div class="payment-radio"><div class="payment-radio-dot"></div></div>
                            <div class="payment-icon-wrap"><i class="bi bi-qr-code"></i></div>
                            <div class="payment-info">
                                <div class="payment-name">QRIS</div>
                                <div class="payment-desc">GoPay · OVO · DANA · ShopeePay · Semua Bank via QR</div>
                            </div>
                            <span class="payment-badge">Metode Pembayaran Resmi</span>
                        </div>
                    </div>
                    <input type="hidden" name="payment_method" id="paymentMethod" value="qris">
                    <div style="margin-top:22px;padding-top:22px;border-top:1px solid var(--border);">
                        <div class="form-label" style="margin-bottom:8px;">Kode Kupon / Promo</div>
                        <div class="coupon-strip">
                            <input type="text" class="coupon-input" id="couponInput" placeholder="DISKON10, DISKON20, SPECIAL50">
                            <button type="button" class="btn-coupon" onclick="applyCoupon()">Terapkan</button>
                        </div>
                        <div id="couponMessage" style="font-size: 0.7rem; margin-top: 8px;"></div>
                    </div>
                </div>

                <!-- CARD CATATAN -->
                <div class="card">
                    <div class="card-title"><i class="bi bi-chat-square-text"></i> Catatan Pesanan (Opsional)</div>
                    <textarea name="notes" class="form-input" rows="3" placeholder="Instruksi khusus untuk pengiriman, dll…" style="resize:vertical;min-height:80px;">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- KOLOM KANAN (RINGKASAN PESANAN) --}}
            <div>
                <div class="summary-card">
                    <div class="summary-header"><div class="summary-title">Ringkasan Pesanan</div></div>

                    <div class="summary-items">
                        @php $subtotal = 0; @endphp
                        @forelse($cart as $key => $item)
                            @php $itemTotal = $item['price'] * $item['quantity']; $subtotal += $itemTotal; @endphp
                            <div class="summary-item">
                                <div class="item-img qty-badge" data-qty="{{ $item['quantity'] }}">
                                    @if(isset($item['image']) && $item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                                    @else
                                        <i class="bi bi-cart" style="color: var(--muted); font-size: 1.5rem;"></i>
                                    @endif
                                </div>
                                <div class="item-info">
                                    <div class="item-name">{{ $item['name'] }}</div>
                                    <div class="item-meta">Qty: {{ $item['quantity'] }}</div>
                                </div>
                                <div class="item-price">Rp {{ number_format($itemTotal, 0, ',', '.') }}</div>
                            </div>
                        @empty
                            <div class="text-center py-4" style="color: var(--muted); text-align: center;">
                                <i class="bi bi-cart-x" style="font-size: 2rem;"></i>
                                <p>Keranjang belanja kosong</p>
                                <a href="{{ route('products.index') }}" class="btn-coupon">Belanja Sekarang</a>
                            </div>
                        @endforelse
                    </div>

                    <div class="summary-rows">
                        <div class="summary-row"><span class="row-label">Subtotal</span><span class="row-val" id="subtotalVal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                        <div class="summary-row"><span class="row-label">Ongkos Kirim</span><span class="row-val" id="shippingCostVal">Rp {{ number_format($shippingCost ?? 0, 0, ',', '.') }}</span></div>
                        <div class="summary-row" id="discountRow" style="{{ ($discount ?? 0) > 0 ? '' : 'display:none;' }}"><span class="row-label">Diskon Promo</span><span class="row-val discount" id="discountVal">− Rp {{ number_format($discount ?? 0, 0, ',', '.') }}</span></div>
                        <div class="summary-row"><span class="row-label">Asuransi Pengiriman</span><span class="row-val" id="insuranceVal">Rp {{ number_format($insurance ?? 15000, 0, ',', '.') }}</span></div>
                    </div>

                    <div class="summary-total">
                        <span class="total-label">Total Pembayaran</span>
                        <span class="total-val" id="totalVal">Rp {{ number_format(($subtotal + ($shippingCost ?? 0) + ($insurance ?? 15000) - ($discount ?? 0)), 0, ',', '.') }}</span>
                    </div>

                    <div class="btn-checkout-wrap">
                        <button type="submit" class="btn-checkout" id="submitBtn">Lanjut ke Pembayaran <i class="bi bi-arrow-right"></i></button>
                    </div>

                    <div class="summary-note"><i class="bi bi-shield-lock"></i><span>Transaksi aman & terenkripsi SSL 256-bit. Data Anda terlindungi.</span></div>
                </div>
            </div>

        </div>
    </form>
</div>
</div>
@endsection

@push('scripts')
<script>
    let currentSubtotal = {{ $subtotal ?? 0 }};
    let currentShipping = {{ $shippingCost ?? 0 }};
    let currentInsurance = {{ $insurance ?? 15000 }};
    let currentDiscount = {{ $discount ?? 0 }};
    let appliedCouponCode = null;

    const shippingCostByProvince = {
        'jakarta': 15000, 'banten': 15000, 'jabar': 15000, 'jateng': 15000, 'jogja': 15000, 'jatim': 15000, 'bali': 15000, 'lampung': 15000,
        'aceh': 35000, 'sumut': 35000, 'sumbar': 35000, 'riau': 35000, 'kepri': 35000, 'jambi': 35000, 'bengkulu': 35000, 'sumsel': 35000,
        'kalbar': 35000, 'kalteng': 35000, 'kalsel': 35000, 'kaltim': 35000, 'kalut': 35000,
        'sulut': 35000, 'gorontalo': 35000, 'sulteng': 35000, 'sulbar': 35000, 'sulsel': 35000, 'sultra': 35000,
        'ntb': 35000, 'ntt': 35000,
        'maluku': 50000, 'malut': 50000,
        'papua': 55000, 'papuabarat': 55000, 'papuaselatan': 55000, 'papuapegunungan': 55000, 'papuategah': 55000
    };

    function getOngkir(province, service) {
        let cost = shippingCostByProvince[province] || 15000;
        if (service === 'jne_yes') cost += 20000;
        else if (service === 'sicepat') cost += 5000;
        return cost;
    }

    function updateShippingCost() {
        const province = document.getElementById('provinceSelect').value;
        const service = document.getElementById('shippingSelect').value;
        if (!province) return;
        
        let newShipping = getOngkir(province, service);
        currentShipping = newShipping;
        document.getElementById('shippingCostVal').innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(newShipping);
        updateTotal();
    }

    function selectPayment(el) {
        document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('paymentMethod').value = el.getAttribute('data-payment');
    }

    function updateTotal() {
        const total = currentSubtotal + currentShipping + currentInsurance - currentDiscount;
        document.getElementById('totalVal').innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }

    async function applyCoupon() {
        const couponCode = document.getElementById('couponInput').value.trim().toUpperCase();
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
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ coupon_code: couponCode })
            });
            const data = await response.json();

            if (data.success) {
                currentDiscount = data.discount_amount;
                appliedCouponCode = couponCode;
                document.getElementById('discountRow').style.display = 'flex';
                document.getElementById('discountVal').innerHTML = '− Rp ' + new Intl.NumberFormat('id-ID').format(currentDiscount);
                document.getElementById('couponMessage').innerHTML = '<span style="color: #10b981;">✓ ' + data.message + '</span>';
                updateTotal();
                showMessage(data.message, 'success');
            } else {
                document.getElementById('couponMessage').innerHTML = '<span style="color: #f87171;">✗ ' + data.message + '</span>';
                showMessage(data.message, 'error');
            }
        } catch (error) {
            showMessage('Terjadi kesalahan, silakan coba lagi.', 'error');
        } finally {
            btn.innerText = originalText;
            btn.disabled = false;
        }
    }

    function showMessage(message, type) {
        const container = document.getElementById('alertContainer');
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert-message alert-${type}`;
        alertDiv.innerHTML = message;
        container.appendChild(alertDiv);
        setTimeout(() => alertDiv.remove(), 5000);
    }

    // PERBAIKI INI - HAPUS alert dan perbaiki syntax
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const requiredFields = ['fullname', 'phone', 'address', 'province'];
        for (let field of requiredFields) {
            const input = document.querySelector(`[name="${field}"]`);
            if (input && !input.value.trim()) {
                e.preventDefault();
                showMessage(`Field ${field.replace('_', ' ')} harus diisi!`, 'error');
                return;
            }
        }
        if (appliedCouponCode) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'coupon_code';
            hiddenInput.value = appliedCouponCode;
            this.appendChild(hiddenInput);
        }
    });

    document.getElementById('provinceSelect')?.addEventListener('change', updateShippingCost);
    document.getElementById('shippingSelect')?.addEventListener('change', updateShippingCost);
</script>
@endpush
