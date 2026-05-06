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
        /* ── DARK MODE (default) ── */
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
            /* semantic */
            --bg:           #000000;
            --bg-2:         #0a0a0a;
            --text:         #ffffff;
            --text-muted:   rgba(255,255,255,0.50);
            --nav-bg:       rgba(0,0,0,0.75);
            --nav-border:   rgba(255,255,255,0.06);
            --search-bg:    rgba(255,255,255,0.06);
            --search-border:rgba(255,255,255,0.09);
        }

        /* ── LIGHT MODE ── */
        [data-theme="light"] {
            --black:        #f5f5f8;
            --off-black:    #ffffff;
            --deep:         #eeeef1;
            --surface:      #ffffff;
            --surface-2:    #f2f2f5;
            --border:       rgba(0,0,0,0.10);
            --border-hover: rgba(0,0,0,0.22);
            --white:        #1a1a2e;
            --off-white:    #2d2d44;
            --muted:        #6b6b80;
            --gold:         #a67c00;
            --gold-light:   #c49b17;
            --gold-dim:     rgba(166,124,0,0.08);
            --bg:           #f5f5f8;
            --bg-2:         #ffffff;
            --text:         #1a1a2e;
            --text-muted:   #6b6b80;
            --nav-bg:       rgba(255,255,255,0.92);
            --nav-border:   rgba(0,0,0,0.08);
            --search-bg:    rgba(0,0,0,0.04);
            --search-border:rgba(0,0,0,0.10);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
            transition: background 0.4s ease, color 0.4s ease;
        }

        h1,h2,h3,h4,h5,h6 { font-family: 'Manrope', sans-serif; letter-spacing: -0.03em; }
        a { text-decoration: none; color: inherit; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
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
            background: var(--nav-bg);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid var(--nav-border);
            transition: background 0.4s ease, border-color 0.4s ease;
        }

        .nav-brand {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1.15rem;
            letter-spacing: -0.04em;
            color: var(--text);
            transition: color 0.4s ease;
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
            color: var(--text-muted);
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--text); }

        .nav-actions { display: flex; align-items: center; gap: 18px; }

        .nav-search-box {
            display: flex;
            align-items: center;
            gap: 7px;
            background: var(--search-bg);
            border: 1px solid var(--search-border);
            border-radius: 8px;
            padding: 6px 12px;
            transition: background 0.4s ease, border-color 0.4s ease;
        }
        .nav-search-box i { color: var(--text-muted); font-size: 0.82rem; }
        .nav-search-box input {
            background: none;
            border: none;
            outline: none;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            width: 150px;
        }
        .nav-search-box input::placeholder { color: var(--text-muted); }

        .nav-icon {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 1.05rem;
            position: relative;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }
        .nav-icon:hover { color: var(--text); }

        /* Theme Toggle Button */
        .theme-toggle {
            background: var(--search-bg);
            border: 1px solid var(--search-border);
            color: var(--text-muted);
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 0.9rem;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }
        .theme-toggle:hover { color: var(--gold); border-color: var(--gold); }

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
            color: var(--text);
            letter-spacing: -0.04em;
            line-height: 1.1;
            margin-bottom: 8px;
            transition: color 0.4s ease;
        }
        .section-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 300;
            line-height: 1.65;
            transition: color 0.4s ease;
        }

        /* ===== FEATURES STRIP ===== */
        .features-strip {
            background: var(--bg-2);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 0 48px;
            transition: background 0.4s ease;
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
        .feat-item:hover { background: var(--search-bg); }
        .feat-icon { font-size: 1.7rem; color: var(--gold); margin-bottom: 12px; display: block; }
        .feat-title {
            font-family: 'Manrope', sans-serif;
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
            letter-spacing: -0.02em;
            transition: color 0.4s ease;
        }
        .feat-desc { font-size: 0.78rem; color: var(--text-muted); line-height: 1.6; font-weight: 300; transition: color 0.4s ease; }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--bg-2);
            padding: 70px 48px 0;
            border-top: 1px solid var(--border);
            transition: background 0.4s ease;
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
            color: var(--text);
            margin-bottom: 10px;
            transition: color 0.4s ease;
        }
        .footer-logo em { font-style: normal; color: var(--gold); }
        .footer-tagline {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.65;
            font-weight: 300;
            margin-bottom: 22px;
            max-width: 230px;
            transition: color 0.4s ease;
        }
        .footer-socials { display: flex; gap: 10px; }
        .footer-socials a {
            width: 32px; height: 32px;
            border-radius: 7px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
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
            color: var(--text-muted);
            margin-bottom: 16px;
            transition: color 0.4s ease;
        }
        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .footer-col a {
            font-size: 0.83rem;
            color: var(--text-muted);
            transition: color 0.2s;
            font-weight: 300;
        }
        .footer-col a:hover { color: var(--text); }
        .footer-bottom {
            max-width: 1280px;
            margin: 0 auto;
            border-top: 1px solid var(--border);
            padding: 20px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .footer-copy { font-size: 0.75rem; color: var(--text-muted); }
        .footer-legal { display: flex; gap: 22px; }
        .footer-legal a { font-size: 0.75rem; color: var(--text-muted); transition: color 0.2s; }
        .footer-legal a:hover { color: var(--text); }

        /* ===== USER DROPDOWN ===== */
        .user-dd-link {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 12px; border-radius: 7px;
            font-size: 0.82rem; color: var(--text-muted);
            transition: background 0.2s, color 0.2s;
            background: none; border: none; cursor: pointer;
            font-family: 'DM Sans', sans-serif; width: 100%;
            text-align: left;
        }
        .user-dd-link:hover { background: var(--search-bg); color: var(--text); }
        .user-dd-logout { color: #f87171; }
        .user-dd-logout:hover { background: rgba(248,113,113,0.1); color: #f87171; }

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
            <button class="nav-icon" onclick="toggleUserMenu()" style="display:flex;align-items:center;gap:6px;font-family:'DM Sans',sans-serif;font-size:0.82rem;">
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
                background:var(--surface);
                border:1px solid var(--border);
                border-radius:10px;
                min-width:190px;
                padding:6px;
                z-index:9999;
                box-shadow:0 16px 40px rgba(0,0,0,0.25);
                transition:background 0.4s ease;
            ">
                <div style="padding:10px 12px 8px;border-bottom:1px solid var(--border);margin-bottom:4px;">
                    <p style="font-size:0.8rem;font-weight:600;color:var(--text);">{{ Auth::user()->nama_lengkap }}</p>
                    <p style="font-size:0.72rem;color:var(--text-muted);margin-top:2px;">{{ Auth::user()->email }}</p>
                    <span style="
                        display:inline-block;margin-top:5px;
                        font-size:0.65rem;font-weight:700;
                        text-transform:uppercase;letter-spacing:0.08em;
                        background:var(--gold-dim);color:var(--gold);
                        padding:2px 7px;border-radius:4px;
                    ">{{ Auth::user()->role }}</span>
                </div>

                <a href="{{ route('profile') }}" class="user-dd-link">
                    <i class="bi bi-person"></i> Profil Saya
                </a>

                {{-- Link ke Keranjang --}}
                <a href="{{ route('cart.index') }}" class="user-dd-link">
                    <i class="bi bi-cart3"></i> Keranjang Saya
                    @if(collect(session('cart', []))->sum('quantity') > 0)
                    <span style="margin-left:auto;background:var(--gold);color:#000;font-size:0.62rem;font-weight:800;padding:1px 6px;border-radius:4px;">
                        {{ collect(session('cart', []))->sum('quantity') }}
                    </span>
                    @endif
                </a>

                <a href="#" class="user-dd-link">
                    <i class="bi bi-bag"></i> Pesanan Saya
                </a>

                <div style="height:1px;background:var(--border);margin:4px 0;"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="user-dd-link user-dd-logout">
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

    {{-- Theme Toggle --}}
    <button class="theme-toggle" id="themeToggle" onclick="toggleTheme()" title="Ganti Tema">
        <i class="bi bi-sun-fill" id="themeIcon"></i>
    </button>
</div>
</nav>

<!-- PAGE CONTENT -->
@yield('content')

<!-- FEATURES STRIP -->
<div class="features-strip">
    <div class="features-inner">
        <div class="feat-item">
            <i class="bi bi-box-seam feat-icon"></i>
            <div class="feat-title">Gratis Ongkir</div>
            <p class="feat-desc">Untuk semua pesanan di atas Rp 3.000.000. Pengiriman cepat ke seluruh Indonesia.</p>
        </div>
        <div class="feat-item">
            <i class="bi bi-shield-check feat-icon"></i>
            <div class="feat-title">Garansi 2 Tahun</div>
            <p class="feat-desc">Garansi resmi untuk semua laptop dengan dukungan pelanggan 24/7.</p>
        </div>
        <div class="feat-item">
            <i class="bi bi-arrow-repeat feat-icon"></i>
            <div class="feat-title">30 Hari Pengembalian</div>
            <p class="feat-desc">Tidak puas? Kembalikan dalam 30 hari untuk pengembalian dana penuh.</p>
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




// Load cart count saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const cart = JSON.parse(localStorage.getItem('demo_cart') || '[]');
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    updateCartCount(totalItems);
});

/* ── Dark / Light Theme Toggle ── */
function toggleTheme() {
    const html = document.documentElement;
    const current = html.getAttribute('data-theme') || 'dark';
    const next = current === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('lp_theme', next);
    updateThemeIcon(next);
}
function updateThemeIcon(theme) {
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
}
// Apply saved theme immediately (before page renders)
(function() {
    const saved = localStorage.getItem('lp_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', saved);
    updateThemeIcon(saved);
})();
</script>

<!-- ═══════════════════════════════════════════════
     AI CUSTOMER SERVICE CHAT WIDGET - LaptoPedia
═══════════════════════════════════════════════ -->
<style>
.cs-fab {
    position: fixed;
    bottom: 28px; right: 28px;
    width: 58px; height: 58px;
    border-radius: 50%;
    background: linear-gradient(135deg, #d4a843, #b8870e);
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 8px 32px rgba(212,168,67,0.35);
    z-index: 9990;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    animation: cs-pulse 3s ease-in-out infinite;
}
.cs-fab:hover { transform: scale(1.08); box-shadow: 0 12px 40px rgba(212,168,67,0.5); }
.cs-fab i { font-size: 1.5rem; color: #000; transition: transform 0.3s ease; }
@keyframes cs-pulse {
    0%,100% { box-shadow: 0 8px 32px rgba(212,168,67,0.35); }
    50% { box-shadow: 0 8px 32px rgba(212,168,67,0.55), 0 0 0 8px rgba(212,168,67,0.08); }
}

.cs-window {
    position: fixed;
    bottom: 100px; right: 28px;
    width: 360px; max-height: 500px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    box-shadow: 0 24px 80px rgba(0,0,0,0.3);
    z-index: 9991;
    display: flex; flex-direction: column;
    overflow: hidden;
    opacity: 0; transform: translateY(20px) scale(0.95);
    pointer-events: none;
    transition: opacity 0.3s ease, transform 0.3s ease, background 0.4s ease;
}
.cs-window.visible {
    opacity: 1; transform: translateY(0) scale(1);
    pointer-events: all;
}

.cs-header {
    background: linear-gradient(135deg, #d4a843, #b8870e);
    padding: 16px 18px;
    display: flex; align-items: center; gap: 10px;
    flex-shrink: 0;
}
.cs-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(0,0,0,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; color: #000;
}
.cs-header-info h4 {
    font-family: 'Manrope', sans-serif; font-size: 0.88rem;
    font-weight: 800; color: #000;
}
.cs-header-info span {
    font-size: 0.68rem; color: rgba(0,0,0,0.55);
    display: flex; align-items: center; gap: 4px;
}
.cs-online-dot { width: 6px; height: 6px; border-radius: 50%; background: #065f46; display: inline-block; }
.cs-close {
    margin-left: auto; background: rgba(0,0,0,0.12);
    border: none; cursor: pointer; color: #000;
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem; transition: background 0.2s;
}
.cs-close:hover { background: rgba(0,0,0,0.25); }

.cs-messages {
    flex: 1; overflow-y: auto; padding: 16px;
    display: flex; flex-direction: column; gap: 10px;
    min-height: 260px;
}
.cs-msg {
    max-width: 85%; padding: 10px 14px;
    border-radius: 14px; font-size: 0.82rem; line-height: 1.55;
    word-wrap: break-word;
}
.cs-msg.bot { align-self: flex-start; background: var(--surface-2); color: var(--text); border-bottom-left-radius: 4px; }
.cs-msg.user { align-self: flex-end; background: linear-gradient(135deg, #d4a843, #b8870e); color: #000; font-weight: 600; border-bottom-right-radius: 4px; }
.cs-msg.typing { align-self: flex-start; background: var(--surface-2); color: var(--text-muted); font-style: italic; }

.cs-input-wrap {
    padding: 12px 14px;
    border-top: 1px solid var(--border);
    display: flex; align-items: center; gap: 8px;
    flex-shrink: 0; background: var(--surface);
    transition: background 0.4s ease;
}
.cs-input {
    flex: 1; background: var(--bg);
    border: 1px solid var(--border); color: var(--text);
    font-family: 'DM Sans', sans-serif; font-size: 0.82rem;
    padding: 9px 13px; border-radius: 100px; outline: none;
    transition: border-color 0.2s, background 0.4s ease, color 0.4s ease;
}
.cs-input:focus { border-color: var(--gold); }
.cs-input::placeholder { color: var(--text-muted); }
.cs-send {
    width: 34px; height: 34px; border-radius: 50%;
    background: linear-gradient(135deg, #d4a843, #b8870e);
    border: none; cursor: pointer; color: #000;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; transition: transform 0.2s, opacity 0.2s; flex-shrink: 0;
}
.cs-send:hover { transform: scale(1.08); }
.cs-send:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

@media (max-width: 480px) {
    .cs-window { width: calc(100vw - 20px); right: 10px; bottom: 88px; max-height: 68vh; }
    .cs-fab { bottom: 16px; right: 16px; }
}
</style>

<!-- FAB Button -->
<button class="cs-fab" id="csFab" onclick="toggleChat()" aria-label="Customer Service AI">
    <i class="bi bi-chat-dots-fill" id="csFabIcon"></i>
</button>

<!-- Chat Window -->
<div class="cs-window" id="csWindow">
    <div class="cs-header">
        <div class="cs-avatar"><i class="bi bi-robot"></i></div>
        <div class="cs-header-info">
            <h4>LaptoPedia AI</h4>
            <span><span class="cs-online-dot"></span> Asisten online</span>
        </div>
        <button class="cs-close" onclick="toggleChat()"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="cs-messages" id="csMessages">
        <div class="cs-msg bot">
            Halo! 👋 Saya asisten virtual <strong>LaptoPedia</strong>. Tanyakan soal laptop, spesifikasi, atau rekomendasi yang sesuai kebutuhan Anda!
        </div>
    </div>
    <div class="cs-input-wrap">
        <input type="text" class="cs-input" id="csInput" placeholder="Ketik pesan Anda..." autocomplete="off">
        <button class="cs-send" id="csSend" onclick="sendCsMessage()"><i class="bi bi-send-fill"></i></button>
    </div>
</div>

<script>
const GEMINI_KEY = 'AIzaSyDMOYwwumj2zXHXm1p0NJoLQzD8Va09ui0';
const GEMINI_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=${GEMINI_KEY}`;
let csHistory = [];
const SYSTEM_PROMPT = `Kamu adalah asisten CS LaptoPedia, toko laptop online Indonesia. Jawab singkat 2-3 kalimat dalam Bahasa Indonesia. Bantu soal laptop, rekomendasi, spesifikasi, pembelian, pengiriman, dan garansi. Ramah dan to the point.`;

function toggleChat() {
    const win = document.getElementById('csWindow');
    const icon = document.getElementById('csFabIcon');
    const isOpen = win.classList.contains('visible');
    win.classList.toggle('visible');
    icon.className = isOpen ? 'bi bi-chat-dots-fill' : 'bi bi-x-lg';
    if (!isOpen) setTimeout(() => document.getElementById('csInput').focus(), 300);
}

function addMsg(text, sender) {
    const box = document.getElementById('csMessages');
    const el = document.createElement('div');
    el.className = `cs-msg ${sender}`;
    el.innerHTML = text;
    box.appendChild(el);
    box.scrollTop = box.scrollHeight;
    return el;
}

async function sendCsMessage() {
    const input = document.getElementById('csInput');
    const btn = document.getElementById('csSend');
    const text = input.value.trim();
    if (!text) return;

    addMsg(text, 'user');
    input.value = '';
    btn.disabled = true;
    csHistory.push({ role: 'user', parts: [{ text }] });

    const typing = addMsg('⋯ Mengetik...', 'typing');

    try {
        const res = await fetch(GEMINI_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                system_instruction: { parts: [{ text: SYSTEM_PROMPT }] },
                contents: csHistory
            })
        });
        const data = await res.json();
        typing.remove();

        const reply = data?.candidates?.[0]?.content?.parts?.[0]?.text;
        if (reply) {
            const fmt = reply.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>').replace(/\n/g, '<br>');
            addMsg(fmt, 'bot');
            csHistory.push({ role: 'model', parts: [{ text: reply }] });
        } else {
            addMsg('Maaf, coba tanyakan lagi ya. 🙏', 'bot');
        }
    } catch(e) {
        typing.remove();
        addMsg('Koneksi bermasalah, coba lagi. 🔌', 'bot');
    }

    btn.disabled = false;
    input.focus();
}

document.addEventListener('DOMContentLoaded', () => {
    const inp = document.getElementById('csInput');
    if (inp) inp.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendCsMessage(); }
    });
});
</script>
</body>
</html>
