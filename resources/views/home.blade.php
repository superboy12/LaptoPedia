@extends('layouts.app')

@section('content')
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #1e3a8a 0%, #172554 100%);
        color: white;
        padding: 5rem 0 7rem 0; /* Padding bawah ditambah untuk ruang Marquee */
        border-radius: 0 0 50px 50px;
        position: relative;
        overflow: visible;
    }
    
    /* ANIMASI 1: Tombol Berdenyut (Pulse) */
    .btn-yellow { 
        background: var(--accent-yellow); color: #000; font-weight: 700; 
        padding: 12px 28px; border-radius: 50px; border: none; 
        transition: 0.3s;
        animation: pulse-glow 2s infinite;
    }
    .btn-yellow:hover { transform: scale(1.05); }
    
    @keyframes pulse-glow {
        0% { box-shadow: 0 0 0 0 rgba(250, 204, 21, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(250, 204, 21, 0); }
        100% { box-shadow: 0 0 0 0 rgba(250, 204, 21, 0); }
    }
    
    .btn-outline-light-custom { border: 2px solid white; color: white; font-weight: 600; padding: 10px 24px; border-radius: 50px; transition: 0.3s; background: transparent; }
    .btn-outline-light-custom:hover { background: white; color: #1e3a8a; transform: translateX(5px); } /* Efek geser kanan saat disentuh */

    .hero-stats h3 { font-weight: 800; margin-bottom: 0; }
    .hero-stats p { font-size: 0.85rem; opacity: 0.8; }

    /* ANIMASI 2: Laptop Melayang (Floating) */
    .floating-laptop {
        filter: drop-shadow(0 30px 40px rgba(0,0,0,0.4));
        max-width: 85%;
        animation: float-up-down 4s ease-in-out infinite;
    }

    @keyframes float-up-down {
        0% { transform: translateY(0) rotate(-5deg); }
        50% { transform: translateY(-25px) rotate(-2deg); } /* Naik dan sedikit berputar */
        100% { transform: translateY(0) rotate(-5deg); }
    }

    /* ANIMASI 3: Teks Berjalan (Marquee) */
    .marquee-wrapper {
        position: absolute;
        bottom: -25px;
        left: 0;
        width: 100%;
        background: var(--accent-yellow);
        color: #000;
        padding: 12px 0;
        transform: rotate(-1.5deg); /* Dimiringkan agar estetik */
        z-index: 10;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .marquee-content {
        display: flex;
        white-space: nowrap;
        animation: move-left 20s linear infinite;
        font-weight: 800;
        font-size: 1.1rem;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .marquee-content span {
        margin: 0 30px;
    }

    @keyframes move-left {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    /* ANIMASI 4: Interaksi Kartu Produk (Hover Lift) */
    .product-card {
        border: 1px solid #f1f5f9; border-radius: 16px; padding: 1.5rem;
        background: white; height: 100%; display: flex; flex-direction: column;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Transisi memantul */
        position: relative;
        top: 0;
    }
    .product-card:hover { 
        box-shadow: 0 20px 40px rgba(30, 58, 138, 0.08); 
        top: -10px; /* Kartu terangkat */
        border-color: rgba(30, 58, 138, 0.2);
    }
    
    .img-wrapper { background: var(--bg-light); border-radius: 12px; padding: 1rem; text-align: center; margin-bottom: 1.5rem; transition: transform 0.4s ease; }
    .product-card:hover .img-wrapper { transform: scale(1.05); } /* Gambar membesar saat kartu disentuh */
    
    .badge-custom { position: absolute; top: 10px; right: 10px; font-size: 0.7rem; font-weight: 800; padding: 6px 12px; border-radius: 20px; z-index: 2; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .badge-yellow { background: var(--accent-yellow); color: #000; }
    .badge-red { background: #ef4444; color: white; }
    .badge-green { background: #22c55e; color: white; }

    .stars { color: var(--accent-yellow); font-size: 0.8rem; margin-bottom: 0.5rem; }
    .product-specs { font-size: 0.85rem; color: var(--text-gray); line-height: 1.6; margin-bottom: 1rem; }
    
    .price-row { display: flex; justify-content: space-between; align-items: center; margin-top: auto; }
    .price-text { font-weight: 800; font-size: 1.2rem; color: var(--primary-blue); }
    .btn-add { background: var(--primary-blue); color: white; border: none; border-radius: 50px; padding: 8px 20px; font-size: 0.85rem; font-weight: 600; transition: all 0.3s ease; }
    .btn-add:hover { background: var(--accent-yellow); color: #000; transform: translateY(-2px); }

    /* Features Section Hover */
    .feature-box { text-align: center; padding: 2rem; transition: transform 0.3s ease; }
    .feature-box:hover { transform: translateY(-5px); }
    .feature-icon { width: 60px; height: 60px; background: var(--accent-yellow); color: #000; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.2rem; transition: transform 0.5s ease;}
    .feature-box:hover .feature-icon { transform: rotateY(180deg); } /* Ikon berputar 3D */
</style>

<section class="hero-section mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="badge border border-warning text-warning rounded-pill px-3 py-2 mb-4" style="letter-spacing: 1px;">⚡ NEW COLLECTION 2026</span>
                <h1 class="display-4 fw-bolder mb-4">Best Laptops for<br>Your Needs</h1>
                <p class="lead mb-5 opacity-75 fs-6" style="max-width: 450px;">Discover premium laptops designed for work, gaming, and creativity. Find your perfect match from top brands.</p>
                
                <div class="d-flex gap-3 mb-5 align-items-center">
                    <button class="btn-yellow">Shop Now <i class="fa-solid fa-arrow-right ms-1"></i></button>
                    <button class="btn-outline-light-custom">Learn More</button>
                </div>

                <div class="d-flex gap-5 hero-stats">
                    <div><h3>500+</h3><p>Laptop Models</p></div>
                    <div><h3>50K+</h3><p>Happy Customers</p></div>
                    <div><h3>4.9</h3><p>User Rating</p></div>
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block position-relative">
                <img src="https://www.freeiconspng.com/thumbs/laptop-png/laptop-png-image-8.png" class="img-fluid floating-laptop">
            </div>
        </div>
    </div>

    <div class="marquee-wrapper">
        <div class="marquee-content">
            <span>🔥 FREE SHIPPING ON ORDERS OVER $500</span>
            <span>•</span>
            <span>🎮 LATEST NVIDIA RTX 40 SERIES AVAILABLE</span>
            <span>•</span>
            <span>🛡️ 2-YEAR EXTENDED WARRANTY</span>
            <span>•</span>
            <span>🚀 POWERED BY INTEL CORE ULTRA</span>
            <span>•</span>
            <span>🔥 FREE SHIPPING ON ORDERS OVER $500</span>
            <span>•</span>
            <span>🎮 LATEST NVIDIA RTX 40 SERIES AVAILABLE</span>
            <span>•</span>
            <span>🛡️ 2-YEAR EXTENDED WARRANTY</span>
            <span>•</span>
            <span>🚀 POWERED BY INTEL CORE ULTRA</span>
        </div>
    </div>
</section>

<div class="container mt-5 pt-4">
    <div class="text-center mb-5">
        <h2 class="fw-bolder" style="color: var(--text-dark);">Featured Laptops</h2>
        <p class="text-muted">Handpicked selection of our best-selling and most popular laptops</p>
    </div>

    <div class="row g-4 mb-5 pb-4">
        @forelse($products as $product)
        <div class="col-md-6 col-lg-3">
            <div class="product-card">
                <div class="img-wrapper">
                    @if($loop->iteration % 3 == 1)
                        <span class="badge-custom badge-yellow">BEST SELLER</span>
                    @elseif($loop->iteration % 3 == 2)
                        <span class="badge-custom badge-red">-15% OFF</span>
                    @else
                        <span class="badge-custom badge-green">NEW</span>
                    @endif

                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" style="height: 140px; object-fit: contain;">
                    @else
                        <i class="fa-solid fa-laptop fa-4x text-secondary opacity-25 my-4"></i>
                    @endif
                </div>

                <h6 class="fw-bold mb-1 text-truncate">{{ $product->name }}</h6>
                <div class="stars">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                </div>
                <p class="product-specs text-truncate-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ $product->description }}
                </p>

                <div class="price-row mt-3 pt-3 border-top border-light-subtle">
                    <span class="price-text">Rp{{ number_format($product->price/1000000, 1, ',', '.') }}M</span>
                    <a href="{{ route('product.detail', $product->slug) }}" class="btn-add text-decoration-none">View Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fa-solid fa-box-open fa-3x text-muted mb-3 opacity-50"></i>
            <p class="text-muted fw-medium">No products found in the catalog.</p>
        </div>
        @endforelse
    </div>

    <div class="row mb-5 pb-4 bg-white shadow-sm rounded-4 p-4 border" style="border-color: #f1f5f9 !important;">
        <div class="col-md-4">
            <div class="feature-box">
                <div class="feature-icon"><i class="fa-solid fa-truck-fast"></i></div>
                <h5 class="fw-bold">Free Shipping</h5>
                <p class="text-muted mb-0">On all orders over $500. Fast delivery.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box border-start border-end border-light-subtle">
                <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <h5 class="fw-bold">2-Year Warranty</h5>
                <p class="text-muted mb-0">Extended warranty with 24/7 support.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <div class="feature-icon"><i class="fa-solid fa-arrow-rotate-left"></i></div>
                <h5 class="fw-bold">30-Day Returns</h5>
                <p class="text-muted mb-0">Not satisfied? Return for a full refund.</p>
            </div>
        </div>
    </div>
</div>
@endsection