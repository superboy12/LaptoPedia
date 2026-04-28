@extends('layouts.app')

@section('content')
<style>
    /* Mengimpor Font Serif Editorial */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600&display=swap');

    :root {
        --edit-black: #0f172a;
        --edit-gray: #64748b;
        --edit-light: #f8fafc;
        --edit-accent: #cda434; /* Emas tipis / Champagne */
    }

    body {
        background-color: #ffffff;
        font-family: 'Inter', sans-serif;
        color: var(--edit-black);
    }

    /* Typographic Utilities */
    .font-serif { font-family: 'Playfair Display', serif; }
    .text-accent { color: var(--edit-accent); }
    .tracking-widest { letter-spacing: 0.2em; }
    .leading-relaxed { line-height: 1.8; }

    /* 1. HERO COVER SECTION */
    .editorial-hero {
        height: 90vh;
        min-height: 600px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background-color: var(--edit-black);
        overflow: hidden;
    }

    .hero-bg {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover;
        opacity: 0.4;
        transform: scale(1.05);
        transition: transform 10s ease-out;
    }
    
    .editorial-hero:hover .hero-bg { transform: scale(1); }

    .hero-content {
        position: relative;
        z-index: 10;
        max-width: 900px;
        padding: 0 2rem;
        color: #ffffff;
    }

    .hero-category {
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 4px;
        margin-bottom: 2rem;
        display: block;
        color: rgba(255,255,255,0.7);
    }

    .hero-title {
        font-size: clamp(3rem, 8vw, 6.5rem);
        font-weight: 800;
        line-height: 1;
        margin-bottom: 1.5rem;
        letter-spacing: -2px;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        font-weight: 300;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* 2. OVERVIEW STORY SECTION */
    .story-section { padding: 8rem 0; }
    .quote-mark { font-size: 4rem; color: var(--edit-accent); line-height: 0; margin-bottom: 1rem; font-family: 'Playfair Display', serif; }
    .story-text {
        font-size: clamp(1.5rem, 4vw, 2.5rem);
        line-height: 1.4;
        color: var(--edit-black);
        text-align: center;
        max-width: 1000px;
        margin: 0 auto;
    }

    /* 3. MAGAZINE GALLERY GRID */
    .mag-grid { display: grid; grid-template-columns: 1fr; gap: 2rem; margin: 4rem 0; }
    @media (min-width: 768px) {
        .mag-grid { grid-template-columns: 7fr 5fr; }
    }
    .mag-img-wrapper { overflow: hidden; position: relative; background: var(--edit-light); }
    .mag-img { width: 100%; height: 100%; object-fit: cover; transition: transform 1.2s cubic-bezier(0.2, 0.8, 0.2, 1); }
    .mag-img-wrapper:hover .mag-img { transform: scale(1.05); }
    
    .img-tall { height: 600px; }
    .img-short { height: 400px; margin-top: auto; }

    /* 4. PERFORMANCE HIGHLIGHTS */
    .spec-section { background-color: var(--edit-light); padding: 8rem 0; }
    .spec-line { width: 40px; height: 2px; background-color: var(--edit-accent); margin-bottom: 1.5rem; }
    .spec-highlight { margin-bottom: 3rem; }
    .spec-title { font-size: 1rem; text-transform: uppercase; letter-spacing: 2px; color: var(--edit-gray); margin-bottom: 0.5rem; }
    .spec-value { font-size: 2.5rem; font-weight: 600; color: var(--edit-black); letter-spacing: -1px; line-height: 1.2; }
    .spec-desc { font-size: 0.95rem; color: var(--edit-gray); margin-top: 0.5rem; }

    /* 5. TESTIMONIALS */
    .testimonial-section { padding: 8rem 0; }
    .testimonial-card { text-align: center; max-width: 700px; margin: 0 auto; }
    .testi-stars { color: var(--edit-accent); font-size: 0.9rem; margin-bottom: 1.5rem; }
    .testi-quote { font-size: 1.8rem; line-height: 1.5; color: var(--edit-black); margin-bottom: 2rem; font-style: italic; }
    .testi-author { font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; }

    /* 6. STICKY ELEGANT ACTION BAR */
    .action-bar {
        position: sticky; bottom: 0;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(15px);
        padding: 1.5rem 0;
        border-top: 1px solid #f1f5f9;
        z-index: 100;
        box-shadow: 0 -10px 40px rgba(0,0,0,0.03);
    }
    
    .price-editorial { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; margin: 0; }
    
    .btn-ghost { border: 1px solid var(--edit-black); background: transparent; color: var(--edit-black); padding: 12px 30px; font-weight: 500; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1.5px; transition: all 0.4s; border-radius: 0; }
    .btn-ghost:hover { background: var(--edit-black); color: white; }
    
    .btn-solid { border: 1px solid var(--edit-black); background: var(--edit-black); color: white; padding: 12px 30px; font-weight: 500; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1.5px; transition: all 0.4s; border-radius: 0; }
    .btn-solid:hover { background: transparent; color: var(--edit-black); }

    /* ANIMATIONS (Triggered via JS Intersection Observer) */
    .fade-up { opacity: 0; transform: translateY(50px); transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1); }
    .fade-up.is-visible { opacity: 1; transform: translateY(0); }
    
    .delay-100 { transition-delay: 100ms; }
    .delay-200 { transition-delay: 200ms; }
</style>

<section class="editorial-hero">
    @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="Cover" class="hero-bg">
    @else
        <img src="https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?q=80&w=2070&auto=format&fit=crop" alt="Cover" class="hero-bg">
    @endif
    
    <div class="hero-content fade-up is-visible">
        <span class="hero-category font-serif tracking-widest">Editorial Choice</span>
        <h1 class="hero-title font-serif">{{ $product->name }}</h1>
        <p class="hero-subtitle">Mendefinisikan ulang batas performa dan keanggunan. Diciptakan khusus untuk para profesional tanpa kompromi.</p>
    </div>
</section>

<section class="story-section container">
    <div class="fade-up">
        <div class="text-center"><span class="quote-mark">“</span></div>
        <h2 class="story-text font-serif">
            Bukan sekadar perangkat keras. Ini adalah kanvas digital yang dirancang untuk mewujudkan visi terbesar Anda dengan presisi absolut.
        </h2>
    </div>
    
    <div class="row justify-content-center mt-5 pt-4 fade-up delay-100">
        <div class="col-md-8 text-center text-muted leading-relaxed">
            <p>{{ $product->description }} Setiap milimeter dari perangkat ini diukir dengan ketelitian tingkat tinggi, menghadirkan estetika minimalis yang menyembunyikan tenaga buas di dalamnya. Pengalaman visual yang tak tertandingi berpadu dengan arsitektur termal revolusioner.</p>
        </div>
    </div>
</section>

<section class="container pb-5">
    <div class="mag-grid fade-up">
        <div class="mag-img-wrapper img-tall">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Detail 1" class="mag-img">
            @else
                <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=1926&auto=format&fit=crop" alt="Detail" class="mag-img">
            @endif
        </div>
        <div class="d-flex flex-column gap-4">
            <div class="mag-img-wrapper img-short">
                <img src="https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?q=80&w=1964&auto=format&fit=crop" alt="Detail" class="mag-img">
            </div>
            <div class="p-4" style="background: var(--edit-light);">
                <h4 class="font-serif mb-3">Keindahan Fungsional</h4>
                <p class="text-muted small leading-relaxed mb-0">Keyboard taktil yang disempurnakan dan trackpad luas berbahan kaca menghadirkan kenyamanan absolut untuk sesi kerja panjang.</p>
            </div>
        </div>
    </div>
</section>

<section class="spec-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-5 mb-lg-0 fade-up">
                <h2 class="font-serif display-5 fw-bold mb-4">Mendobrak<br>Batas.</h2>
                <p class="text-muted leading-relaxed">Arsitektur kustom yang mengoptimalkan aliran daya secara real-time. Efisiensi luar biasa tanpa mengorbankan setetes pun performa grafis.</p>
            </div>
            <div class="col-lg-7 offset-lg-1">
                <div class="row">
                    <div class="col-md-6 spec-highlight fade-up delay-100">
                        <div class="spec-line"></div>
                        <div class="spec-title">Arsitektur Inti</div>
                        <div class="spec-value font-serif">M-Class Pro</div>
                        <div class="spec-desc">Neural engine 16-core terintegrasi.</div>
                    </div>
                    <div class="col-md-6 spec-highlight fade-up delay-200">
                        <div class="spec-line"></div>
                        <div class="spec-title">Memori Bersatu</div>
                        <div class="spec-value font-serif">32 GB</div>
                        <div class="spec-desc">Bandwidth memori hingga 200GB/s.</div>
                    </div>
                    <div class="col-md-6 spec-highlight fade-up delay-100">
                        <div class="spec-line"></div>
                        <div class="spec-title">Penyimpanan</div>
                        <div class="spec-value font-serif">1 TB SSD</div>
                        <div class="spec-desc">Kecepatan baca superior 7.4GB/s.</div>
                    </div>
                    <div class="col-md-6 spec-highlight fade-up delay-200">
                        <div class="spec-line"></div>
                        <div class="spec-title">Retina XDR</div>
                        <div class="spec-value font-serif">1000 Nits</div>
                        <div class="spec-desc">Akurasi warna standar sinema (DCI-P3).</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="testimonial-section container">
    <div class="testimonial-card fade-up">
        <div class="testi-stars">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
        </div>
        <h3 class="testi-quote font-serif">
            "Ini bukan sekadar peningkatan spesifikasi. Ini adalah revolusi cara saya menyunting video 8K. Sangat senyap, sangat brilian."
        </h3>
        <p class="testi-author">— Sarah Williams, Lead Editor di Vogue</p>
    </div>
</section>

<div class="action-bar">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <h4 class="font-serif fw-bold m-0 d-none d-md-block">{{ $product->name }}</h4>
            <span class="d-none d-md-block text-muted">|</span>
            <p class="price-editorial">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        </div>
        <div class="d-flex gap-2 w-100 w-md-auto">
            <form action="#" method="POST" class="w-50 w-md-auto">
                @csrf
                <button type="submit" class="btn-ghost w-100">Tote Bag</button> </form>
            <button class="btn-solid w-50 w-md-auto">Acquire</button> </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.15 // Elemen muncul saat 15% bagiannya terlihat
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target); // Hanya animasi 1x
                }
            });
        }, observerOptions);

        const fadeElements = document.querySelectorAll('.fade-up');
        fadeElements.forEach(el => observer.observe(el));
    });
</script>
@endsection