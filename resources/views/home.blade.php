@extends('layouts.app')

@push('styles')
<style>
    /* =============================================
       HERO — Full viewport, cinematic dark
    ============================================= */
    .hero {
        height: 90vh;
        min-height: 600px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background-color: var(--bg);
        overflow: hidden;
        padding-top: 52px; /* navbar height */
    }

    .hero-bg {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover;
        opacity: 0.4;
        transform: scale(1.05);
        transition: transform 10s ease-out;
        z-index: 0;
    }
    .hero:hover .hero-bg { transform: scale(1); }

    /* Vignette effect adaptive to theme */
    .hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle, transparent 15%, var(--bg) 100%);
        pointer-events: none;
        z-index: 1;
    }

    .hero-inner {
        position: relative;
        z-index: 10;
        max-width: 900px;
        padding: 0 2rem;
        color: var(--text);
        animation: fade-up 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    @keyframes fade-up {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }

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
        font-family: 'Manrope', sans-serif;
        font-size: clamp(3.5rem, 6.5vw, 6.8rem);
        font-weight: 900;
        line-height: 0.98;
        letter-spacing: -0.05em;
        color: var(--text);
        margin-bottom: 22px;
        transition: color 0.4s ease;
    }

    .hero-title .gradient-word {
        background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-style: italic;
    }

    .hero-sub {
        font-size: 1rem;
        font-weight: 300;
        color: var(--text-muted);
        line-height: 1.72;
        max-width: 400px;
        margin-bottom: 40px;
        transition: color 0.4s ease;
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
        background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
        color: #000;
        font-family: 'Manrope', sans-serif;
        font-weight: 800;
        font-size: 0.9rem;
        padding: 15px 32px;
        border-radius: 100px;
        border: none;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        letter-spacing: -0.01em;
        box-shadow: 0 4px 14px rgba(212,168,67,0.2);
    }
    .btn-white:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(212,168,67,0.35);
        color: #000;
    }

    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: transparent;
        color: var(--text-muted);
        font-family: 'Manrope', sans-serif;
        font-weight: 600;
        font-size: 0.87rem;
        padding: 13px 26px;
        border-radius: 100px;
        border: 1px solid var(--border);
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s, background 0.2s;
    }
    .btn-outline:hover {
        border-color: var(--border-hover);
        color: var(--text);
        background: var(--search-bg);
    }

    .hero-stats {
        display: flex;
        gap: 44px;
        margin-top: 56px;
        padding-top: 40px;
        border-top: 1px solid var(--border);
        animation: fade-up 0.9s 0.2s ease both;
    }

    .stat-num {
        font-family: 'Manrope', sans-serif;
        font-size: 2.6rem;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.04em;
        line-height: 1;
        transition: color 0.4s ease;
    }

    .stat-lbl {
        font-size: 0.72rem;
        color: var(--text-muted);
        margin-top: 5px;
        font-weight: 400;
        letter-spacing: 0.02em;
        transition: color 0.4s ease;
    }

    /* No longer needed hero-right */

    /* =============================================
       FEATURED SECTION
    ============================================= */
    .featured-section {
        background: var(--bg-2);
        padding: 112px 48px 104px;
        border-top: 1px solid var(--border);
        transition: background 0.4s ease;
    }
    
    .featured-top.reveal {
        transition-delay: 0.1s;
    }
    .products-grid.reveal {
        transition-delay: 0.2s;
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
        grid-template-columns: repeat(2, 1fr);
        gap: 48px;
    }

    /* ===== PRODUCT CARD (Elegant Apple-Style) ===== */
    .p-card {
        background: transparent;
        border: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .p-img-wrap {
        background: var(--surface);
        border-radius: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        height: 380px;
        width: 100%;
        margin-bottom: 24px;
        transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        position: relative;
    }
    .p-img-wrap img {
        max-height: 260px;
        max-width: 100%;
        object-fit: contain;
        transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
        z-index: 2;
    }
    .p-card:hover .p-img-wrap img {
        transform: scale(1.04);
    }

    .p-swatches {
        display: flex;
        gap: 8px;
        justify-content: center;
        margin-bottom: 12px;
    }
    .swatch {
        width: 12px; height: 12px;
        border-radius: 50%;
        border: 1px solid rgba(0,0,0,0.1);
        cursor: pointer;
        transition: transform 0.2s, outline 0.2s;
        outline: 1.5px solid transparent;
        outline-offset: 2px;
    }
    .swatch:hover {
        transform: scale(1.1);
    }
    .swatch.active {
        outline-color: var(--text-muted);
    }
    
    .p-badge {
        font-size: 0.7rem;
        color: #d97706;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .p-name {
        font-family: 'Manrope', sans-serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text);
        letter-spacing: -0.03em;
        margin-bottom: 8px;
    }

    .section-h2 {
        font-family: 'Manrope', sans-serif;
        font-size: clamp(2.5rem, 4vw, 3.2rem);
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.04em;
        margin-bottom: 8px;
        transition: color 0.4s ease;
    }

    .p-desc {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.5;
        max-width: 85%;
        margin: 0 auto 24px;
    }

    .p-actions {
        display: flex;
        align-items: center;
        gap: 16px;
        justify-content: center;
    }
    
    .btn-selengkapnya {
        background: #0071e3;
        color: #fff;
        padding: 8px 18px;
        border-radius: 100px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s, transform 0.2s;
    }
    .btn-selengkapnya:hover {
        background: #0077ED;
        color: #fff;
        transform: scale(1.02);
    }

    .btn-beli {
        color: #0071e3;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 4px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }
    .btn-beli:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .p-img-wrap { height: 320px; padding: 40px; }
        .p-img-wrap img { max-height: 200px; }
    }
    @media (max-width: 860px) {
        .products-grid { grid-template-columns: 1fr; gap: 48px; }
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
    }
    @media (max-width: 520px) {
        .hero-title { font-size: 3.2rem; }
        .p-img-wrap { height: 260px; padding: 20px; border-radius: 24px; }
        .p-img-wrap img { max-height: 160px; }
        .p-name { font-size: 1.4rem; }
    }
</style>
@endpush

@section('content')

<!-- =============================================
     HERO
============================================= -->
<section class="hero detail-hero" style="justify-content: center;">
    <img src="https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?q=80&w=2000" class="hero-bg" alt="Premium Laptops">
    
    <div class="hero-inner" style="text-align: center; max-width: 900px;">

        <h1 class="hero-title" style="margin-bottom: 1.5rem; color: var(--text);">
            Laptop Terbaik<br>
            <span class="gradient-word">Untuk Anda.</span>
        </h1>

        <p class="hero-sub" style="margin-left: auto; margin-right: auto; max-width: 600px; font-size: 1.15rem; color: var(--text-muted);">
            Menemukan ulang batas performa dan keanggunan. Diciptakan khusus untuk para profesional tanpa kompromi.
        </p>

        <div class="hero-btns" style="justify-content: center; margin-bottom: 50px;">
            <a href="{{ url('/products') }}" class="btn-white">
                Beli Sekarang <i class="bi bi-arrow-right"></i>
            </a>
            <a href="#featured" class="btn-outline" style="color: var(--text); border-color: var(--border);">
                Pelajari Lanjut <i class="bi bi-chevron-down"></i>
            </a>
        </div>

        <div class="hero-stats reveal" style="justify-content: center; border-top: none; padding-top: 0;">
            <div>
                <div class="stat-num" style="color: var(--text);">500+</div>
                <div class="stat-lbl" style="color: var(--text-muted);">Model Laptop</div>
            </div>
            <div>
                <div class="stat-num" style="color: var(--text);">50K+</div>
                <div class="stat-lbl" style="color: var(--text-muted);">Pelanggan Puas</div>
            </div>
            <div>
                <div class="stat-num" style="color: var(--text);">4.9</div>
                <div class="stat-lbl" style="color: var(--text-muted);">Penilaian</div>
            </div>
        </div>
    </div>
</section>

<!-- =============================================
     FEATURED LAPTOPS (DEMO PRODUCTS)
============================================= -->
<section class="featured-section" id="featured">
    <div class="featured-top reveal">
        <div>
            <span class="section-label">Pilihan Khusus Untuk Anda</span>
            <h2 class="section-h2">Laptop Unggulan</h2>
            <p class="section-desc">Model terlaris dan paling populer kami musim ini.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn-see-all">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="products-grid reveal">
        @forelse($products as $product)
        <div class="p-card" onclick="window.location='{{ route('product.detail', $product->slug) }}'">
            <div class="p-img-wrap">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div style="display:none;align-items:center;justify-content:center;width:100%;height:100%;">
                        <i class="bi bi-laptop" style="font-size:5rem;color:var(--text-muted);opacity:0.25;"></i>
                    </div>
                @else
                    <i class="bi bi-laptop" style="font-size:5rem;color:var(--text-muted);opacity:0.25;"></i>
                @endif
            </div>
            
            <div class="p-swatches">
                <div class="swatch active" style="background:#5e5e60;" onclick="selectColor(this, event)"></div>
                <div class="swatch" style="background:#e3e4e5;" onclick="selectColor(this, event)"></div>
                <div class="swatch" style="background:#fce0d8;" onclick="selectColor(this, event)"></div>
            </div>
            
            @if($loop->first)
            <div class="p-badge">Baru</div>
            @endif

            <div class="p-name">{{ $product->name }}</div>
            <div class="p-desc">{{ Str::limit($product->description, 50) }}</div>

            <div class="p-actions">
                <a href="{{ route('product.detail', $product->slug) }}" class="btn-selengkapnya" onclick="event.stopPropagation();">
                    Selengkapnya
                </a>
                <button class="btn-beli" onclick="event.stopPropagation(); addToCart(this, {{ $product->id }});">
                    Beli <i class="bi bi-bag-plus" style="font-size:0.9rem;"></i>
                </button>
            </div>
        </div>
        @empty
        {{-- Fallback jika belum ada produk di DB --}}
        <div class="p-card">
            <div class="p-img-wrap">
                <i class="bi bi-laptop" style="font-size:5rem;color:var(--text-muted);opacity:0.2;"></i>
            </div>
            <div class="p-name">Belum Ada Produk</div>
            <div class="p-desc">Admin belum menambahkan produk. Silakan login sebagai admin untuk menambahkan produk.</div>
        </div>
        @endforelse
    </div>
</section>

@push('scripts')
<script>
// SWATCH COLOR SELECTION
function selectColor(element, event) {
    event.stopPropagation();
    const swatches = element.parentElement.querySelectorAll('.swatch');
    swatches.forEach(s => s.classList.remove('active'));
    element.classList.add('active');
}

// ADD TO CART FUNCTION DENGAN AJAX (SESSION)
async function addToCart(button, productId) {
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="bi bi-hourglass-split"></i>...';
    button.disabled = true;

    try {
        const res = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        });
        const data = await res.json();
        
        if (data.success) {
            button.innerHTML = '<i class="bi bi-check-lg"></i>';
            button.style.background = '#10b981';
            button.style.borderColor = '#10b981';
            button.style.color = '#fff';
            
            // Update badge cart menggunakan fungsi global di app.blade.php
            if (typeof refreshCartCount === 'function') {
                refreshCartCount(data.cartCount);
            }
        }
    } catch(e) {
        console.error(e);
        button.innerHTML = '<i class="bi bi-exclamation-triangle"></i>';
    }
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        button.style.background = '';
        button.style.borderColor = '';
        button.style.color = '';
    }, 1500);
}

// 3D Tilt Effect on Laptop Image (Removed for cinematic layout)
// document.addEventListener('DOMContentLoaded', () => { ... });

// Intersection Observer for Scroll Reveal
document.addEventListener('DOMContentLoaded', () => {
    const reveals = document.querySelectorAll('.reveal');
    
    const revealOnScroll = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target);
            }
        });
    }, {
        root: null,
        threshold: 0.15,
        rootMargin: "0px 0px -50px 0px"
    });

    reveals.forEach(reveal => {
        revealOnScroll.observe(reveal);
    });
});
</script>
@endpush
@endsection