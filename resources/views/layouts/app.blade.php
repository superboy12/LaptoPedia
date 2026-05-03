<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LaptoPedia — Premium Laptops</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --black:        #000000;
            --off-black:    #0a0a0a;
            --deep:         #111111;
            --surface:      #1a1a1a;
            --surface-2:    #242424;
            --border:       rgba(255,255,255,0.08);
            --border-hover: rgba(255,255,255,0.18);
            --white:        #ffffff;
            --off-white:    #f5f5f7;
            --muted:        rgba(255,255,255,0.45);
            --gold:         #d4a843;
            --gold-light:   #e8c06a;
            --gold-dim:     rgba(212,168,67,0.12);
            --transition:   cubic-bezier(0.4,0,0.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--black);
            color: var(--white);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        h1,h2,h3,h4,h5,h6 { font-family: 'Manrope', sans-serif; letter-spacing: -0.03em; }
        a { text-decoration: none; color: inherit; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--black); }
        ::-webkit-scrollbar-thumb { background: var(--surface-2); border-radius: 3px; }

        /* ===== NAVBAR ===== */
        .nav-wrap {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            height: 52px;
            padding: 0 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(0,0,0,0.75);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .nav-brand {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1.15rem;
            letter-spacing: -0.04em;
            color: var(--white);
        }
        .nav-brand em { font-style: normal; color: var(--gold); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }
        .nav-links a {
            font-size: 0.82rem;
            font-weight: 400;
            color: rgba(255,255,255,0.75);
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--white); }

        .nav-actions { display: flex; align-items: center; gap: 18px; }

        .nav-search-box {
            display: flex;
            align-items: center;
            gap: 7px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 8px;
            padding: 6px 12px;
        }
        .nav-search-box i { color: var(--muted); font-size: 0.82rem; }
        .nav-search-box input {
            background: none;
            border: none;
            outline: none;
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            width: 150px;
        }
        .nav-search-box input::placeholder { color: rgba(255,255,255,0.3); }

        .nav-icon {
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255,255,255,0.75);
            font-size: 1.05rem;
            position: relative;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }
        .nav-icon:hover { color: var(--white); }

        .cart-dot {
            position: absolute;
            top: -6px; right: -6px;
            background: var(--gold);
            color: #000;
            font-size: 0.6rem;
            font-weight: 800;
            min-width: 15px;
            height: 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 3px;
        }

        /* ===== SECTION COMMONS ===== */
        .section-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--gold);
            display: block;
            margin-bottom: 10px;
        }
        .section-h2 {
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.04em;
            line-height: 1.1;
            margin-bottom: 8px;
        }
        .section-desc {
            font-size: 0.9rem;
            color: var(--muted);
            font-weight: 300;
            line-height: 1.65;
        }

        /* ===== FEATURES STRIP ===== */
        .features-strip {
            background: var(--deep);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 0 48px;
        }
        .features-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3,1fr);
        }
        .feat-item {
            padding: 48px 40px;
            text-align: center;
            border-right: 1px solid var(--border);
            transition: background 0.3s;
        }
        .feat-item:last-child { border-right: none; }
        .feat-item:hover { background: rgba(255,255,255,0.02); }
        .feat-icon { font-size: 1.7rem; color: var(--gold); margin-bottom: 12px; display: block; }
        .feat-title {
            font-family: 'Manrope', sans-serif;
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 6px;
            letter-spacing: -0.02em;
        }
        .feat-desc { font-size: 0.78rem; color: var(--muted); line-height: 1.6; font-weight: 300; }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--off-black);
            padding: 70px 48px 0;
            border-top: 1px solid var(--border);
        }
        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 56px;
            padding-bottom: 56px;
        }
        .footer-logo {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: -0.03em;
            color: var(--white);
            margin-bottom: 10px;
        }
        .footer-logo em { font-style: normal; color: var(--gold); }
        .footer-tagline {
            font-size: 0.8rem;
            color: var(--muted);
            line-height: 1.65;
            font-weight: 300;
            margin-bottom: 22px;
            max-width: 230px;
        }
        .footer-socials { display: flex; gap: 10px; }
        .footer-socials a {
            width: 32px; height: 32px;
            border-radius: 7px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 0.82rem;
            transition: border-color 0.2s, color 0.2s, background 0.2s;
        }
        .footer-socials a:hover {
            border-color: rgba(212,168,67,0.4);
            color: var(--gold);
            background: var(--gold-dim);
        }
        .footer-col-head {
            font-family: 'Manrope', sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            margin-bottom: 16px;
        }
        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .footer-col a {
            font-size: 0.83rem;
            color: rgba(255,255,255,0.5);
            transition: color 0.2s;
            font-weight: 300;
        }
        .footer-col a:hover { color: var(--white); }
        .footer-bottom {
            max-width: 1280px;
            margin: 0 auto;
            border-top: 1px solid var(--border);
            padding: 20px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .footer-copy { font-size: 0.75rem; color: rgba(255,255,255,0.22); }
        .footer-legal { display: flex; gap: 22px; }
        .footer-legal a { font-size: 0.75rem; color: rgba(255,255,255,0.22); transition: color 0.2s; }
        .footer-legal a:hover { color: rgba(255,255,255,0.5); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .nav-wrap { padding: 0 24px; }
            .nav-links { display: none; }
            .features-inner { grid-template-columns: 1fr; }
            .feat-item { border-right: none; border-bottom: 1px solid var(--border); }
            .feat-item:last-child { border-bottom: none; }
            .footer { padding: 48px 24px 0; }
            .footer-inner { grid-template-columns: 1fr 1fr; gap: 36px; }
            .footer-bottom { flex-direction: column; gap: 10px; }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="nav-wrap">
    <a href="{{ url('/') }}" class="nav-brand">Lapto<em>Pedia</em></a>

    <ul class="nav-links">
        <li><a href="{{ url('/') }}">Laptops</a></li>
        <li><a href="#">Brands</a></li>
        <li><a href="#">Deals</a></li>
        <li><a href="#">Support</a></li>
    </ul>

    <div class="nav-actions">
    <div class="nav-search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Find laptops...">
    </div>

    {{-- Keranjang — link ke halaman cart --}}
    <a href="{{ url('/cart-demo') }}" class="nav-icon">
    <i class="bi bi-bag"></i>
    <span class="cart-dot" id="cartCount">0</span>
</a>

    {{-- User menu: tampil berbeda tergantung status login --}}
    @auth
        {{-- Sudah login: tampilkan nama + dropdown logout --}}
        <div style="position:relative;" id="userMenuWrap">
            <button class="nav-icon" onclick="toggleUserMenu()" style="display:flex;align-items:center;gap:6px;font-family:'DM Sans',sans-serif;font-size:0.82rem;color:rgba(255,255,255,0.75);">
                <i class="bi bi-person-circle" style="font-size:1.1rem;"></i>
                <span style="max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    {{ Str::before(Auth::user()->nama_lengkap, ' ') }}
                </span>
                <i class="bi bi-chevron-down" style="font-size:0.65rem;"></i>
            </button>

            {{-- Dropdown --}}
            <div id="userDropdown" style="
                display:none;
                position:absolute;
                top:calc(100% + 10px);
                right:0;
                background:#1a1a1a;
                border:1px solid rgba(255,255,255,0.1);
                border-radius:10px;
                min-width:190px;
                padding:6px;
                z-index:9999;
                box-shadow:0 16px 40px rgba(0,0,0,0.6);
            ">
                <div style="padding:10px 12px 8px;border-bottom:1px solid rgba(255,255,255,0.07);margin-bottom:4px;">
                    <p style="font-size:0.8rem;font-weight:600;color:#fff;">{{ Auth::user()->nama_lengkap }}</p>
                    <p style="font-size:0.72rem;color:rgba(255,255,255,0.4);margin-top:2px;">{{ Auth::user()->email }}</p>
                    <span style="
                        display:inline-block;margin-top:5px;
                        font-size:0.65rem;font-weight:700;
                        text-transform:uppercase;letter-spacing:0.08em;
                        background:rgba(212,168,67,0.15);color:#d4a843;
                        padding:2px 7px;border-radius:4px;
                    ">{{ Auth::user()->role }}</span>
                </div>

                <a href="#" style="display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:7px;font-size:0.82rem;color:rgba(255,255,255,0.65);transition:background 0.2s,color 0.2s;"
                   onmouseover="this.style.background='rgba(255,255,255,0.06)';this.style.color='#fff'"
                   onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.65)'">
                    <i class="bi bi-person"></i> Profil Saya
                </a>

                {{-- Link ke Keranjang --}}
                <a href="{{ route('cart.index') }}" style="display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:7px;font-size:0.82rem;color:rgba(255,255,255,0.65);transition:background 0.2s,color 0.2s;"
                   onmouseover="this.style.background='rgba(255,255,255,0.06)';this.style.color='#fff'"
                   onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.65)'">
                    <i class="bi bi-cart3"></i> Keranjang Saya
                    @if(collect(session('cart', []))->sum('quantity') > 0)
                    <span style="margin-left:auto;background:var(--gold);color:#000;font-size:0.62rem;font-weight:800;padding:1px 6px;border-radius:4px;">
                        {{ collect(session('cart', []))->sum('quantity') }}
                    </span>
                    @endif
                </a>

                <a href="#" style="display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:7px;font-size:0.82rem;color:rgba(255,255,255,0.65);transition:background 0.2s,color 0.2s;"
                   onmouseover="this.style.background='rgba(255,255,255,0.06)';this.style.color='#fff'"
                   onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.65)'">
                    <i class="bi bi-bag"></i> Pesanan Saya
                </a>

                <div style="height:1px;background:rgba(255,255,255,0.07);margin:4px 0;"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="
                        display:flex;align-items:center;gap:9px;
                        width:100%;padding:9px 12px;border-radius:7px;
                        font-size:0.82rem;color:#f87171;
                        background:none;border:none;cursor:pointer;
                        font-family:'DM Sans',sans-serif;
                        transition:background 0.2s;
                    "
                    onmouseover="this.style.background='rgba(248,113,113,0.1)'"
                    onmouseout="this.style.background='transparent'">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

    @else
        {{-- Belum login: tampilkan ikon person biasa --}}
        <a href="{{ route('login') }}" class="nav-icon" title="Login">
            <i class="bi bi-person"></i>
        </a>
    @endauth
</div>
</nav>

<!-- PAGE CONTENT -->
@yield('content')

<!-- FEATURES STRIP -->
<div class="features-strip">
    <div class="features-inner">
        <div class="feat-item">
            <i class="bi bi-box-seam feat-icon"></i>
            <div class="feat-title">Free Shipping</div>
            <p class="feat-desc">On all orders over Rp 3.000.000. Fast and reliable delivery nationwide.</p>
        </div>
        <div class="feat-item">
            <i class="bi bi-shield-check feat-icon"></i>
            <div class="feat-title">2-Year Warranty</div>
            <p class="feat-desc">Extended warranty on all laptops with 24/7 customer support.</p>
        </div>
        <div class="feat-item">
            <i class="bi bi-arrow-repeat feat-icon"></i>
            <div class="feat-title">30-Day Returns</div>
            <p class="feat-desc">Not satisfied? Return within 30 days for a full refund.</p>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-inner">
        <div>
            <div class="footer-logo">Lapto<em>Pedia</em></div>
            <p class="footer-tagline">Your trusted destination for premium laptops and honest expert advice.</p>
            <div class="footer-socials">
                <a href="#"><i class="bi bi-twitter-x"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-youtube"></i></a>
            </div>
        </div>
        <div class="footer-col">
            <div class="footer-col-head">Shop</div>
            <ul>
                <li><a href="#">All Laptops</a></li>
                <li><a href="#">Gaming</a></li>
                <li><a href="#">Business</a></li>
                <li><a href="#">Student</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <div class="footer-col-head">Support</div>
            <ul>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">FAQs</a></li>
                <li><a href="#">Warranty</a></li>
                <li><a href="#">Returns</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <div class="footer-col-head">Company</div>
            <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <span class="footer-copy">&copy; {{ date('Y') }} LaptoPedia. All rights reserved.</span>
        <div class="footer-legal">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Cookies</a>
        </div>
    </div>
</footer>

@stack('scripts')
<script>
function toggleUserMenu() {
    const d = document.getElementById('userDropdown');
    d.style.display = d.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    const wrap = document.getElementById('userMenuWrap');
    if (wrap && !wrap.contains(e.target)) {
        const d = document.getElementById('userDropdown');
        if (d) d.style.display = 'none';
    }
});
</script>

<!-- ===== CART DEMO FUNCTIONS ===== -->
<style>
    .cart-toast {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 50px;
        padding: 12px 24px;
        z-index: 9999;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    .cart-toast.show {
        transform: translateX(-50%) translateY(0);
    }
    .cart-toast-inner {
        display: flex;
        align-items: center;
        gap: 10px;
        color: white;
    }
    .bi-check-circle-fill { color: #10b981; }
    .bi-x-circle-fill { color: #ef4444; }
    
    .btn-cart.loading {
        opacity: 0.7;
        cursor: wait;
    }
    .btn-cart.added {
        background: #10b981;
        color: white;
        border-color: #10b981;
    }
</style>

<script>
// Fungsi untuk update badge cart
function updateCartCount(count) {
    const badge = document.getElementById('cartCount');
    if (badge) {
        badge.textContent = count;
        badge.style.transform = 'scale(1.2)';
        setTimeout(() => badge.style.transform = '', 200);
    }
}

// Fungsi untuk show toast notifikasi
function showToast(message, isSuccess = true) {
    let toast = document.getElementById('cartToast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'cartToast';
        toast.className = 'cart-toast';
        toast.innerHTML = `
            <div class="cart-toast-inner">
                <i class="bi ${isSuccess ? 'bi-check-circle-fill' : 'bi-x-circle-fill'}"></i>
                <span id="toastMessage"></span>
            </div>
        `;
        document.body.appendChild(toast);
    }
    
    const toastMsg = document.getElementById('toastMessage');
    const toastIcon = toast.querySelector('i');
    
    toastIcon.className = `bi ${isSuccess ? 'bi-check-circle-fill' : 'bi-x-circle-fill'}`;
    toastMsg.textContent = message;
    
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, 2500);
}

    // Ambil data produk dari card
    const card = btn.closest('.p-card');
    const productName = card?.querySelector('.p-name')?.textContent?.trim() ?? 'Product';
    
    // Simpan HTML asli button
    const originalHTML = btn.innerHTML;
    
    // Loading state
    btn.disabled = true;
    btn.classList.add('loading');
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Adding...';
    
    // Simulasi proses (biar keliatan animasinya)
    setTimeout(() => {
        // Ambil cart dari localStorage
        let cart = JSON.parse(localStorage.getItem('demo_cart') || '[]');
        
        // Cek apakah produk sudah ada di cart
        const existingIndex = cart.findIndex(item => item.name === productName);
        
        if (existingIndex !== -1) {
            cart[existingIndex].quantity += 1;
        } else {
            cart.push({
                name: productName,
                quantity: 1,
                addedAt: new Date().toISOString()
            });
        }
        
        // Simpan ke localStorage
        localStorage.setItem('demo_cart', JSON.stringify(cart));
        
        // Hitung total item
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        
        // Update badge di navbar
        updateCartCount(totalItems);
        
        // Tampilkan notifikasi
        showToast(`${productName} added to cart!`, true);
        
        // Reset button
        setTimeout(() => {
            btn.disabled = false;
            btn.classList.remove('loading');
            btn.innerHTML = originalHTML;
        }, 800);
        
    }, 400);
}

// Load cart count saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const cart = JSON.parse(localStorage.getItem('demo_cart') || '[]');
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    updateCartCount(totalItems);
});
</script>
</body>
</html>
