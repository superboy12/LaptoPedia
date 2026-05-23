@extends('layouts.app')

@push('styles')
<style>
/* =============================================
   BRANDS PAGE — High-Class Premium Design
============================================= */

/* ── HERO ── */
.brands-hero {
    position: relative;
    padding: 130px 48px 100px;
    text-align: center;
    overflow: hidden;
    background: var(--bg);
}
.brands-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 55% at 50% -5%, rgba(212,168,67,0.13) 0%, transparent 65%),
        radial-gradient(ellipse 50% 80% at 0% 50%, rgba(212,168,67,0.04) 0%, transparent 50%),
        radial-gradient(ellipse 50% 80% at 100% 50%, rgba(160,114,26,0.04) 0%, transparent 50%);
    pointer-events: none;
}
.brands-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 760px;
    margin: 0 auto;
    animation: bHeroIn 0.9s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes bHeroIn {
    from { opacity: 0; transform: translateY(32px); }
    to   { opacity: 1; transform: translateY(0); }
}

.brands-eyebrow {
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
.brands-eyebrow-dot {
    width: 6px; height: 6px;
    background: var(--gold);
    border-radius: 50%;
    animation: bPulse 2s ease-in-out infinite;
}
@keyframes bPulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50%     { opacity: 0.4; transform: scale(0.6); }
}

.brands-hero-title {
    font-family: 'Manrope', sans-serif;
    font-size: clamp(2.8rem, 5.5vw, 4.8rem);
    font-weight: 900;
    line-height: 1.05;
    letter-spacing: -0.05em;
    color: var(--text);
    margin-bottom: 20px;
    transition: color 0.4s ease;
}
.brands-hero-title .gold-grad {
    background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.brands-hero-desc {
    font-size: 1.05rem;
    color: var(--text-muted);
    font-weight: 300;
    line-height: 1.75;
    max-width: 520px;
    margin: 0 auto 44px;
    transition: color 0.4s ease;
}

/* Hero stat counters */
.brands-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 48px;
    animation: bHeroIn 0.9s 0.12s cubic-bezier(0.16,1,0.3,1) both;
}
.brands-stat { text-align: center; }
.brands-stat-num {
    font-family: 'Manrope', sans-serif;
    font-size: 2.2rem;
    font-weight: 900;
    color: var(--text);
    letter-spacing: -0.04em;
    line-height: 1;
    transition: color 0.4s ease;
}
.brands-stat-lbl {
    font-size: 0.72rem;
    color: var(--text-muted);
    margin-top: 5px;
    font-weight: 400;
    letter-spacing: 0.02em;
    transition: color 0.4s ease;
}

/* ── FEATURED BRANDS SHOWCASE ── */
.brands-showcase {
    background: var(--bg-2);
    border-top: 1px solid var(--border);
    padding: 96px 48px 104px;
    transition: background 0.4s ease;
}
.brands-showcase-inner {
    max-width: 1280px;
    margin: 0 auto;
}

.brands-showcase-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 56px;
}
.brands-showcase-header .section-desc { max-width: 420px; }

/* ── BRAND CARDS GRID ── */
.brands-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}

/* Individual Brand Card — Large Showcase Style */
.brand-card {
    position: relative;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 48px 40px;
    display: flex;
    align-items: center;
    gap: 32px;
    text-decoration: none;
    overflow: hidden;
    transition: transform 0.4s cubic-bezier(0.2,0.8,0.2,1), box-shadow 0.4s ease, border-color 0.35s ease;
    animation: bCardIn 0.55s cubic-bezier(0.2,0.8,0.2,1) both;
}
.brand-card:nth-child(1) { animation-delay: 0.04s; }
.brand-card:nth-child(2) { animation-delay: 0.08s; }
.brand-card:nth-child(3) { animation-delay: 0.12s; }
.brand-card:nth-child(4) { animation-delay: 0.16s; }
.brand-card:nth-child(5) { animation-delay: 0.20s; }
.brand-card:nth-child(6) { animation-delay: 0.24s; }
.brand-card:nth-child(7) { animation-delay: 0.28s; }
.brand-card:nth-child(8) { animation-delay: 0.32s; }
.brand-card:nth-child(9) { animation-delay: 0.36s; }
.brand-card:nth-child(10) { animation-delay: 0.40s; }

@keyframes bCardIn {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Subtle gold gradient overlay on hover */
.brand-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 80% 80% at 100% 100%, rgba(212,168,67,0.06) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
}
.brand-card:hover::before { opacity: 1; }

/* Top gold accent bar */
.brand-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #d4a843, #f0d080, #a0721a);
    opacity: 0;
    transition: opacity 0.35s ease;
}
.brand-card:hover::after { opacity: 1; }

.brand-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 24px 56px rgba(0,0,0,0.18);
    border-color: rgba(212,168,67,0.3);
}

/* Logo circle */
.brand-logo-circle {
    flex-shrink: 0;
    width: 88px; height: 88px;
    border-radius: 50%;
    background: var(--bg);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: border-color 0.35s ease, transform 0.35s ease, background 0.3s ease;
}
.brand-logo-circle .brand-letter {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--text-muted);
    line-height: 1;
    transition: color 0.35s ease;
}
.brand-logo-circle i {
    font-size: 1.8rem;
    color: var(--text-muted);
    transition: color 0.35s ease;
}
.brand-card:hover .brand-logo-circle {
    border-color: var(--gold);
    transform: scale(1.06);
    background: rgba(212,168,67,0.06);
}
.brand-card:hover .brand-logo-circle .brand-letter,
.brand-card:hover .brand-logo-circle i {
    color: var(--gold);
}

/* Card text */
.brand-card-info { flex: 1; min-width: 0; }
.brand-card-name {
    font-family: 'Manrope', sans-serif;
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.03em;
    margin-bottom: 6px;
    transition: color 0.4s ease;
}
.brand-card-tagline {
    font-size: 0.82rem;
    color: var(--text-muted);
    font-weight: 300;
    line-height: 1.6;
    margin-bottom: 16px;
    transition: color 0.4s ease;
}

/* Product count + CTA row */
.brand-card-bottom {
    display: flex;
    align-items: center;
    gap: 14px;
}
.brand-product-count {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--text-muted);
    background: var(--bg);
    border: 1px solid var(--border);
    padding: 5px 14px;
    border-radius: 100px;
    font-family: 'DM Sans', sans-serif;
    transition: background 0.3s, color 0.3s, border-color 0.3s;
}
.brand-card:hover .brand-product-count {
    background: rgba(212,168,67,0.08);
    color: var(--gold);
    border-color: rgba(212,168,67,0.25);
}

.brand-cta {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--gold);
    display: inline-flex;
    align-items: center;
    gap: 5px;
    opacity: 0;
    transform: translateX(-6px);
    transition: opacity 0.35s ease, transform 0.35s ease;
    font-family: 'Manrope', sans-serif;
}
.brand-card:hover .brand-cta {
    opacity: 1;
    transform: translateX(0);
}
.brand-cta i {
    font-size: 0.72rem;
    transition: transform 0.2s ease;
}
.brand-card:hover .brand-cta i {
    transform: translateX(3px);
}

/* ── ALL BRANDS STRIP (compact logos row) ── */
.brands-strip {
    background: var(--bg);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 56px 48px;
    transition: background 0.4s ease;
}
.brands-strip-inner {
    max-width: 1280px;
    margin: 0 auto;
    text-align: center;
}
.brands-strip-title {
    font-family: 'Manrope', sans-serif;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.14em;
    color: var(--text-muted);
    margin-bottom: 32px;
    transition: color 0.4s ease;
}
.brands-strip-logos {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 36px;
    flex-wrap: wrap;
}
.strip-logo {
    font-family: 'Manrope', sans-serif;
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--text-muted);
    opacity: 0.4;
    letter-spacing: -0.02em;
    transition: opacity 0.3s ease, color 0.3s ease;
    cursor: default;
}
.strip-logo:hover {
    opacity: 1;
    color: var(--gold);
}

/* ── WHY CHOOSE US ── */
.brands-why {
    background: var(--bg-2);
    border-top: 1px solid var(--border);
    padding: 96px 48px;
    transition: background 0.4s ease;
}
.brands-why-inner {
    max-width: 1280px;
    margin: 0 auto;
}
.brands-why-header {
    text-align: center;
    margin-bottom: 56px;
}
.brands-why-header .section-desc {
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.brands-why-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.why-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 36px 30px;
    text-align: center;
    transition: transform 0.3s cubic-bezier(0.2,0.8,0.2,1), box-shadow 0.3s, border-color 0.3s;
}
.why-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.12);
    border-color: rgba(212,168,67,0.25);
}
.why-icon-wrap {
    width: 56px; height: 56px;
    border-radius: 14px;
    background: var(--gold-dim);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px;
    transition: transform 0.3s ease;
}
.why-card:hover .why-icon-wrap { transform: scale(1.08); }
.why-icon-wrap i {
    font-size: 1.4rem;
    color: var(--gold);
}
.why-title {
    font-family: 'Manrope', sans-serif;
    font-size: 1rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.02em;
    margin-bottom: 8px;
    transition: color 0.4s ease;
}
.why-desc {
    font-size: 0.8rem;
    color: var(--text-muted);
    line-height: 1.65;
    font-weight: 300;
    transition: color 0.4s ease;
}

/* ── CTA BANNER ── */
.brands-cta-section {
    background: var(--bg);
    padding: 96px 48px;
}
.brands-cta-banner {
    max-width: 1280px;
    margin: 0 auto;
    background: linear-gradient(135deg, rgba(212,168,67,0.08), rgba(160,114,26,0.03));
    border: 1px solid rgba(212,168,67,0.2);
    border-radius: 24px;
    padding: 64px;
    text-align: center;
    position: relative;
    overflow: hidden;
    transition: border-color 0.3s ease;
}
.brands-cta-banner::before {
    content: '';
    position: absolute;
    top: -50%; left: 50%;
    transform: translateX(-50%);
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(212,168,67,0.06) 0%, transparent 70%);
    pointer-events: none;
}
.brands-cta-banner:hover { border-color: rgba(212,168,67,0.4); }

.brands-cta-title {
    position: relative;
    font-family: 'Manrope', sans-serif;
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 900;
    color: var(--text);
    letter-spacing: -0.04em;
    line-height: 1.15;
    margin-bottom: 14px;
    transition: color 0.4s ease;
}
.brands-cta-desc {
    position: relative;
    font-size: 0.95rem;
    color: var(--text-muted);
    font-weight: 300;
    line-height: 1.7;
    max-width: 450px;
    margin: 0 auto 32px;
    transition: color 0.4s ease;
}
.brands-cta-btn {
    position: relative;
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
}
.brands-cta-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(212,168,67,0.35);
    color: #000;
}

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
    .brands-grid { grid-template-columns: repeat(2, 1fr); }
    .brands-why-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 860px) {
    .brands-hero { padding: 110px 24px 72px; }
    .brands-showcase { padding: 64px 24px 72px; }
    .brands-why { padding: 64px 24px; }
    .brands-cta-section { padding: 64px 24px; }
    .brands-strip { padding: 40px 24px; }
    .brands-showcase-header { flex-direction: column; align-items: flex-start; gap: 16px; }
    .brands-stats { gap: 32px; }
    .brand-card { padding: 32px 24px; gap: 20px; }
    .brand-logo-circle { width: 68px; height: 68px; }
    .brand-logo-circle .brand-letter { font-size: 1.7rem; }
    .brand-card-name { font-size: 1.15rem; }
    .brands-cta-banner { padding: 48px 28px; }
}
@media (max-width: 600px) {
    .brands-grid { grid-template-columns: 1fr; }
    .brands-why-grid { grid-template-columns: 1fr; }
    .brands-hero-title { font-size: 2.6rem; }
    .brands-stats { flex-wrap: wrap; gap: 24px; }
    .brand-cta { opacity: 1; transform: translateX(0); }
    .brands-strip-logos { gap: 20px; }
}
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════ --}}
<section class="brands-hero">
    <div class="brands-hero-inner">

        <div class="brands-eyebrow">
            <span class="brands-eyebrow-dot"></span>
            Partner Resmi
        </div>

        <h1 class="brands-hero-title">
            Mitra Teknologi<br><span class="gold-grad">Terdepan Dunia.</span>
        </h1>

        <p class="brands-hero-desc">
            Kami hanya bekerja sama dengan produsen laptop paling dihormati di industri.
            Setiap produk dijamin asli dan bergaransi resmi.
        </p>

        <div class="brands-stats">
            <div class="brands-stat">
                <div class="brands-stat-num">{{ $brands->count() }}</div>
                <div class="brands-stat-lbl">Brand Resmi</div>
            </div>
            <div class="brands-stat">
                <div class="brands-stat-num">{{ $brands->sum('products_count') }}+</div>
                <div class="brands-stat-lbl">Produk Tersedia</div>
            </div>
            <div class="brands-stat">
                <div class="brands-stat-num">100%</div>
                <div class="brands-stat-lbl">Garansi Asli</div>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     BRAND LOGO STRIP
═══════════════════════════════════════════════ --}}
<div class="brands-strip">
    <div class="brands-strip-inner">
        <div class="brands-strip-title">Dipercaya oleh merek-merek ternama</div>
        <div class="brands-strip-logos">
            @foreach($brands as $brand)
                <span class="strip-logo">{{ $brand->name }}</span>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     BRAND SHOWCASE CARDS
═══════════════════════════════════════════════ --}}
<section class="brands-showcase">
    <div class="brands-showcase-inner">

        <div class="brands-showcase-header">
            <div>
                <span class="section-label">Koleksi Lengkap</span>
                <h2 class="section-h2">Jelajahi Berdasarkan Merek</h2>
                <p class="section-desc">Pilih merek favorit Anda dan temukan laptop yang sempurna sesuai kebutuhan.</p>
            </div>
        </div>

        <div class="brands-grid">
            @php
                $taglines = [
                    'apple'     => 'Elegan, powerful, dan ekosistem yang seamless untuk kreator & profesional.',
                    'dell'      => 'Performa andal untuk bisnis & personal computing dari Texas, USA.',
                    'asus'      => 'Inovasi tanpa batas — dari gaming hingga ultrabook premium.',
                    'lenovo'    => 'Pilihan #1 enterprise global dengan keandalan ThinkPad legendaris.',
                    'hp'        => 'Desain modern & performa stabil untuk setiap kebutuhan.',
                    'acer'      => 'Teknologi terjangkau tanpa kompromi kualitas untuk semua kalangan.',
                    'msi'       => 'Dominasi arena gaming dengan performa dan pendinginan terbaik.',
                    'samsung'   => 'Display AMOLED memukau dengan desain ultra-tipis khas Samsung.',
                    'razer'     => 'Perangkat premium untuk gamer & kreator konten profesional.',
                    'microsoft' => 'Surface — perpaduan sempurna hardware dan software dari Microsoft.',
                ];
                $icons = [
                    'apple'     => 'bi-apple',
                    'microsoft' => 'bi-windows',
                ];
            @endphp

            @forelse($brands as $brand)
                @php
                    $key = strtolower($brand->name);
                    $tagline = $taglines[$key] ?? 'Koleksi laptop premium dari ' . $brand->name . ' tersedia lengkap.';
                @endphp
                <a href="{{ route('products.index', ['category' => $brand->slug]) }}" class="brand-card">

                    <div class="brand-logo-circle">
                        @if(isset($icons[$key]))
                            <i class="bi {{ $icons[$key] }}"></i>
                        @else
                            <span class="brand-letter">{{ strtoupper(substr($brand->name, 0, 1)) }}</span>
                        @endif
                    </div>

                    <div class="brand-card-info">
                        <div class="brand-card-name">{{ $brand->name }}</div>
                        <div class="brand-card-tagline">{{ $tagline }}</div>
                        <div class="brand-card-bottom">
                            <span class="brand-product-count">
                                <i class="bi bi-laptop" style="font-size:0.7rem;margin-right:3px;"></i>
                                {{ $brand->products_count }} Produk
                            </span>
                            <span class="brand-cta">
                                Lihat Koleksi <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                    </div>

                </a>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:80px 24px;color:var(--text-muted);">
                    <i class="bi bi-tags" style="font-size:4rem;opacity:0.15;display:block;margin-bottom:18px;"></i>
                    <h3 style="font-family:'Manrope',sans-serif;font-size:1.3rem;font-weight:800;color:var(--text);margin-bottom:8px;letter-spacing:-0.02em;">Belum Ada Merek</h3>
                    <p style="font-size:0.88rem;">Belum ada data merek yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     WHY CHOOSE US
═══════════════════════════════════════════════ --}}
<section class="brands-why">
    <div class="brands-why-inner">

        <div class="brands-why-header">
            <span class="section-label">Keunggulan Kami</span>
            <h2 class="section-h2">Mengapa Belanja di LaptoPedia?</h2>
            <p class="section-desc">Kami bukan sekadar toko — kami adalah mitra teknologi Anda.</p>
        </div>

        <div class="brands-why-grid">
            <div class="why-card">
                <div class="why-icon-wrap">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <div class="why-title">Distributor Resmi</div>
                <p class="why-desc">Semua produk dikirim langsung dari distributor resmi Indonesia dengan sertifikat keaslian.</p>
            </div>
            <div class="why-card">
                <div class="why-icon-wrap">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div class="why-title">Garansi Penuh</div>
                <p class="why-desc">Nikmati garansi resmi penuh dari setiap merek, plus perpanjangan garansi eksklusif.</p>
            </div>
            <div class="why-card">
                <div class="why-icon-wrap">
                    <i class="bi bi-headset"></i>
                </div>
                <div class="why-title">Support Premium</div>
                <p class="why-desc">Tim ahli kami siap membantu konsultasi spesifikasi, perbaikan, hingga upgrade 24/7.</p>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     CTA BANNER
═══════════════════════════════════════════════ --}}
<section class="brands-cta-section">
    <div class="brands-cta-banner">
        <h3 class="brands-cta-title">Belum Yakin Pilih Merek Mana?</h3>
        <p class="brands-cta-desc">Jelajahi seluruh katalog kami dan bandingkan spesifikasi dari berbagai merek untuk menemukan laptop sempurna Anda.</p>
        <a href="{{ route('products.index') }}" class="brands-cta-btn">
            Jelajahi Katalog <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</section>

@endsection
