@extends('layouts.app')

@push('styles')
<style>
    /* =============================================
       PRODUCT DETAIL — Premium Minimalist Magazine
    ============================================= */
    .detail-page {
        min-height: 100vh;
        background: var(--bg);
        transition: background 0.4s ease;
        padding-bottom: 100px; /* space for sticky bar */
    }

    /* 1. HERO COVER SECTION */
    .detail-hero {
        height: 90vh;
        min-height: 600px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background-color: var(--black);
        overflow: hidden;
        margin-top: 52px; /* navbar height */
    }

    .detail-hero-bg {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover;
        opacity: 0.4;
        transform: scale(1.05);
        transition: transform 10s ease-out;
    }
    .detail-hero:hover .detail-hero-bg { transform: scale(1); }

    /* Vignette effect to ensure text readability */
    .detail-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle, transparent 20%, rgba(0,0,0,0.8) 100%);
        pointer-events: none;
    }

    .detail-hero-content {
        position: relative;
        z-index: 10;
        max-width: 900px;
        padding: 0 2rem;
        color: #ffffff; /* Selalu putih di atas hero image */
        animation: fade-up 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .detail-hero-category {
        text-transform: uppercase;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.3em;
        margin-bottom: 2rem;
        display: block;
        color: var(--gold);
    }

    .detail-hero-title {
        font-family: 'Manrope', sans-serif;
        font-size: clamp(3.5rem, 8vw, 6.5rem);
        font-weight: 900;
        line-height: 1.05;
        margin-bottom: 1.5rem;
        letter-spacing: -0.04em;
    }

    .detail-hero-subtitle {
        font-size: 1.15rem;
        font-weight: 300;
        opacity: 0.85;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* 2. OVERVIEW STORY SECTION */
    .detail-story { padding: 8rem 2rem; text-align: center; }
    .quote-mark { 
        font-size: 5rem; 
        color: var(--gold); 
        line-height: 0; 
        margin-bottom: 1.5rem; 
        font-family: 'Times New Roman', serif; 
        opacity: 0.5;
    }
    .story-text {
        font-family: 'Manrope', sans-serif;
        font-size: clamp(1.5rem, 4vw, 2.8rem);
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1.3;
        color: var(--text);
        max-width: 900px;
        margin: 0 auto 3rem;
        transition: color 0.4s ease;
    }
    .story-desc {
        font-size: 1rem;
        color: var(--text-muted);
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
        font-weight: 300;
        transition: color 0.4s ease;
    }

    /* 3. MAGAZINE GALLERY GRID */
    .mag-grid-wrap {
        max-width: 1280px;
        margin: 0 auto 8rem;
        padding: 0 2rem;
    }
    .mag-grid { 
        display: grid; 
        grid-template-columns: 1fr; 
        gap: 2rem; 
    }
    @media (min-width: 900px) {
        .mag-grid { grid-template-columns: 7fr 5fr; }
    }
    
    .mag-img-card { 
        background: var(--surface-2); 
        border-radius: 24px;
        overflow: hidden; 
        position: relative; 
        border: 1px solid var(--border);
        transition: background 0.4s ease, border-color 0.4s ease;
    }
    .mag-img-inner {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .mag-img { 
        max-width: 100%; 
        max-height: 100%; 
        object-fit: contain; 
        transition: transform 0.8s cubic-bezier(0.2, 0.8, 0.2, 1); 
    }
    .mag-img-card:hover .mag-img { transform: scale(1.08) translateY(-10px); }
    
    .img-tall { height: 650px; }
    .img-short { height: 400px; }

    .mag-text-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 3rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        transition: background 0.4s ease, border-color 0.4s ease;
    }
    .mag-text-card h4 {
        font-family: 'Manrope', sans-serif;
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.03em;
        margin-bottom: 1rem;
        transition: color 0.4s ease;
    }
    .mag-text-card p {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.7;
        font-weight: 300;
        margin: 0;
        transition: color 0.4s ease;
    }

    /* 4. PERFORMANCE HIGHLIGHTS */
    .spec-section { 
        background: var(--surface); 
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        padding: 8rem 0; 
        transition: background 0.4s ease, border-color 0.4s ease;
    }
    .spec-inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: 1fr;
        gap: 4rem;
    }
    @media (min-width: 900px) {
        .spec-inner { grid-template-columns: 1fr 1.5fr; gap: 6rem; align-items: center; }
    }

    .spec-left h2 {
        font-family: 'Manrope', sans-serif;
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 900;
        line-height: 1.05;
        color: var(--text);
        letter-spacing: -0.04em;
        margin-bottom: 1.5rem;
        transition: color 0.4s ease;
    }
    .spec-left p {
        color: var(--text-muted);
        font-size: 1.05rem;
        line-height: 1.7;
        font-weight: 300;
        transition: color 0.4s ease;
    }

    .spec-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem 2rem;
    }
    .spec-line { width: 40px; height: 2px; background: var(--gold); margin-bottom: 1.5rem; border-radius: 2px; }
    .spec-title { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--text-muted); margin-bottom: 0.5rem; font-weight: 700; transition: color 0.4s ease;}
    .spec-value { 
        font-family: 'Manrope', sans-serif;
        font-size: 2.2rem; 
        font-weight: 800; 
        color: var(--text); 
        letter-spacing: -0.03em; 
        line-height: 1.2; 
        transition: color 0.4s ease;
    }
    .spec-desc { font-size: 0.85rem; color: var(--text-muted); margin-top: 0.5rem; font-weight: 300; transition: color 0.4s ease;}

    /* 5. TESTIMONIALS */
    .testimonial-section { padding: 8rem 2rem; text-align: center; }
    .testimonial-card { max-width: 800px; margin: 0 auto; }
    .testi-stars { color: var(--gold); font-size: 1rem; margin-bottom: 2rem; letter-spacing: 2px; }
    .testi-quote { 
        font-family: 'Manrope', sans-serif;
        font-size: clamp(1.4rem, 3vw, 2rem); 
        line-height: 1.5; 
        font-weight: 700;
        color: var(--text); 
        margin-bottom: 2.5rem; 
        letter-spacing: -0.02em;
        transition: color 0.4s ease;
    }
    .testi-author { 
        font-weight: 700; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        letter-spacing: 0.15em; 
        color: var(--text-muted);
        transition: color 0.4s ease;
    }

    /* 6. STICKY ELEGANT ACTION BAR */
    .action-bar {
        position: fixed; 
        bottom: 0; left: 0; right: 0;
        background: var(--surface);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 1.2rem 2rem;
        border-top: 1px solid var(--border);
        z-index: 999;
        box-shadow: 0 -10px 40px rgba(0,0,0,0.1);
        transition: background 0.4s ease, border-color 0.4s ease;
    }
    
    .action-inner {
        max-width: 1280px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .action-info { display: flex; align-items: center; gap: 1.5rem; }
    .action-name { 
        font-family: 'Manrope', sans-serif; 
        font-weight: 800; 
        font-size: 1.1rem; 
        color: var(--text); 
        margin: 0; 
        transition: color 0.4s ease;
    }
    .action-price { 
        font-family: 'Manrope', sans-serif; 
        font-size: 1.3rem; 
        font-weight: 900; 
        color: var(--text); 
        margin: 0; 
        letter-spacing: -0.02em;
        transition: color 0.4s ease;
    }
    
    .action-btns { display: flex; gap: 1rem; }
    
    .btn-action-outline { 
        border: 1px solid var(--border); 
        background: transparent; 
        color: var(--text); 
        padding: 12px 24px; 
        font-weight: 700; 
        font-size: 0.8rem; 
        text-transform: uppercase; 
        letter-spacing: 0.1em; 
        border-radius: 100px;
        transition: all 0.3s ease; 
        cursor: pointer;
    }
    .btn-action-outline:hover { background: var(--search-bg); border-color: var(--border-hover); }
    
    .btn-action-solid { 
        background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
        border: none;
        color: #000; 
        padding: 12px 32px; 
        font-weight: 800; 
        font-size: 0.85rem; 
        border-radius: 100px;
        transition: transform 0.2s, box-shadow 0.2s; 
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-action-solid:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(212,168,67,0.3); }

    /* ANIMATIONS (Triggered via JS Intersection Observer) */
    .reveal-up { 
        opacity: 0; 
        transform: translateY(40px); 
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); 
    }
    .reveal-up.is-visible { opacity: 1; transform: translateY(0); }
    
    .delay-100 { transition-delay: 100ms; }
    .delay-200 { transition-delay: 200ms; }
    .delay-300 { transition-delay: 300ms; }

    @media (max-width: 768px) {
        .action-inner { flex-direction: column; align-items: stretch; }
        .action-info { justify-content: space-between; margin-bottom: 1rem; }
        .action-name { display: none; }
        .spec-grid { grid-template-columns: 1fr; gap: 2rem; }
    }
</style>
@endpush

@section('content')
<div class="detail-page">

    {{-- HERO SECTION --}}
    <section class="detail-hero">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="Cover" class="detail-hero-bg">
        @else
            <img src="https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?q=80&w=2070&auto=format&fit=crop" alt="Cover" class="detail-hero-bg">
        @endif
        
        <div class="detail-hero-content">
            <span class="detail-hero-category">Mahakarya Teknologi</span>
            <h1 class="detail-hero-title">{{ $product->name }}</h1>
            <p class="detail-hero-subtitle">Mendefinisikan ulang batas performa dan keanggunan. Diciptakan khusus untuk para profesional tanpa kompromi.</p>
        </div>
    </section>

    {{-- OVERVIEW STORY --}}
    <section class="detail-story">
        <div class="reveal-up">
            <div class="quote-mark">“</div>
            <h2 class="story-text">
                Bukan sekadar perangkat keras. Ini adalah kanvas digital yang dirancang untuk mewujudkan visi terbesar Anda dengan presisi absolut.
            </h2>
        </div>
        
        <div class="reveal-up delay-100">
            <p class="story-desc">
                {{ $product->description ?? 'Setiap milimeter dari perangkat ini diukir dengan ketelitian tingkat tinggi, menghadirkan estetika minimalis yang menyembunyikan tenaga buas di dalamnya. Pengalaman visual yang tak tertandingi berpadu dengan arsitektur termal revolusioner.' }}
            </p>
        </div>
    </section>

    {{-- MAGAZINE GALLERY GRID --}}
    <section class="mag-grid-wrap">
        <div class="mag-grid reveal-up">
            <div class="mag-img-card img-tall">
                <div class="mag-img-inner">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Detail 1" class="mag-img">
                    @else
                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=1926&auto=format&fit=crop" alt="Detail" class="mag-img">
                    @endif
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <div class="mag-img-card img-short">
                    <div class="mag-img-inner">
                        <img src="https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?q=80&w=1964&auto=format&fit=crop" alt="Detail" class="mag-img">
                    </div>
                </div>
                <div class="mag-text-card">
                    <h4>Keindahan Fungsional</h4>
                    <p>Keyboard taktil yang disempurnakan dan trackpad luas berbahan kaca menghadirkan kenyamanan absolut untuk sesi kerja atau gaming yang panjang tanpa henti.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- PERFORMANCE HIGHLIGHTS --}}
    <section class="spec-section">
        <div class="spec-inner">
            <div class="spec-left reveal-up">
                <h2>Mendobrak<br>Batas.</h2>
                <p>Arsitektur kustom yang mengoptimalkan aliran daya secara real-time. Efisiensi luar biasa tanpa mengorbankan setetes pun performa grafis maupun komputasi.</p>
            </div>
            <div class="spec-right">
                <div class="spec-grid">
                    <div class="reveal-up delay-100">
                        <div class="spec-line"></div>
                        <div class="spec-title">Arsitektur Inti</div>
                        <div class="spec-value">Pro-Class</div>
                        <div class="spec-desc">Prosesor generasi terbaru terintegrasi.</div>
                    </div>
                    <div class="reveal-up delay-200">
                        <div class="spec-line"></div>
                        <div class="spec-title">Memori Ekstrem</div>
                        <div class="spec-value">Up to 32GB</div>
                        <div class="spec-desc">Bandwidth memori sangat cepat tanpa lag.</div>
                    </div>
                    <div class="reveal-up delay-100">
                        <div class="spec-line"></div>
                        <div class="spec-title">Penyimpanan</div>
                        <div class="spec-value">1 TB SSD</div>
                        <div class="spec-desc">Kecepatan baca & tulis superior.</div>
                    </div>
                    <div class="reveal-up delay-200">
                        <div class="spec-line"></div>
                        <div class="spec-title">Layar Memukau</div>
                        <div class="spec-value">True Color</div>
                        <div class="spec-desc">Akurasi warna standar sinema profesional.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="testimonial-section">
        <div class="testimonial-card reveal-up">
            <div class="testi-stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            </div>
            <h3 class="testi-quote">
                "Ini bukan sekadar peningkatan spesifikasi. Ini adalah revolusi cara saya bekerja. Sangat senyap, sangat brilian, performa tanpa batas."
            </h3>
            <p class="testi-author">— Sarah Williams, Creative Director</p>
        </div>
    </section>

    {{-- STICKY ACTION BAR --}}
    <div class="action-bar">
        <div class="action-inner">
            <div class="action-info">
                <h4 class="action-name">{{ $product->name }}</h4>
                <p class="action-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
            <div class="action-btns">
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/') }}" class="btn-action-outline">
                    Kembali
                </a>
                <button class="btn-action-solid" onclick="addToCartDetail('{{ $product->name }}', {{ $product->price }})">
                    <i class="bi bi-bag-plus"></i> Masukkan Keranjang
                </button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    // Intersection Observer untuk animasi scroll
    document.addEventListener("DOMContentLoaded", function() {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.15
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
    });

    // Fungsi Add to Cart untuk Demo Mode
    function addToCartDetail(productName, price) {
        const btn = document.querySelector('.btn-action-solid');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class="bi bi-check-lg"></i> Berhasil Ditambahkan!';
        btn.disabled = true;
        btn.style.background = '#10b981';
        btn.style.color = '#fff';
        
        let cart = JSON.parse(localStorage.getItem('my_cart') || '[]');
        let existing = cart.find(item => item.name === productName);
        
        if (existing) {
            existing.quantity += 1;
        } else {
            cart.push({ name: productName, quantity: 1, price: price });
        }
        
        localStorage.setItem('my_cart', JSON.stringify(cart));
        
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        const cartBadge = document.getElementById('cartCount');
        if (cartBadge) {
            cartBadge.textContent = totalItems;
            cartBadge.style.transform = 'scale(1.2)';
            setTimeout(() => cartBadge.style.transform = '', 200);
        }
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            btn.style.background = '';
            btn.style.color = '';
        }, 1500);
    }
</script>
@endpush
@endsection