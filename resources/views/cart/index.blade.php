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

    /* ---- Page Header — Clean & Elegant ---- */
    .cart-header {
        background: var(--bg);
        padding: 100px 48px 60px;
        position: relative;
        text-align: center;
    }
    .cart-header-inner {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }
    .cart-header h1 {
        font-family: 'Manrope', sans-serif;
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 800;
        letter-spacing: -0.04em;
        color: var(--text);
        margin-bottom: 16px;
    }
    .cart-header h1 span {
        background: linear-gradient(to right, #f0d080, #d4a843);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .cart-header p {
        font-size: 1rem;
        color: var(--text-muted);
        font-weight: 400;
        letter-spacing: 0.01em;
        opacity: 0.8;
    }

    /* ---- Main Layout ---- */
    .cart-body {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 48px 120px;
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 60px;
        align-items: start;
    }

    /* ---- Cart Items Column ---- */
    .cart-items-title {
        font-family: 'Manrope', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 24px;
        display: block;
        border-bottom: 1px solid var(--border);
        padding-bottom: 12px;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 120px 1fr auto;
        gap: 32px;
        align-items: center;
        padding: 32px 0;
        border-bottom: 1px solid var(--border);
        transition: transform 0.3s ease;
    }
    .cart-item:hover {
        transform: translateX(8px);
    }

    .cart-item-img {
        background: var(--surface-2);
        border-radius: 12px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        overflow: hidden;
    }
    .cart-item-img img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        filter: drop-shadow(0 10px 20px rgba(0,0,0,0.1));
    }

    .cart-item-info { display: flex; flex-direction: column; gap: 6px; }
    .cart-item-name {
        font-family: 'Manrope', sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text);
    }
    .cart-item-unit-price {
        font-size: 0.85rem;
        color: var(--text-muted);
    }
    .cart-item-subtotal {
        font-family: 'Manrope', sans-serif;
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--gold);
        margin-top: 10px;
    }

    /* Quantity stepper - Minimalist */
    .qty-stepper {
        display: inline-flex;
        align-items: center;
        border: 1px solid var(--border);
        border-radius: 8px;
        margin-top: 15px;
        width: fit-content;
    }
    .qty-btn {
        background: none;
        border: none;
        color: var(--text);
        padding: 8px 14px;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.2s;
    }
    .qty-btn:hover { background: var(--surface-2); }
    .qty-val {
        padding: 0 10px;
        font-weight: 700;
        font-size: 0.9rem;
        min-width: 30px;
        text-align: center;
    }

    .btn-remove {
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 1.2rem;
        cursor: pointer;
        transition: color 0.2s;
    }
    .btn-remove:hover { color: #f87171; }

    /* ---- Summary Sidebar - Glassmorphism ---- */
    .cart-summary {
        background: var(--surface);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 32px;
        padding: 40px;
        position: sticky;
        top: 100px;
    }
    .summary-title {
        font-family: 'Manrope', sans-serif;
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 30px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 18px;
        font-size: 0.95rem;
        color: var(--text-muted);
    }
    .summary-row span:last-child { color: var(--text); font-weight: 600; }

    .summary-divider {
        height: 1px;
        background: var(--border);
        margin: 25px 0;
    }

    .summary-total-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 35px;
    }
    .summary-total-label { font-weight: 700; color: var(--text); }
    .summary-total-price {
        font-family: 'Manrope', sans-serif;
        font-size: 1.8rem;
        font-weight: 900;
        color: var(--text);
    }

    .promo-wrap {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
    }
    .promo-input {
        flex: 1;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 12px 18px;
        color: var(--text);
        font-size: 0.9rem;
    }
    .btn-apply-promo {
        background: none;
        border: 1px solid var(--gold);
        color: var(--gold);
        padding: 0 20px;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-apply-promo:hover {
        background: var(--gold);
        color: #000;
    }

    .btn-checkout {
        background: linear-gradient(135deg, #f0d080, #d4a843);
        color: #000;
        width: 100%;
        padding: 18px;
        border-radius: 100px;
        border: none;
        font-family: 'Manrope', sans-serif;
        font-weight: 800;
        font-size: 1rem;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
    }
    .btn-checkout:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(212,168,67,0.3);
    }

    .btn-continue {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: color 0.2s;
    }
    .btn-continue:hover { color: var(--text); }

    /* Guarantee strip */
    .guarantee-strip {
        margin-top: 40px;
        display: grid;
        gap: 15px;
    }
    .guarantee-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    .guarantee-item i { color: var(--gold); font-size: 1rem; }

    @media (max-width: 1000px) {
        .cart-body { grid-template-columns: 1fr; padding: 0 24px 80px; }
        .cart-summary { position: static; margin-top: 40px; }
    }
    @media (max-width: 600px) {
        .cart-header { padding: 80px 24px 40px; }
        .cart-item { grid-template-columns: 1fr; gap: 20px; text-align: center; }
        .cart-item-img { height: 160px; margin: 0 auto; width: 100%; }
        .qty-stepper { margin: 15px auto 0; }
        .btn-remove { position: absolute; top: 20px; right: 0; }
        .cart-item { position: relative; }
    }

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
        <div class="cart-header-inner">
            <h1><span>Keranjang</span> Belanja</h1>
            <p>Tinjau produk pilihan Anda sebelum melanjutkan ke tahap pembayaran aman kami.</p>
        </div>
    </div>

    {{-- =============================================
         BODY
    ============================================= --}}
    <div class="cart-body">

        {{-- ---- LEFT: Cart Items ---- --}}
        <div class="cart-items-col">

            @if(count($cart) > 0)

            <span class="cart-items-title">Produk ({{ collect($cart)->sum('quantity') }})</span>

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
                        <button class="qty-btn" onclick="changeQty('{{ $id }}', -1)">−</button>
                        <span class="qty-val" id="qty-{{ $id }}">{{ $item['quantity'] }}</span>
                        <button class="qty-btn" onclick="changeQty('{{ $id }}', 1)">+</button>
                    </div>

                    <div class="cart-item-subtotal" id="subtotal-{{ $id }}">
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </div>
                </div>

                {{-- Actions --}}
                <button class="btn-remove" onclick="removeItem('{{ $id }}')" title="Hapus item">
                    <i class="bi bi-x"></i>
                </button>

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
            <a href="{{ route('checkout.index') }}" class="btn-checkout" {{ count($cart) === 0 ? 'style="pointer-events:none; opacity:0.5;"' : '' }}>
                Lanjut Pembayaran <i class="bi bi-arrow-right"></i>
            </a>

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

// Fungsi lokal untuk update label di halaman Cart saja
function updateCartPageLabels(count) {
    const title = document.querySelector('.cart-items-title');
    if (title) title.textContent = 'Produk (' + count + ')';
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
            if (typeof refreshCartCount === 'function') {
                refreshCartCount(data.cartCount);
            }
            updateCartPageLabels(data.cartCount);
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
                if (typeof refreshCartCount === 'function') {
                    refreshCartCount(data.cartCount);
                }
                updateCartPageLabels(data.cartCount);
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
            if (typeof refreshCartCount === 'function') {
                refreshCartCount(0);
            }
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


</script>
@endpush
