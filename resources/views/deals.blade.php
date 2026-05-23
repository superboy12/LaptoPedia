@extends('layouts.app')

@push('styles')
<style>
/* =============================================
   DEALS PAGE — Premium Dark/Gold Aesthetic
============================================= */

/* ── DEALS HERO ── */
.deals-hero {
    position: relative;
    padding: 120px 48px 80px;
    text-align: center;
    overflow: hidden;
    background: var(--bg);
}
.deals-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 50% 0%, rgba(212,168,67,0.12) 0%, transparent 70%),
        radial-gradient(ellipse 60% 50% at 20% 100%, rgba(212,168,67,0.06) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 80% 100%, rgba(160,114,26,0.05) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}
.deals-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 820px;
    margin: 0 auto;
    animation: dealsFadeUp 0.9s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes dealsFadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}

.deals-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--gold);
    padding: 7px 18px;
    border: 1px solid rgba(212,168,67,0.3);
    border-radius: 100px;
    background: rgba(212,168,67,0.07);
    margin-bottom: 28px;
}
.deals-badge-dot {
    width: 6px; height: 6px;
    background: var(--gold);
    border-radius: 50%;
    animation: dealsPulse 2s ease-in-out infinite;
}
@keyframes dealsPulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50%     { opacity: 0.4; transform: scale(0.6); }
}

.deals-hero-title {
    font-family: 'Manrope', sans-serif;
    font-size: clamp(2.8rem, 5.5vw, 5rem);
    font-weight: 900;
    line-height: 1;
    letter-spacing: -0.05em;
    color: var(--text);
    margin-bottom: 18px;
    transition: color 0.4s ease;
}
.deals-hero-title .gold-text {
    background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.deals-hero-sub {
    font-size: 1.05rem;
    color: var(--text-muted);
    font-weight: 300;
    line-height: 1.7;
    max-width: 500px;
    margin: 0 auto 40px;
    transition: color 0.4s ease;
}

/* ── COUNTDOWN TIMER ── */
.countdown-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    animation: dealsFadeUp 0.9s 0.15s cubic-bezier(0.16,1,0.3,1) both;
}
.countdown-box {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 16px 22px;
    min-width: 80px;
    text-align: center;
    transition: background 0.4s ease, border-color 0.3s ease;
}
.countdown-box:hover {
    border-color: rgba(212,168,67,0.35);
}
.countdown-num {
    font-family: 'Manrope', sans-serif;
    font-size: 2rem;
    font-weight: 900;
    color: var(--gold);
    letter-spacing: -0.03em;
    line-height: 1;
}
.countdown-lbl {
    font-size: 0.68rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-weight: 600;
    margin-top: 4px;
}
.countdown-colon {
    font-family: 'Manrope', sans-serif;
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--text-muted);
    opacity: 0.35;
    margin-top: -8px;
}

/* ── PROMO COUPONS SECTION ── */
.coupons-section {
    background: var(--bg-2);
    padding: 80px 48px;
    border-top: 1px solid var(--border);
    transition: background 0.4s ease;
}
.coupons-inner {
    max-width: 1280px;
    margin: 0 auto;
}
.coupons-header {
    margin-bottom: 44px;
}

.coupons-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

/* Coupon Card */
.coupon-card {
    position: relative;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 28px 24px;
    overflow: hidden;
    transition: transform 0.3s cubic-bezier(0.2,0.8,0.2,1), box-shadow 0.3s ease, border-color 0.3s ease;
    cursor: default;
}
.coupon-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #d4a843, #f0d080, #a0721a);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.coupon-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 48px rgba(0,0,0,0.2);
    border-color: rgba(212,168,67,0.3);
}
.coupon-card:hover::before {
    opacity: 1;
}

.coupon-icon-wrap {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: var(--gold-dim);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 16px;
}
.coupon-icon-wrap i {
    font-size: 1.3rem;
    color: var(--gold);
}

.coupon-title {
    font-family: 'Manrope', sans-serif;
    font-size: 1rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.02em;
    margin-bottom: 6px;
    transition: color 0.4s ease;
}
.coupon-desc {
    font-size: 0.82rem;
    color: var(--text-muted);
    line-height: 1.6;
    font-weight: 300;
    margin-bottom: 18px;
    transition: color 0.4s ease;
}
.coupon-code-row {
    display: flex;
    align-items: center;
    gap: 10px;
}
.coupon-code {
    flex: 1;
    background: var(--bg);
    border: 1px dashed rgba(212,168,67,0.4);
    border-radius: 8px;
    padding: 10px 14px;
    font-family: 'Manrope', sans-serif;
    font-size: 0.88rem;
    font-weight: 800;
    color: var(--gold);
    letter-spacing: 0.08em;
    text-align: center;
    transition: background 0.4s ease;
}
.coupon-copy-btn {
    background: linear-gradient(135deg, #d4a843, #a0721a);
    border: none;
    color: #000;
    font-family: 'Manrope', sans-serif;
    font-weight: 800;
    font-size: 0.75rem;
    padding: 10px 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    white-space: nowrap;
    display: flex; align-items: center; gap: 5px;
}
.coupon-copy-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(212,168,67,0.3);
}
.coupon-copy-btn.copied {
    background: #10b981;
    color: #fff;
}

.coupon-validity {
    font-size: 0.7rem;
    color: var(--text-muted);
    margin-top: 12px;
    display: flex; align-items: center; gap: 5px;
    opacity: 0.7;
}

/* ── DEAL PRODUCTS SECTION ── */
.deal-products-section {
    padding: 88px 48px 96px;
    background: var(--bg);
    transition: background 0.4s ease;
}
.deal-products-inner {
    max-width: 1280px;
    margin: 0 auto;
}
.deal-products-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 48px;
}

.deal-products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

/* Deal Product Card */
.deal-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    transition: transform 0.35s cubic-bezier(0.2,0.8,0.2,1), box-shadow 0.35s ease, border-color 0.3s ease;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    animation: dealCardFadeUp 0.6s cubic-bezier(0.2,0.8,0.2,1) both;
}
.deal-card:nth-child(1) { animation-delay: 0.05s; }
.deal-card:nth-child(2) { animation-delay: 0.10s; }
.deal-card:nth-child(3) { animation-delay: 0.15s; }
.deal-card:nth-child(4) { animation-delay: 0.20s; }
.deal-card:nth-child(5) { animation-delay: 0.25s; }
.deal-card:nth-child(6) { animation-delay: 0.30s; }

@keyframes dealCardFadeUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}
.deal-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 24px 56px rgba(0,0,0,0.22);
    border-color: rgba(212,168,67,0.35);
}

.deal-card-img {
    position: relative;
    background: var(--surface-2);
    height: 220px;
    display: flex; align-items: center; justify-content: center;
    padding: 28px;
    border-bottom: 1px solid var(--border);
    overflow: hidden;
    transition: background 0.4s ease;
}
.deal-card-img img {
    max-height: 160px;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.5s cubic-bezier(0.2,0.8,0.2,1);
}
.deal-card:hover .deal-card-img img { transform: scale(1.08) translateY(-4px); }
.deal-card-img .deal-placeholder {
    font-size: 4rem;
    color: var(--text-muted);
    opacity: 0.18;
}

/* Discount badge on card */
.deal-discount-badge {
    position: absolute;
    top: 14px; left: 14px;
    background: linear-gradient(135deg, #d4a843, #a0721a);
    color: #000;
    font-family: 'Manrope', sans-serif;
    font-size: 0.72rem;
    font-weight: 900;
    padding: 5px 12px;
    border-radius: 100px;
    letter-spacing: 0.02em;
    box-shadow: 0 4px 12px rgba(212,168,67,0.3);
}

/* Flash sale timer badge */
.deal-flash-badge {
    position: absolute;
    top: 14px; right: 14px;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.08);
    color: #fff;
    font-family: 'Manrope', sans-serif;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 5px 10px;
    border-radius: 8px;
    display: flex; align-items: center; gap: 5px;
}
.deal-flash-badge i { color: var(--gold); font-size: 0.7rem; }

.deal-card-body {
    padding: 22px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.deal-card-brand {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--gold);
    margin-bottom: 6px;
    font-family: 'DM Sans', sans-serif;
}
.deal-card-name {
    font-family: 'Manrope', sans-serif;
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.02em;
    margin-bottom: 8px;
    line-height: 1.3;
    transition: color 0.4s ease;
}
.deal-card-desc {
    font-size: 0.78rem;
    color: var(--text-muted);
    line-height: 1.6;
    font-weight: 300;
    flex: 1;
    margin-bottom: 18px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.4s ease;
}

.deal-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}
.deal-price-group {
    display: flex;
    flex-direction: column;
}
.deal-price-old {
    font-size: 0.78rem;
    color: var(--text-muted);
    text-decoration: line-through;
    font-weight: 400;
    opacity: 0.6;
}
.deal-price-new {
    font-family: 'Manrope', sans-serif;
    font-size: 1.1rem;
    font-weight: 900;
    color: var(--text);
    letter-spacing: -0.03em;
    transition: color 0.4s ease;
}
.deal-saved {
    font-size: 0.68rem;
    color: #10b981;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
}

.btn-deal-detail {
    background: var(--text);
    color: var(--bg);
    border: none;
    font-family: 'Manrope', sans-serif;
    font-size: 0.78rem;
    font-weight: 800;
    padding: 10px 18px;
    border-radius: 100px;
    cursor: pointer;
    transition: transform 0.2s, opacity 0.2s;
    white-space: nowrap;
    text-decoration: none;
    display: inline-flex; align-items: center; gap: 5px;
}
.btn-deal-detail:hover { opacity: 0.85; transform: translateY(-1px); }

/* ── PROMO BANNER (Full-Width) ── */
.promo-banner-section {
    padding: 0 48px;
    background: var(--bg);
}
.promo-banner {
    max-width: 1280px;
    margin: 0 auto;
    background: linear-gradient(135deg, rgba(212,168,67,0.08), rgba(160,114,26,0.04));
    border: 1px solid rgba(212,168,67,0.2);
    border-radius: 24px;
    padding: 56px 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    transition: border-color 0.3s ease;
    overflow: hidden;
    position: relative;
}
.promo-banner::after {
    content: '';
    position: absolute;
    top: -60%; right: -10%;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(212,168,67,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.promo-banner:hover {
    border-color: rgba(212,168,67,0.4);
}
.promo-banner-text {
    position: relative;
    z-index: 1;
}
.promo-banner-eyebrow {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 10px;
    display: flex; align-items: center; gap: 6px;
}
.promo-banner-title {
    font-family: 'Manrope', sans-serif;
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 900;
    color: var(--text);
    letter-spacing: -0.04em;
    line-height: 1.15;
    margin-bottom: 10px;
    transition: color 0.4s ease;
}
.promo-banner-desc {
    font-size: 0.9rem;
    color: var(--text-muted);
    font-weight: 300;
    line-height: 1.65;
    max-width: 480px;
    transition: color 0.4s ease;
}
.promo-banner-btn {
    position: relative;
    z-index: 1;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
    color: #000;
    font-family: 'Manrope', sans-serif;
    font-weight: 800;
    font-size: 0.9rem;
    padding: 16px 36px;
    border-radius: 100px;
    border: none;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    letter-spacing: -0.01em;
    box-shadow: 0 4px 14px rgba(212,168,67,0.2);
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
}
.promo-banner-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(212,168,67,0.35);
    color: #000;
}

/* ── WHY DEALS TRUST STRIP ── */
.deals-trust-strip {
    background: var(--bg-2);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 0 48px;
    transition: background 0.4s ease;
}
.deals-trust-inner {
    max-width: 1280px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}
.trust-item {
    padding: 40px 28px;
    text-align: center;
    border-right: 1px solid var(--border);
    transition: background 0.3s;
}
.trust-item:last-child { border-right: none; }
.trust-item:hover { background: var(--search-bg); }
.trust-icon {
    font-size: 1.5rem;
    color: var(--gold);
    margin-bottom: 10px;
    display: block;
}
.trust-title {
    font-family: 'Manrope', sans-serif;
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 4px;
    letter-spacing: -0.02em;
    transition: color 0.4s ease;
}
.trust-desc {
    font-size: 0.76rem;
    color: var(--text-muted);
    line-height: 1.6;
    font-weight: 300;
    transition: color 0.4s ease;
}

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
    .coupons-grid { grid-template-columns: repeat(2, 1fr); }
    .deal-products-grid { grid-template-columns: repeat(2, 1fr); }
    .deals-trust-inner { grid-template-columns: repeat(2, 1fr); }
    .trust-item:nth-child(2) { border-right: none; }
}
@media (max-width: 860px) {
    .deals-hero { padding: 100px 24px 56px; }
    .coupons-section { padding: 56px 24px; }
    .deal-products-section { padding: 56px 24px; }
    .promo-banner-section { padding: 0 24px; }
    .promo-banner {
        flex-direction: column;
        text-align: center;
        padding: 40px 28px;
    }
    .promo-banner-desc { margin: 0 auto; }
    .deal-products-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    .countdown-wrap { flex-wrap: wrap; }
}
@media (max-width: 600px) {
    .coupons-grid { grid-template-columns: 1fr; }
    .deal-products-grid { grid-template-columns: 1fr; }
    .deals-trust-inner { grid-template-columns: 1fr; }
    .trust-item { border-right: none; border-bottom: 1px solid var(--border); }
    .trust-item:last-child { border-bottom: none; }
    .countdown-box { min-width: 68px; padding: 12px 16px; }
    .countdown-num { font-size: 1.5rem; }
    .deals-hero-title { font-size: 2.4rem; }
}
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════
     HERO — Deals & Promo
═══════════════════════════════════════════════ --}}
<section class="deals-hero">
    <div class="deals-hero-inner">

        <div class="deals-badge">
            <span class="deals-badge-dot"></span>
            Promo Berlangsung
        </div>

        <h1 class="deals-hero-title">
            Penawaran<br><span class="gold-text">Eksklusif.</span>
        </h1>

        <p class="deals-hero-sub">
            Diskon besar-besaran untuk laptop premium pilihan. Hemat hingga jutaan rupiah — hanya untuk waktu terbatas.
        </p>

        {{-- Countdown Timer --}}
        <div class="countdown-wrap">
            <div class="countdown-box">
                <div class="countdown-num" id="cdDays">00</div>
                <div class="countdown-lbl">Hari</div>
            </div>
            <span class="countdown-colon">:</span>
            <div class="countdown-box">
                <div class="countdown-num" id="cdHours">00</div>
                <div class="countdown-lbl">Jam</div>
            </div>
            <span class="countdown-colon">:</span>
            <div class="countdown-box">
                <div class="countdown-num" id="cdMinutes">00</div>
                <div class="countdown-lbl">Menit</div>
            </div>
            <span class="countdown-colon">:</span>
            <div class="countdown-box">
                <div class="countdown-num" id="cdSeconds">00</div>
                <div class="countdown-lbl">Detik</div>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     PROMO COUPONS
═══════════════════════════════════════════════ --}}
<section class="coupons-section">
    <div class="coupons-inner">

        <div class="coupons-header">
            <span class="section-label">Kupon & Voucher</span>
            <h2 class="section-h2">Gunakan Kode Promo</h2>
            <p class="section-desc">Salin kode kupon di bawah dan gunakan saat checkout untuk mendapatkan potongan harga langsung.</p>
        </div>

        <div class="coupons-grid">

            {{-- Coupon 1 --}}
            <div class="coupon-card">
                <div class="coupon-icon-wrap">
                    <i class="bi bi-percent"></i>
                </div>
                <div class="coupon-title">Diskon Rp 500.000</div>
                <div class="coupon-desc">Berlaku untuk pembelian laptop apa pun dengan minimum transaksi Rp 10.000.000.</div>
                <div class="coupon-code-row">
                    <div class="coupon-code" id="code1">LAPTOP500K</div>
                    <button class="coupon-copy-btn" onclick="copyCoupon('code1', this)">
                        <i class="bi bi-clipboard"></i> Salin
                    </button>
                </div>
                <div class="coupon-validity">
                    <i class="bi bi-calendar3"></i> Berlaku hingga 30 Juni 2026
                </div>
            </div>

            {{-- Coupon 2 --}}
            <div class="coupon-card">
                <div class="coupon-icon-wrap">
                    <i class="bi bi-truck"></i>
                </div>
                <div class="coupon-title">Gratis Ongkir Se-Indonesia</div>
                <div class="coupon-desc">Nikmati pengiriman gratis untuk semua produk tanpa minimum pembelian. Seluruh Indonesia.</div>
                <div class="coupon-code-row">
                    <div class="coupon-code" id="code2">FREESHIPID</div>
                    <button class="coupon-copy-btn" onclick="copyCoupon('code2', this)">
                        <i class="bi bi-clipboard"></i> Salin
                    </button>
                </div>
                <div class="coupon-validity">
                    <i class="bi bi-calendar3"></i> Berlaku hingga 15 Juli 2026
                </div>
            </div>

            {{-- Coupon 3 --}}
            <div class="coupon-card">
                <div class="coupon-icon-wrap">
                    <i class="bi bi-mortarboard"></i>
                </div>
                <div class="coupon-title">Student Discount 10%</div>
                <div class="coupon-desc">Eksklusif untuk pelajar & mahasiswa. Verifikasi dengan email institusi saat checkout.</div>
                <div class="coupon-code-row">
                    <div class="coupon-code" id="code3">PEDIA10EDU</div>
                    <button class="coupon-copy-btn" onclick="copyCoupon('code3', this)">
                        <i class="bi bi-clipboard"></i> Salin
                    </button>
                </div>
                <div class="coupon-validity">
                    <i class="bi bi-calendar3"></i> Berlaku hingga 31 Desember 2026
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     PROMO BANNER — Trade-In
═══════════════════════════════════════════════ --}}
<section class="promo-banner-section" style="padding-top: 80px; padding-bottom: 80px;">
    <div class="promo-banner">
        <div class="promo-banner-text">
            <div class="promo-banner-eyebrow">
                <i class="bi bi-arrow-repeat"></i> Program Tukar Tambah
            </div>
            <h3 class="promo-banner-title">
                Tukar Laptop Lama,<br>Dapatkan Hingga <span style="color:var(--gold);">Rp 5.000.000</span>
            </h3>
            <p class="promo-banner-desc">
                Kirimkan laptop lama Anda dan dapatkan potongan harga eksklusif untuk pembelian laptop baru di LaptoPedia. Berlaku untuk semua merek.
            </p>
        </div>
        <a href="{{ route('products.index') }}" class="promo-banner-btn">
            Tukar Sekarang <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     DEAL PRODUCTS
═══════════════════════════════════════════════ --}}
<section class="deal-products-section">
    <div class="deal-products-inner">

        <div class="deal-products-header">
            <div>
                <span class="section-label">Flash Sale</span>
                <h2 class="section-h2">Laptop dengan Harga Spesial</h2>
                <p class="section-desc">Harga sudah termasuk potongan diskon eksklusif. Stok terbatas — jangan sampai kehabisan!</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn-see-all" style="font-family:'Manrope',sans-serif;font-size:0.8rem;font-weight:700;color:var(--gold);border:1px solid rgba(212,168,67,0.3);border-radius:100px;padding:9px 20px;transition:background 0.2s,border-color 0.2s,color 0.2s;white-space:nowrap;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="deal-products-grid">
            @php
                $discounts = [15, 20, 10, 25, 12, 18];
            @endphp

            @forelse($dealProducts as $index => $product)
                @php
                    $discPct  = $discounts[$index % count($discounts)];
                    $oldPrice = $product->price;
                    $newPrice = intval($oldPrice * (1 - $discPct / 100));
                    $saved    = $oldPrice - $newPrice;
                @endphp
                <div class="deal-card" onclick="window.location='{{ route('product.detail', $product->slug) }}'">

                    <div class="deal-card-img">
                        {{-- Discount Badge --}}
                        <span class="deal-discount-badge">-{{ $discPct }}%</span>

                        {{-- Flash timer --}}
                        <span class="deal-flash-badge">
                            <i class="bi bi-lightning-fill"></i> Flash Sale
                        </span>

                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <div style="display:none;align-items:center;justify-content:center;width:100%;height:100%;">
                                <i class="bi bi-laptop deal-placeholder"></i>
                            </div>
                        @else
                            <i class="bi bi-laptop deal-placeholder"></i>
                        @endif
                    </div>

                    <div class="deal-card-body">
                        <div class="deal-card-brand">{{ $product->category->name ?? '—' }}</div>
                        <div class="deal-card-name">{{ $product->name }}</div>
                        <div class="deal-card-desc">{{ $product->description }}</div>

                        <div class="deal-card-footer">
                            <div class="deal-price-group">
                                <span class="deal-price-old">Rp {{ number_format($oldPrice, 0, ',', '.') }}</span>
                                <span class="deal-price-new">Rp {{ number_format($newPrice, 0, ',', '.') }}</span>
                                <span class="deal-saved">Hemat Rp {{ number_format($saved, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('product.detail', $product->slug) }}" class="btn-deal-detail" onclick="event.stopPropagation();">
                                Detail <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                {{-- Fallback jika belum ada produk --}}
                <div style="grid-column:1/-1;text-align:center;padding:80px 24px;color:var(--text-muted);">
                    <i class="bi bi-tag" style="font-size:4rem;opacity:0.18;display:block;margin-bottom:18px;"></i>
                    <h3 style="font-family:'Manrope',sans-serif;font-size:1.3rem;font-weight:800;color:var(--text);margin-bottom:8px;letter-spacing:-0.02em;">Belum Ada Produk Deal</h3>
                    <p style="font-size:0.88rem;">Produk deal akan segera hadir. Nantikan penawaran spesial dari kami!</p>
                    <a href="{{ route('products.index') }}" style="display:inline-flex;align-items:center;gap:6px;margin-top:24px;padding:10px 22px;background:var(--gold-dim);border:1px solid rgba(212,168,67,0.3);color:var(--gold);border-radius:100px;font-size:0.85rem;font-weight:700;font-family:'Manrope',sans-serif;text-decoration:none;transition:background 0.2s;">
                        <i class="bi bi-laptop"></i> Jelajahi Katalog
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     TRUST STRIP
═══════════════════════════════════════════════ --}}
<div class="deals-trust-strip">
    <div class="deals-trust-inner">
        <div class="trust-item">
            <i class="bi bi-shield-lock trust-icon"></i>
            <div class="trust-title">Pembayaran Aman</div>
            <p class="trust-desc">Semua transaksi dienkripsi dan dilindungi keamanan berlapis.</p>
        </div>
        <div class="trust-item">
            <i class="bi bi-patch-check trust-icon"></i>
            <div class="trust-title">100% Produk Resmi</div>
            <p class="trust-desc">Garansi keaslian produk dari distributor resmi Indonesia.</p>
        </div>
        <div class="trust-item">
            <i class="bi bi-arrow-counterclockwise trust-icon"></i>
            <div class="trust-title">30 Hari Pengembalian</div>
            <p class="trust-desc">Kembalikan produk dalam 30 hari jika tidak sesuai ekspektasi.</p>
        </div>
        <div class="trust-item">
            <i class="bi bi-headset trust-icon"></i>
            <div class="trust-title">Dukungan 24/7</div>
            <p class="trust-desc">Tim support kami siap membantu kapan saja Anda butuhkan.</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── COUNTDOWN TIMER ─────────────────────────────────
(function() {
    // Set end date: end of current month at 23:59:59
    const now  = new Date();
    const end  = new Date(now.getFullYear(), now.getMonth() + 1, 0, 23, 59, 59);

    function updateCountdown() {
        const diff = Math.max(0, end - new Date());
        const d = Math.floor(diff / 86400000);
        const h = Math.floor((diff % 86400000) / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);

        document.getElementById('cdDays').textContent    = String(d).padStart(2, '0');
        document.getElementById('cdHours').textContent   = String(h).padStart(2, '0');
        document.getElementById('cdMinutes').textContent = String(m).padStart(2, '0');
        document.getElementById('cdSeconds').textContent = String(s).padStart(2, '0');
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
})();

// ── COPY COUPON CODE ────────────────────────────────
function copyCoupon(codeId, btn) {
    const code = document.getElementById(codeId).textContent;
    navigator.clipboard.writeText(code).then(() => {
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check-lg"></i> Tersalin!';
        btn.classList.add('copied');
        setTimeout(() => {
            btn.innerHTML = orig;
            btn.classList.remove('copied');
        }, 2000);
    });
}
</script>
@endpush
