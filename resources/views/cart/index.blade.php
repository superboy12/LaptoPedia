@extends('layouts.app')

@push('styles')
<style>
    /* =============================================
       CART PAGE — Premium Minimalist Redesign
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
        grid-template-columns: 1fr 360px;
        gap: 32px;
        align-items: start;
    }

    /* ---- Cart Items Column ---- */
    .cart-items-col { display: flex; flex-direction: column; gap: 0; }

    .cart-items-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
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
        border: 1px solid var(--border);
        border-radius: 24px;
        display: grid;
        grid-template-columns: 140px 1fr auto;
        gap: 28px;
        align-items: center;
        padding: 24px;
        margin-bottom: 16px;
        transition: border-color 0.4s ease, box-shadow 0.4s ease, transform 0.4s ease;
    }
    .cart-item:hover {
        border-color: var(--border-hover);
        box-shadow: 0 24px 64px rgba(0,0,0,0.08);
        transform: translateY(-4px);
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
        font-size: 0.97rem;
        font-weight: 700;
        color: var(--text);
        letter-spacing: -0.02em;
        transition: color 0.4s ease;
    }

    .cart-item-unit-price {
        font-size: 0.78rem;
        color: var(--text-muted);
        font-weight: 300;
        margin-top: 2px;
    }

    .cart-item-subtotal {
        font-family: 'Manrope', sans-serif;
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.03em;
        margin-top: 8px;
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
        padding: 6px 13px;
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
        width: 34px; height: 34px;
        border-radius: 9px;
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
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 32px;
        position: sticky;
        top: 72px;
        box-shadow: 0 16px 48px rgba(0,0,0,0.04);
        transition: background 0.4s ease, border-color 0.4s ease;
    }

    .summary-title {
        font-family: 'Manrope', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 22px;
    }

    .summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.86rem;
        color: var(--text-muted);
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
    }
    .summary-row:last-of-type { border-bottom: none; }
    .summary-row span:last-child { color: var(--text); font-weight: 600; }

    .summary-divider {
        height: 1px;
        background: var(--border);
        margin: 16px 0;
    }

    .summary-total-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 4px 0 20px;
    }
    .summary-total-label {
        font-family: 'Manrope', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text);
    }
    .summary-total-price {
        font-family: 'Manrope', sans-serif;
        font-size: 1.5rem;
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

    /* Checkout button — matches .btn-white from hero */
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
        margin-top: 10px;
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
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .guarantee-item {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 0.77rem;
        color: var(--text-muted);
    }
    .guarantee-item i { color: var(--gold); font-size: 0.88rem; }

    /* ---- Empty State ---- */
    .cart-empty {
        text-align: center;
        padding: 80px 24px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 22px;
    }
    .cart-empty-icon {
        font-size: 3.5rem;
        color: var(--text-muted);
        margin-bottom: 20px;
        opacity: 0.3;
    }
    .cart-empty h3 {
        font-family: 'Manrope', sans-serif;
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.03em;
        margin-bottom: 8px;
    }
    .cart-empty p {
        font-size: 0.87rem;
        color: var(--text-muted);
        font-weight: 300;
        margin-bottom: 28px;
        line-height: 1.65;
    }
    /* re-use .btn-white */
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
    .btn-white:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(212,168,67,0.3); color: #000; }

    /* ---- Toast notification ---- */
    .toast-wrap {
        position: fixed;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s ease, transform 0.3s ease;
        pointer-events: none;
    }
    .toast-wrap.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    .toast-inner {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 12px 20px;
        border-radius: 100px;
        font-size: 0.83rem;
        color: var(--text);
        box-shadow: 0 16px 48px rgba(0,0,0,0.25);
    }
    .toast-inner i { color: var(--gold); }

    /* ---- Responsive ---- */
    @media (max-width: 1060px) {
        .cart-body { grid-template-columns: 1fr; }
        .cart-summary { position: static; }
    }
    @media (max-width: 640px) {
        .cart-header { padding: 48px 24px 36px; }
        .cart-body { padding: 28px 16px 72px; }
        .cart-item { grid-template-columns: 90px 1fr; }
        .cart-item-actions { flex-direction: row; align-items: center; }
    }
    @media (max-width: 400px) {
        .cart-item { grid-template-columns: 1fr; }
        .cart-item-img { height: 140px; }
    }
</style>
@endpush

@section('content')

{{-- =============================================
     PAGE HEADER
============================================= --}}
<div class="cart-page">

    <div class="cart-header">
        <div class="orb-blue"></div>
        <div class="orb-gold"></div>
        <div class="cart-header-inner">
            <span class="section-label">Belanja Anda</span>
            <h1><span class="gradient-word">Keranjang</span> Belanja</h1>
            <p>Tinjau dan kelola produk sebelum melanjutkan ke pembayaran.</p>

            @if(count($cart) > 0)
            <span class="cart-count-badge" id="cartItemCount">
                <i class="bi bi-bag"></i>
                {{ collect($cart)->sum('quantity') }} item
            </span>
            @endif
        </div>
    </div>

    {{-- =============================================
         BODY
    ============================================= --}}
    <div class="cart-body">

        {{-- ---- LEFT: Cart Items ---- --}}
        <div class="cart-items-col">

            @if(count($cart) > 0)

            <div class="cart-items-head">
                <span class="cart-items-title">Produk ({{ collect($cart)->sum('quantity') }})</span>
                <button class="btn-clear-all" onclick="clearCart()">
                    <i class="bi bi-trash3"></i> Hapus Semua
                </button>
            </div>

            @foreach($cart as $id => $item)
            <div class="cart-item" id="cart-item-{{ $id }}">

                {{-- Image --}}
                <div class="cart-item-img">
                    <img
                        src="{{ $item['image'] ? asset('storage/'.$item['image']) : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&q=80' }}"
                        alt="{{ $item['name'] }}"
                        onerror="this.src='https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&q=80';this.onerror=null;">
                </div>

                {{-- Info --}}
                <div class="cart-item-info">
                    <div class="cart-item-name">{{ $item['name'] }}</div>
                    <div class="cart-item-unit-price">
                        Rp {{ number_format($item['price'], 0, ',', '.') }} / unit
                    </div>

                    {{-- Quantity Stepper --}}
                    <div class="qty-stepper">
                        <button class="qty-btn" onclick="changeQty({{ $id }}, -1)">−</button>
                        <span class="qty-val" id="qty-{{ $id }}">{{ $item['quantity'] }}</span>
                        <button class="qty-btn" onclick="changeQty({{ $id }}, 1)">+</button>
                    </div>

                    <div class="cart-item-subtotal" id="subtotal-{{ $id }}">
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </div>
                </div>

                {{-- Actions --}}
                <div class="cart-item-actions">
                    <button class="btn-remove" onclick="removeItem({{ $id }})" title="Hapus item">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

            </div>
            @endforeach

            @else

            {{-- Empty State --}}
            <div class="cart-empty">
                <div class="cart-empty-icon"><i class="bi bi-bag-x"></i></div>
                <h3>Keranjang Anda Kosong</h3>
                <p>Belum ada produk yang ditambahkan.<br>Mulai belanja dan temukan laptop impian Anda!</p>
                <a href="{{ url('/') }}" class="btn-white">
                    <i class="bi bi-arrow-left"></i> Kembali Belanja
                </a>
            </div>

            @endif

        </div>

        {{-- ---- RIGHT: Order Summary ---- --}}
        <div class="cart-summary">
            <div class="summary-title">Ringkasan Pesanan</div>

            <div class="summary-row">
                <span>Subtotal</span>
                <span id="summarySubtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Ongkos Kirim</span>
                <span>
                    @if($total >= 3000000)
                        <span style="color: #10b981; font-weight: 700;">Gratis</span>
                    @else
                        Rp 50.000
                    @endif
                </span>
            </div>
            <div class="summary-row">
                <span>Diskon</span>
                <span>—</span>
            </div>

            <div class="summary-divider"></div>

            <div class="summary-total-row">
                <span class="summary-total-label">Total</span>
                <span class="summary-total-price" id="summaryTotal">
                    Rp {{ number_format($total >= 3000000 ? $total : $total + 50000, 0, ',', '.') }}
                </span>
            </div>

            {{-- Promo Code --}}
            <div class="promo-wrap">
                <input class="promo-input" type="text" placeholder="Kode promo..." id="promoInput">
                <button class="btn-apply-promo" onclick="applyPromo()">Terapkan</button>
            </div>

            {{-- Checkout --}}
            <form method="POST" action="{{ route('cart.checkout') }}">
                @csrf
                <button type="submit" class="btn-checkout" {{ count($cart) === 0 ? 'disabled' : '' }}>
                    Lanjut Pembayaran <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <a href="{{ url('/') }}" class="btn-continue">
                <i class="bi bi-chevron-left"></i> Lanjut Belanja
            </a>

            {{-- Guarantees --}}
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

    </div>
</div>

{{-- Toast --}}
<div class="toast-wrap" id="toast">
    <div class="toast-inner">
        <i class="bi bi-check-circle-fill" id="toastIcon"></i>
        <span id="toastMsg">Berhasil diperbarui</span>
    </div>
</div>

@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

/* ---- Helpers ---- */
function showToast(msg, success = true) {
    const toast = document.getElementById('toast');
    const icon  = document.getElementById('toastIcon');
    icon.className = success ? 'bi bi-check-circle-fill' : 'bi bi-x-circle-fill';
    icon.style.color = success ? 'var(--gold)' : '#f87171';
    document.getElementById('toastMsg').textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2800);
}

function updateNavCart(count) {
    const badge = document.getElementById('cartCount');
    if (badge) badge.textContent = count;
}

/* ---- Change Quantity ---- */
function changeQty(id, delta) {
    const qtyEl = document.getElementById('qty-' + id);
    let qty = parseInt(qtyEl.textContent) + delta;
    if (qty < 1) qty = 1;
    if (qty > 99) qty = 99;

    fetch('/cart/update/' + id, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ quantity: qty })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            qtyEl.textContent = qty;
            document.getElementById('subtotal-' + id).textContent = 'Rp ' + data.itemTotal;
            document.getElementById('summarySubtotal').textContent = 'Rp ' + data.total;
            updateNavCart(data.cartCount);
            refreshCartCount(data.cartCount);
        }
    })
    .catch(() => showToast('Gagal memperbarui kuantitas', false));
}

/* ---- Remove Item ---- */
function removeItem(id) {
    const el = document.getElementById('cart-item-' + id);
    el.style.transition = 'opacity 0.3s, transform 0.3s';
    el.style.opacity = '0';
    el.style.transform = 'translateX(20px)';

    setTimeout(() => {
        fetch('/cart/remove/' + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                el.remove();
                document.getElementById('summarySubtotal').textContent = 'Rp ' + data.total;
                updateNavCart(data.cartCount);
                refreshCartCount(data.cartCount);
                showToast('Item berhasil dihapus dari keranjang');
                if (data.cartCount === 0) location.reload();
            }
        })
        .catch(() => { el.style.opacity = '1'; el.style.transform = ''; showToast('Gagal menghapus item', false); });
    }, 300);
}

/* ---- Clear All ---- */
function clearCart() {
    if (!confirm('Hapus semua item dari keranjang?')) return;

    fetch('/cart/clear', {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            updateNavCart(0);
            location.reload();
        }
    })
    .catch(() => showToast('Gagal mengosongkan keranjang', false));
}

/* ---- Promo (placeholder) ---- */
function applyPromo() {
    const code = document.getElementById('promoInput').value.trim();
    if (!code) return;
    showToast('Kode promo "' + code + '" tidak valid atau sudah kedaluwarsa', false);
}

/* ---- Refresh cart badge + count label ---- */
function refreshCartCount(count) {
    const badge = document.getElementById('cartItemCount');
    if (badge) badge.innerHTML = '<i class="bi bi-bag"></i> ' + count + ' item';
}
</script>
@endpush
