@extends('layouts.app')

@push('styles')
<style>
    /* =============================================
       HERO — Full viewport, cinematic dark
    ============================================= */
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        background: var(--black);
        padding-top: 52px;
    }

    /* Ambient orbs */
    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(110px);
        pointer-events: none;
        will-change: transform;
    }
    .orb-blue {
        width: 800px; height: 800px;
        background: radial-gradient(circle, rgba(0,113,227,0.16) 0%, transparent 65%);
        top: -250px; right: -150px;
        animation: drift-orb 8s ease-in-out infinite alternate;
    }
    .orb-gold {
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(212,168,67,0.10) 0%, transparent 65%);
        bottom: -120px; left: -80px;
        animation: drift-orb 10s ease-in-out infinite alternate-reverse;
    }

    @keyframes drift-orb {
        from { transform: translate(0, 0) scale(1); }
        to   { transform: translate(30px, -20px) scale(1.06); }
    }

    /* Subtle dot-grid */
    .hero-grid {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
        background-size: 36px 36px;
        mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);
        -webkit-mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);
        pointer-events: none;
    }

    .hero-inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 48px;
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 80px;
        position: relative;
        z-index: 2;
    }

    /* ---- Left ---- */
    .hero-left { animation: fade-up 0.9s ease both; }

    @keyframes fade-up {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--gold);
        padding: 6px 14px;
        border: 1px solid rgba(212,168,67,0.3);
        border-radius: 100px;
        background: rgba(212,168,67,0.07);
        margin-bottom: 26px;
    }

    .eyebrow-pulse {
        width: 6px; height: 6px;
        background: var(--gold);
        border-radius: 50%;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%,100% { opacity: 1; transform: scale(1); }
        50%      { opacity: 0.4; transform: scale(0.65); }
    }

    .hero-title {
        font-size: clamp(3rem, 5.5vw, 5.8rem);
        font-weight: 900;
        line-height: 0.97;
        letter-spacing: -0.05em;
        color: var(--white);
        margin-bottom: 22px;
    }

    .hero-title .gradient-word {
        background: linear-gradient(135deg, #f0d080 0%, var(--gold) 40%, #a0721a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-sub {
        font-size: 1rem;
        font-weight: 300;
        color: rgba(255,255,255,0.5);
        line-height: 1.72;
        max-width: 400px;
        margin-bottom: 40px;
    }

    .hero-btns {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .btn-white {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--white);
        color: #000;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 0.87rem;
        padding: 14px 28px;
        border-radius: 100px;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.2s;
        letter-spacing: -0.01em;
    }
    .btn-white:hover {
        background: #e8e8e8;
        color: #000;
        transform: scale(1.02);
    }

    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: transparent;
        color: rgba(255,255,255,0.7);
        font-family: 'Manrope', sans-serif;
        font-weight: 600;
        font-size: 0.87rem;
        padding: 13px 26px;
        border-radius: 100px;
        border: 1px solid rgba(255,255,255,0.18);
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s, background 0.2s;
    }
    .btn-outline:hover {
        border-color: rgba(255,255,255,0.4);
        color: var(--white);
        background: rgba(255,255,255,0.04);
    }

    .hero-stats {
        display: flex;
        gap: 44px;
        margin-top: 56px;
        padding-top: 40px;
        border-top: 1px solid rgba(255,255,255,0.07);
        animation: fade-up 0.9s 0.2s ease both;
    }

    .stat-num {
        font-family: 'Manrope', sans-serif;
        font-size: 2.2rem;
        font-weight: 900;
        color: var(--white);
        letter-spacing: -0.05em;
        line-height: 1;
    }

    .stat-lbl {
        font-size: 0.72rem;
        color: var(--muted);
        margin-top: 5px;
        font-weight: 400;
        letter-spacing: 0.02em;
    }

    /* ---- Right (Visual) ---- */
    .hero-right {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        animation: fade-up 0.9s 0.15s ease both;
    }

    .hero-glow {
        position: absolute;
        width: 540px; height: 540px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(0,113,227,0.14) 0%, transparent 65%);
        animation: breathe 5s ease-in-out infinite alternate;
    }

    @keyframes breathe {
        from { transform: scale(0.9); opacity: 0.6; }
        to   { transform: scale(1.1); opacity: 1; }
    }

    .hero-laptop {
        position: relative;
        z-index: 2;
        max-width: 100%;
        max-height: 460px;
        object-fit: contain;
        filter: drop-shadow(0 50px 100px rgba(0,0,0,0.7));
        animation: float 6s ease-in-out infinite alternate;
    }

    @keyframes float {
        from { transform: translateY(0) rotate(-1deg); }
        to   { transform: translateY(-20px) rotate(0.5deg); }
    }

    /* =============================================
       FEATURED SECTION
    ============================================= */
    .featured-section {
        background: var(--off-black);
        padding: 112px 48px 104px;
        border-top: 1px solid var(--border);
    }

    .featured-top {
        max-width: 1280px;
        margin: 0 auto 56px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
    }

    .btn-see-all {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: 'Manrope', sans-serif;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--gold);
        border: 1px solid rgba(212,168,67,0.3);
        border-radius: 100px;
        padding: 9px 20px;
        transition: background 0.2s, border-color 0.2s, color 0.2s;
        white-space: nowrap;
    }
    .btn-see-all:hover {
        background: var(--gold-dim);
        border-color: rgba(212,168,67,0.55);
        color: var(--gold-light);
    }

    .products-grid {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    /* ===== PRODUCT CARD ===== */
    .p-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 22px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        position: relative;
        transition:
            border-color 0.35s var(--transition),
            transform 0.35s var(--transition),
            box-shadow 0.35s var(--transition);
        cursor: pointer;
    }
    .p-card:hover {
        border-color: rgba(255,255,255,0.16);
        transform: translateY(-8px);
        box-shadow: 0 28px 70px rgba(0,0,0,0.55);
    }

    .p-badge {
        position: absolute;
        top: 14px; left: 14px;
        font-family: 'Manrope', sans-serif;
        font-size: 0.62rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 100px;
        z-index: 3;
    }
    .p-badge-bs  { background: var(--gold); color: #000; }
    .p-badge-off { background: #ef4444; color: #fff; }
    .p-badge-new { background: #10b981; color: #fff; }

    .p-img-wrap {
        background: linear-gradient(145deg, #1f1f1f, #161616);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 36px 24px 28px;
        height: 210px;
        overflow: hidden;
        position: relative;
    }
    .p-img-wrap::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 50px;
        background: linear-gradient(transparent, rgba(26,26,26,0.6));
        pointer-events: none;
    }
    .p-img-wrap img {
        max-height: 160px;
        max-width: 100%;
        object-fit: contain;
        position: relative;
        z-index: 2;
        transition: transform 0.5s var(--transition);
    }
    .p-card:hover .p-img-wrap img {
        transform: scale(1.07) translateY(-5px);
    }

    .p-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .p-name {
        font-family: 'Manrope', sans-serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--white);
        letter-spacing: -0.02em;
        margin-bottom: 6px;
    }

    .p-stars {
        display: flex;
        align-items: center;
        gap: 2px;
        margin-bottom: 10px;
    }
    .p-stars i { font-size: 0.68rem; color: var(--gold); }
    .p-stars span { font-size: 0.72rem; color: var(--muted); margin-left: 5px; }

    .p-spec {
        font-size: 0.77rem;
        color: rgba(255,255,255,0.35);
        line-height: 1.55;
        font-weight: 300;
        flex: 1;
        margin-bottom: 18px;
    }

    .p-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-top: 16px;
        border-top: 1px solid rgba(255,255,255,0.05);
    }

    .p-price {
        font-family: 'Manrope', sans-serif;
        font-size: 1rem;
        font-weight: 800;
        color: var(--white);
        letter-spacing: -0.03em;
    }
    .p-price small {
        display: block;
        font-size: 0.68rem;
        font-weight: 400;
        color: var(--muted);
        margin-top: 2px;
    }

    .btn-cart {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.11);
        color: var(--white);
        font-family: 'Manrope', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 9px 16px;
        border-radius: 100px;
        cursor: pointer;
        transition: background 0.2s, border-color 0.2s;
        white-space: nowrap;
    }
    .btn-cart:hover {
        background: rgba(255,255,255,0.13);
        border-color: rgba(255,255,255,0.22);
        color: var(--white);
    }

    /* =============================================
       RESPONSIVE
    ============================================= */
    @media (max-width: 1100px) {
        .products-grid { grid-template-columns: repeat(2,1fr); }
    }
    @media (max-width: 860px) {
        .hero-inner {
            grid-template-columns: 1fr;
            gap: 40px;
            text-align: center;
            padding: 60px 24px;
        }
        .hero-sub { max-width: 100%; margin-left: auto; margin-right: auto; }
        .hero-btns { justify-content: center; }
        .hero-stats { justify-content: center; }
        .hero-eyebrow { margin-left: auto; margin-right: auto; }
        .featured-section { padding: 72px 24px; }
        .featured-top { flex-direction: column; align-items: flex-start; gap: 18px; }
        .products-grid { grid-template-columns: repeat(2,1fr); gap: 14px; }
    }
    @media (max-width: 520px) {
        .hero-title { font-size: 2.8rem; }
        .products-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<!-- =============================================
     HERO
============================================= -->
<section class="hero">
    <div class="orb orb-blue"></div>
    <div class="orb orb-gold"></div>
    <div class="hero-grid"></div>

    <div class="hero-inner">
        <!-- LEFT -->
        <div class="hero-left">
            <div class="hero-eyebrow">
                <span class="eyebrow-pulse"></span>
                New Collection 2024
            </div>

            <h1 class="hero-title">
                Best<br>
                Laptops<br>
                <span class="gradient-word">For You.</span>
            </h1>

            <p class="hero-sub">
                Discover premium laptops designed for work, gaming, and creativity.
                Find your perfect match from top brands.
            </p>

            <div class="hero-btns">
                <a href="{{ url('/products') }}" class="btn-white">
                    Shop Now <i class="bi bi-arrow-right"></i>
                </a>
                <a href="#featured" class="btn-outline">
                    Learn More <i class="bi bi-chevron-down"></i>
                </a>
            </div>

            <div class="hero-stats">
                <div>
                    <div class="stat-num">500+</div>
                    <div class="stat-lbl">Laptop Models</div>
                </div>
                <div>
                    <div class="stat-num">50K+</div>
                    <div class="stat-lbl">Happy Customers</div>
                </div>
                <div>
                    <div class="stat-num">4.9</div>
                    <div class="stat-lbl">Rating</div>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="hero-right">
            <div class="hero-glow"></div>
            <img
                class="hero-laptop"
                src="{{ asset('images/Dashboard.png') }}"
                alt="Premium Laptop"
                onerror="this.src='https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=700&q=85';this.onerror=null;">
        </div>
    </div>
</section>


<!-- =============================================
     FEATURED LAPTOPS
============================================= -->
<section class="featured-section" id="featured">

    <div class="featured-top">
        <div>
            <span class="section-label">Handpicked for you</span>
            <h2 class="section-h2">Featured Laptops</h2>
            <p class="section-desc">Our best-selling and most popular models this season.</p>
        </div>
        <a href="{{ url('/products') }}" class="btn-see-all">
            View All <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="products-grid">

        @forelse($products ?? [] as $product)
        <div class="p-card">
            @if($loop->first)
                <span class="p-badge p-badge-bs">Bestseller</span>
            @elseif($loop->index === 1)
                <span class="p-badge p-badge-off">15% Off</span>
            @elseif($loop->index === 2)
                <span class="p-badge p-badge-new">New</span>
            @endif

            <div class="p-img-wrap">
                <img
                    src="{{ $product->image ? asset('storage/'.$product->image) : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&q=80' }}"
                    alt="{{ $product->name }}">
            </div>

            <div class="p-body">
                <div class="p-name">{{ $product->name }}</div>
                <div class="p-stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <span>(4.8)</span>
                </div>
                <div class="p-spec">{{ Str::limit($product->description ?? 'Spesifikasi tersedia di halaman detail produk.', 75) }}</div>
                <div class="p-footer">
                    <div class="p-price">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                        <small>Harga terbaik</small>
                    </div>
                    <button class="btn-cart" onclick="addToCart({{ $product->id }}, event)">
                        <i class="bi bi-bag-plus"></i> Add
                    </button>
                </div>
            </div>
        </div>

        @empty
        {{-- Static fallback --}}
        @php
        $demo = [
            ['name'=>'MacBook Pro 16"',   'badge'=>'bs',  'bl'=>'Bestseller', 'rating'=>'4.9', 'spec'=>'M3 Pro chip · 18GB RAM · 512GB SSD · Liquid Retina XDR', 'price'=>'Rp 15.000...', 'img'=>'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400&q=80'],
            ['name'=>'Dell XPS 15',        'badge'=>'off', 'bl'=>'15% Off',   'rating'=>'4.7', 'spec'=>'Intel i7-13700H · 16GB · 1TB SSD · 4K OLED Touch',    'price'=>'Rp 7.000...',  'img'=>'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=400&q=80'],
            ['name'=>'ASUS ROG Strix G16', 'badge'=>'new', 'bl'=>'New',       'rating'=>'4.8', 'spec'=>'RTX 4070 · i9-13980HX · 32GB · 2TB SSD · 240Hz',      'price'=>'Rp 16.000...', 'img'=>'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=400&q=80'],
            ['name'=>'HP Spectre x360',    'badge'=>'',   'bl'=>'',           'rating'=>'4.5', 'spec'=>'Intel i7 · 16GB · 512GB SSD · OLED Touch · 2-in-1',    'price'=>'Rp 8.000...',  'img'=>'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=400&q=80'],
        ];
        @endphp

        @foreach($demo as $d)
        <div class="p-card">
            @if($d['badge'])
            <span class="p-badge p-badge-{{ $d['badge'] }}">{{ $d['bl'] }}</span>
            @endif

            <div class="p-img-wrap">
                <img src="{{ $d['img'] }}" alt="{{ $d['name'] }}">
            </div>

            <div class="p-body">
                <div class="p-name">{{ $d['name'] }}</div>
                <div class="p-stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <span>({{ $d['rating'] }})</span>
                </div>
                <div class="p-spec">{{ $d['spec'] }}</div>
                <div class="p-footer">
                    <div class="p-price">
                        {{ $d['price'] }}
                        <small>Harga terbaik</small>
                    </div>
                    <button class="btn-cart">
                        <i class="bi bi-bag-plus"></i> Add
                    </button>
                </div>
            </div>
        </div>
        @endforeach
        @endforelse

    </div>
</section>

@endsection

@push('scripts')
<script>
function addToCart(productId, event) {
    event.stopPropagation();
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId, quantity: 1 })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById('cartCount');
            if (badge) badge.textContent = data.cartCount ?? '1';
        }
    })
    .catch(() => { window.location.href = '{{ route("login") }}'; });
}
</script>
@endpush
