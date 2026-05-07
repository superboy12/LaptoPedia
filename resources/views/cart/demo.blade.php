@extends('layouts.app')

@push('styles')
<style>
    /* =============================================
       CART DEMO PAGE — Premium Minimalist Redesign
    ============================================= */
    .cart-page {
        min-height: 100vh;
        background: var(--bg);
        padding-top: 52px;
        transition: background 0.4s ease;
    }

    /* ---- Page Header — Cinematic Banner ---- */
    .cart-header {
        background: var(--bg-2);
        border-bottom: 1px solid var(--border);
        padding: 72px 48px 52px;
        position: relative;
        overflow: hidden;
        transition: background 0.4s ease;
    }
    .cart-header::before {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(212,168,67,0.04) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
    }

    .cart-header .orb-blue {
        position: absolute;
        width: 600px; height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(0,113,227,0.10) 0%, transparent 65%);
        top: -300px; right: -80px;
        filter: blur(90px);
        pointer-events: none;
        animation: drift-orb 8s ease-in-out infinite alternate;
    }
    .cart-header .orb-gold {
        position: absolute;
        width: 340px; height: 340px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(212,168,67,0.08) 0%, transparent 65%);
        bottom: -160px; left: -60px;
        filter: blur(70px);
        pointer-events: none;
        animation: drift-orb 10s ease-in-out infinite alternate-reverse;
    }
    @keyframes drift-orb {
        from { transform: translate(0, 0) scale(1); }
        to   { transform: translate(30px, -20px) scale(1.06); }
    }

    .cart-header-inner {
        max-width: 1280px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    .cart-header h1 {
        font-family: 'Manrope', sans-serif;
        font-size: clamp(2.2rem, 4.5vw, 3.6rem);
        font-weight: 900;
        letter-spacing: -0.05em;
        color: var(--text);
        line-height: 1;
        margin-bottom: 12px;
        transition: color 0.4s ease;
    }
    .cart-header h1 .gradient-word {
        background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .cart-header p {
        font-size: 0.92rem;
        color: var(--text-muted);
        font-weight: 300;
        line-height: 1.6;
        max-width: 420px;
        transition: color 0.4s ease;
    }

    .cart-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--gold-dim);
        border: 1px solid rgba(212,168,67,0.25);
        color: var(--gold);
        font-family: 'Manrope', sans-serif;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        padding: 5px 14px;
        border-radius: 100px;
        margin-top: 18px;
    }

    /* ---- Main Layout ---- */
    .cart-body {
        max-width: 1280px;
        margin: 0 auto;
        padding: 48px 48px 96px;
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 40px;
        align-items: start;
    }

    /* ---- Cart Items Column ---- */
    .cart-items-col { display: flex; flex-direction: column; gap: 0; }

    .cart-items-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .cart-items-title {
        font-family: 'Manrope', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-muted);
    }

    .btn-clear-all {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: none;
        border: 1px solid rgba(248,113,113,0.2);
        color: #f87171;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 100px;
        cursor: pointer;
        transition: background 0.2s, border-color 0.2s;
    }
    .btn-clear-all:hover {
        background: rgba(248,113,113,0.08);
        border-color: rgba(248,113,113,0.4);
    }

    /* Cart Item Card — Premium Glassmorphic */
    .cart-item {
        background: var(--surface);
        border-radius: 20px;
        display: grid;
        grid-template-columns: 140px 1fr auto;
        gap: 32px;
        align-items: center;
        padding: 24px 32px;
        margin-bottom: 20px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.02);
        transition: box-shadow 0.4s ease, transform 0.4s ease;
    }
    .cart-item:hover {
        box-shadow: 0 12px 48px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }

    .cart-item-img {
        background: var(--surface-2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 120px;
        overflow: hidden;
        transition: background 0.4s ease;
        padding: 10px;
    }
    .cart-item-img img {
        max-height: 90px;
        max-width: 100%;
        object-fit: contain;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .cart-item:hover .cart-item-img img {
        transform: scale(1.1) translateY(-3px);
    }

    .cart-item-info { display: flex; flex-direction: column; gap: 4px; }

    .cart-item-name {
        font-family: 'Manrope', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text);
        letter-spacing: -0.02em;
        transition: color 0.4s ease;
    }

    .cart-item-unit-price {
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 400;
        margin-top: 2px;
    }

    .cart-item-subtotal {
        font-family: 'Manrope', sans-serif;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.03em;
        margin-top: 10px;
        transition: color 0.4s ease;
    }

    /* Quantity stepper */
    .qty-stepper {
        display: inline-flex;
        align-items: center;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 100px;
        overflow: hidden;
        margin-top: 12px;
    }
    .qty-btn {
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 0.9rem;
        padding: 6px 14px;
        cursor: pointer;
        transition: color 0.2s, background 0.2s;
        font-family: 'Manrope', sans-serif;
        font-weight: 600;
        line-height: 1;
    }
    .qty-btn:hover {
        color: var(--text);
        background: var(--search-bg);
    }
    .qty-val {
        font-family: 'Manrope', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text);
        min-width: 28px;
        text-align: center;
    }

    /* Right side: remove button */
    .cart-item-actions { display: flex; flex-direction: column; align-items: flex-end; gap: 12px; }

    .btn-remove {
        background: none;
        border: 1px solid var(--border);
        color: var(--text-muted);
        font-size: 0.95rem;
        width: 36px; height: 36px;
        border-radius: 10px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: border-color 0.2s, color 0.2s, background 0.2s;
    }
    .btn-remove:hover {
        border-color: rgba(248,113,113,0.4);
        color: #f87171;
        background: rgba(248,113,113,0.07);
    }

    /* ---- Order Summary Column ---- */
    .cart-summary {
        background: var(--surface);
        border-radius: 20px;
        padding: 36px;
        position: sticky;
        top: 80px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.03);
        transition: box-shadow 0.4s ease;
    }

    .summary-title {
        font-family: 'Manrope', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 24px;
    }

    .summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.88rem;
        color: var(--text-muted);
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
    }
    .summary-row:last-of-type { border-bottom: none; }
    .summary-row span:last-child { color: var(--text); font-weight: 600; }

    .summary-divider {
        height: 1px;
        background: var(--border);
        margin: 20px 0;
    }

    .summary-total-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 4px 0 24px;
    }
    .summary-total-label {
        font-family: 'Manrope', sans-serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text);
    }
    .summary-total-price {
        font-family: 'Manrope', sans-serif;
        font-size: 1.6rem;
        font-weight: 900;
        color: var(--text);
        letter-spacing: -0.04em;
    }

    /* Promo input */
    .promo-wrap {
        display: flex;
        gap: 10px;
        margin-bottom: 24px;
    }
    .promo-input {
        flex: 1;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.85rem;
        padding: 12px 16px;
        outline: none;
        transition: border-color 0.3s ease, background 0.3s ease;
    }
    .promo-input::placeholder { color: var(--text-muted); }
    .promo-input:focus { border-color: var(--gold); background: var(--surface); }
    .btn-apply-promo {
        background: var(--gold-dim);
        border: 1px solid rgba(212,168,67,0.3);
        color: var(--gold);
        font-family: 'Manrope', sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
        padding: 12px 20px;
        border-radius: 12px;
        cursor: pointer;
        transition: background 0.3s ease, border-color 0.3s ease, transform 0.2s ease;
        white-space: nowrap;
    }
    .btn-apply-promo:hover {
        background: rgba(212,168,67,0.15);
        border-color: var(--gold);
        transform: translateY(-1px);
    }

    /* Checkout button */
    .btn-checkout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: linear-gradient(135deg, #d4a843, #b8870e);
        color: #000;
        font-family: 'Manrope', sans-serif;
        font-weight: 800;
        font-size: 0.9rem;
        padding: 15px 28px;
        border-radius: 100px;
        border: none;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        letter-spacing: -0.01em;
    }
    .btn-checkout:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 24px rgba(212,168,67,0.3);
    }
    .btn-checkout:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-continue {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        background: transparent;
        color: var(--text-muted);
        font-family: 'Manrope', sans-serif;
        font-weight: 600;
        font-size: 0.82rem;
        padding: 12px 20px;
        border-radius: 100px;
        border: 1px solid var(--border);
        cursor: pointer;
        margin-top: 12px;
        transition: border-color 0.2s, color 0.2s, background 0.2s;
        text-decoration: none;
    }
    .btn-continue:hover {
        border-color: var(--border-hover);
        color: var(--text);
        background: var(--search-bg);
    }

    /* Guarantee strip */
    .guarantee-strip {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .guarantee-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.77rem;
        color: var(--text-muted);
    }
    .guarantee-item i { color: var(--gold); font-size: 0.95rem; }

    /* ---- Empty State ---- */
    .cart-empty {
        text-align: center;
        padding: 100px 24px;
        background: var(--surface);
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.02);
    }
    .cart-empty-icon {
        font-size: 4rem;
        color: var(--text-muted);
        margin-bottom: 24px;
        opacity: 0.2;
    }
    .cart-empty h3 {
        font-family: 'Manrope', sans-serif;
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.03em;
        margin-bottom: 10px;
    }
    .cart-empty p {
        font-size: 0.9rem;
        color: var(--text-muted);
        font-weight: 300;
        margin-bottom: 32px;
        line-height: 1.65;
    }
    .btn-white {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #d4a843, #b8870e);
        color: #000;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 0.87rem;
        padding: 14px 28px;
        border-radius: 100px;
        border: none;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        letter-spacing: -0.01em;
        text-decoration: none;
    }
    .btn-white:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 24px rgba(212,168,67,0.3);
        color: #000;
    }

    /* ---- Responsive ---- */
    @media (max-width: 1060px) {
        .cart-body { grid-template-columns: 1fr; }
        .cart-summary { position: static; }
    }
    @media (max-width: 640px) {
        .cart-header { padding: 48px 24px 36px; }
        .cart-body { padding: 28px 16px 72px; }
        .cart-item { grid-template-columns: 100px 1fr; gap: 20px; }
        .cart-item-actions { flex-direction: row; align-items: center; }
    }
    @media (max-width: 400px) {
        .cart-item { grid-template-columns: 1fr; }
        .cart-item-img { height: 160px; }
    }
</style>
@endpush

@section('content')
<div class="cart-page">

    <div class="cart-header">
        <div class="orb-blue"></div>
        <div class="orb-gold"></div>
        <div class="cart-header-inner">
            <h1><span class="gradient-word">Keranjang</span> Belanja</h1>
            <p>Tinjau dan kelola produk Anda sebelum melanjutkan ke pembayaran.</p>

            <span class="cart-count-badge" id="cartItemCountBadge" style="display: none;">
                <i class="bi bi-bag"></i>
                <span id="cartItemCountText">0</span> item
            </span>
        </div>
    </div>

    <div class="cart-body" id="cartBody">
        <!-- Rendered by JS -->
    </div>

</div>

@push('scripts')
<script>
// Data harga produk dan gambar (sinkron dengan yang di homepage)
const productsData = {
    'MacBook Pro 16"': { price: 28999000, img: 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&q=80' },
    'Dell XPS 15': { price: 25999000, img: 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=500&q=80' },
    'ASUS ROG Strix G16': { price: 32999000, img: 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=500&q=80' },
    'HP Spectre x360': { price: 19999000, img: 'https://images.unsplash.com/photo-1629131726692-1accd0c53ce0?w=500&q=80' }
};

function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID').format(angka);
}

function loadCart() {
    const cart = JSON.parse(localStorage.getItem('my_cart') || '[]');
    const container = document.getElementById('cartBody');
    const badgeText = document.getElementById('cartItemCountText');
    const badgeWrap = document.getElementById('cartItemCountBadge');
    
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    if (cart.length === 0) {
        badgeWrap.style.display = 'none';
        container.innerHTML = `
            <div class="cart-items-col" style="grid-column: 1 / -1;">
                <div class="cart-empty">
                    <div class="cart-empty-icon"><i class="bi bi-bag-x"></i></div>
                    <h3>Keranjang Anda Kosong</h3>
                    <p>Belum ada produk yang ditambahkan.<br>Mulai belanja dan temukan laptop impian Anda!</p>
                    <a href="{{ url('/') }}" class="btn-white">
                        <i class="bi bi-arrow-left"></i> Kembali Belanja
                    </a>
                </div>
            </div>
        `;
        return;
    }
    
    badgeWrap.style.display = 'inline-flex';
    badgeText.textContent = totalItems;
    
    let subtotal = 0;
    
    let itemsHtml = `
        <div class="cart-items-col">
            <div class="cart-items-head">
                <span class="cart-items-title">Produk (${totalItems})</span>
                <button class="btn-clear-all" onclick="clearCart()">
                    <i class="bi bi-trash3"></i> Hapus Semua
                </button>
            </div>
    `;
    
    cart.forEach((item, index) => {
        const prodData = productsData[item.name] || { price: 15000000, img: 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&q=80' };
        const price = prodData.price;
        const itemTotal = price * item.quantity;
        subtotal += itemTotal;
        
        itemsHtml += `
            <div class="cart-item">
                <div class="cart-item-img">
                    <img src="${prodData.img}" alt="${item.name}">
                </div>
                
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-unit-price">Rp ${formatRupiah(price)} / unit</div>
                    
                    <div class="qty-stepper">
                        <button class="qty-btn" onclick="updateQuantity(${index}, -1)">−</button>
                        <span class="qty-val">${item.quantity}</span>
                        <button class="qty-btn" onclick="updateQuantity(${index}, 1)">+</button>
                    </div>
                    
                    <div class="cart-item-subtotal">Rp ${formatRupiah(itemTotal)}</div>
                </div>
                
                <div class="cart-item-actions">
                    <button class="btn-remove" onclick="removeItem(${index})" title="Hapus item">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    itemsHtml += `</div>`; // Close cart-items-col
    
    const shipping = subtotal >= 3000000 ? 0 : 50000;
    const total = subtotal + shipping;
    
    const summaryHtml = `
        <div class="cart-summary">
            <div class="summary-title">Ringkasan Pesanan</div>
            
            <div class="summary-row">
                <span>Subtotal</span>
                <span>Rp ${formatRupiah(subtotal)}</span>
            </div>
            <div class="summary-row">
                <span>Ongkos Kirim</span>
                <span>
                    ${shipping === 0 ? '<span style="color: #10b981; font-weight: 700;">Gratis</span>' : 'Rp ' + formatRupiah(shipping)}
                </span>
            </div>
            <div class="summary-row">
                <span>Diskon</span>
                <span>—</span>
            </div>
            
            <div class="summary-divider"></div>
            
            <div class="summary-total-row">
                <span class="summary-total-label">Total</span>
                <span class="summary-total-price">Rp ${formatRupiah(total)}</span>
            </div>
            
            <div class="promo-wrap">
                <input class="promo-input" type="text" placeholder="Kode promo..." id="promoInput">
                <button class="btn-apply-promo" onclick="alert('Kode promo tidak valid di mode demo')">Terapkan</button>
            </div>
            
            <button class="btn-checkout" onclick="checkout()">
                Lanjut Pembayaran <i class="bi bi-arrow-right"></i>
            </button>
            
            <a href="{{ url('/') }}" class="btn-continue">
                <i class="bi bi-chevron-left"></i> Lanjut Belanja
            </a>
            
            <div class="guarantee-strip">
                <div class="guarantee-item">
                    <i class="bi bi-shield-lock"></i>
                    <span>Pembayaran 100% aman & terenkripsi</span>
                </div>
                <div class="guarantee-item">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Garansi pengembalian 30 hari</span>
                </div>
                <div class="guarantee-item">
                    <i class="bi bi-box-seam"></i>
                    <span>Gratis ongkir di atas Rp 3.000.000</span>
                </div>
            </div>
        </div>
    `;
    
    container.innerHTML = itemsHtml + summaryHtml;
}

function updateQuantity(index, delta) {
    let cart = JSON.parse(localStorage.getItem('my_cart') || '[]');
    const newQuantity = cart[index].quantity + delta;
    
    if (newQuantity < 1 || newQuantity > 99) return;
    
    cart[index].quantity = newQuantity;
    localStorage.setItem('my_cart', JSON.stringify(cart));
    
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartBadge = document.getElementById('cartCount');
    if (cartBadge) cartBadge.textContent = totalItems;
    
    loadCart(); 
}

function removeItem(index) {
    let cart = JSON.parse(localStorage.getItem('my_cart') || '[]');
    cart.splice(index, 1);
    localStorage.setItem('my_cart', JSON.stringify(cart));
    
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartBadge = document.getElementById('cartCount');
    if (cartBadge) cartBadge.textContent = totalItems;
    
    loadCart();
}

function clearCart() {
    if (confirm('Hapus semua item dari keranjang?')) {
        localStorage.removeItem('my_cart');
        const cartBadge = document.getElementById('cartCount');
        if (cartBadge) cartBadge.textContent = 0;
        loadCart();
    }
}

function checkout() {
    const cart = JSON.parse(localStorage.getItem('my_cart') || '[]');
    if (cart.length === 0) {
        alert('Keranjang kosong!');
        return;
    }

    // Ubah teks tombol menjadi loading
    const btn = document.querySelector('.btn-checkout');
    const oriText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';
    btn.style.opacity = '0.7';
    btn.disabled = true;

    // Kirim data ke backend untuk sync ke session
    fetch('{{ route("cart.sync-demo") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ cart: cart })
    })
    .then(r => r.json())
    .then(data => {
        if(data.success) {
            // Berhasil sinkronisasi, redirect ke halaman checkout asli
            window.location.href = data.redirect;
        } else {
            alert('Gagal memproses pesanan demo.');
            btn.innerHTML = oriText;
            btn.style.opacity = '1';
            btn.disabled = false;
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan koneksi.');
        btn.innerHTML = oriText;
        btn.style.opacity = '1';
        btn.disabled = false;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    loadCart();
});
</script>
@endpush
@endsection