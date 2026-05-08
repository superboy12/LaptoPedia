@extends('layouts.app')

@push('styles')
<style>
    .cart-page {
        min-height: 100vh;
        background: var(--bg);
        padding-top: 52px;
    }

    .cart-header {
        background: var(--bg);
        padding: 100px 48px 60px;
        text-align: center;
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
    }

    .cart-body {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 48px 120px;
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 60px;
        align-items: start;
    }

    .cart-items-title {
        font-family: 'Manrope', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 24px;
        border-bottom: 1px solid var(--border);
        padding-bottom: 12px;
        display: block;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 120px 1fr auto;
        gap: 32px;
        align-items: center;
        padding: 32px 0;
        border-bottom: 1px solid var(--border);
        position: relative;
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
    }

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

    .qty-stepper {
        display: inline-flex;
        align-items: center;
        border: 1px solid var(--border);
        border-radius: 8px;
        margin-top: 15px;
    }
    .qty-btn {
        background: none;
        border: none;
        color: var(--text);
        padding: 8px 14px;
        cursor: pointer;
    }
    .qty-btn:hover { background: var(--surface-2); }
    .qty-val {
        padding: 0 10px;
        font-weight: 700;
        min-width: 30px;
        text-align: center;
    }

    .btn-remove {
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 1.2rem;
        cursor: pointer;
    }
    .btn-remove:hover { color: #f87171; }

    .cart-summary {
        background: var(--surface);
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
    .summary-total-price {
        font-family: 'Manrope', sans-serif;
        font-size: 1.8rem;
        font-weight: 900;
        color: var(--gold);
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
    }
    .btn-apply-promo {
        background: none;
        border: 1px solid var(--gold);
        color: var(--gold);
        padding: 0 20px;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
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
        font-weight: 800;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
    }
    .btn-checkout.disabled {
        opacity: 0.5;
        pointer-events: none;
    }
    .btn-continue {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.85rem;
    }
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
    .guarantee-item i { color: var(--gold); }
    .cart-empty {
        text-align: center;
        padding: 80px 24px;
        background: var(--surface);
        border-radius: 22px;
    }
    .cart-empty-icon {
        font-size: 3.5rem;
        color: var(--text-muted);
        margin-bottom: 20px;
        opacity: 0.3;
    }
    .btn-white {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #d4a843, #b8870e);
        color: #000;
        padding: 14px 28px;
        border-radius: 100px;
        text-decoration: none;
        font-weight: 700;
    }
    .toast-wrap {
        position: fixed;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
    }
    .toast-wrap.show { opacity: 1; }
    .toast-inner {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 12px 20px;
        border-radius: 100px;
        font-size: 0.83rem;
    }
    .toast-inner i { color: var(--gold); }
    .discount { color: #10b981 !important; }
    
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
</style>
@endpush

@section('content')
<div class="cart-page">

    <div class="cart-header">
        <h1><span>Keranjang</span> Belanja</h1>
        <p>Tinjau produk pilihan Anda sebelum melanjutkan ke tahap pembayaran aman kami.</p>
    </div>

    <div class="cart-body">

        <div class="cart-items-col">
            @if(count($cart) > 0)
            <span class="cart-items-title">Produk ({{ collect($cart)->sum('quantity') }})</span>
            @foreach($cart as $key => $item)
            <div class="cart-item" id="cart-item-{{ $key }}">
                <div class="cart-item-img">
                    @if(isset($item['image']) && $item['image'])
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&q=80" alt="Product">
                    @endif
                </div>
                <div class="cart-item-info">
                    <div class="cart-item-name">{{ $item['name'] }}</div>
                    <div class="cart-item-unit-price">Rp {{ number_format($item['price'], 0, ',', '.') }} / unit</div>
                    <div class="qty-stepper">
                        <button class="qty-btn" onclick="changeQty('{{ $key }}', -1)">−</button>
                        <span class="qty-val" id="qty-{{ $key }}">{{ $item['quantity'] }}</span>
                        <button class="qty-btn" onclick="changeQty('{{ $key }}', 1)">+</button>
                    </div>
                    <div class="cart-item-subtotal" id="subtotal-{{ $key }}">
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </div>
                </div>
                <button class="btn-remove" onclick="removeItem('{{ $key }}')"><i class="bi bi-x"></i></button>
            </div>
            @endforeach
            @else
            <div class="cart-empty">
                <div class="cart-empty-icon"><i class="bi bi-bag-x"></i></div>
                <h3>Keranjang Anda Kosong</h3>
                <p>Belum ada produk yang ditambahkan.<br>Mulai belanja dan temukan laptop impian Anda!</p>
                <a href="{{ route('products.index') }}" class="btn-white"><i class="bi bi-arrow-left"></i> Kembali Belanja</a>
            </div>
            @endif
        </div>

        <div class="cart-summary">
            <div class="summary-title">Ringkasan Pesanan</div>
            @php
                $subtotal = 0;
                foreach($cart as $item) { $subtotal += $item['price'] * $item['quantity']; }
                $shippingCost = 15000;
                $insurance = 15000;
                $discount = session('discount', 0);
                $total = $subtotal + $shippingCost + $insurance - $discount;
            @endphp
            <div class="summary-row"><span>Subtotal</span><span id="summarySubtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
            <div class="summary-row"><span>Ongkos Kirim</span><span id="summaryShipping">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span></div>
            <div class="summary-row"><span>Asuransi Pengiriman</span><span id="summaryInsurance">Rp {{ number_format($insurance, 0, ',', '.') }}</span></div>
            <div class="summary-row"><span>Diskon</span><span id="summaryDiscount" class="{{ $discount > 0 ? 'discount' : '' }}">@if($discount > 0)- Rp {{ number_format($discount, 0, ',', '.') }}@else Rp 0 @endif</span></div>
            <div class="summary-divider"></div>
            <div class="summary-total-row"><span class="summary-total-label">Total</span><span class="summary-total-price" id="summaryTotal">Rp {{ number_format($total, 0, ',', '.') }}</span></div>
            
            <div class="promo-wrap">
                <input class="promo-input" type="text" placeholder="Kode promo (DISKON10/DISKON20/SPECIAL50)..." id="promoInput">
                <button class="btn-apply-promo" onclick="applyPromo()">Terapkan</button>
            </div>
            @if(session('coupon_code'))
            <div style="text-align: center; margin-bottom: 15px;">
                <span style="background: rgba(16,185,129,0.15); color: #10b981; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem;">
                    <i class="bi bi-tag"></i> Kupon {{ session('coupon_code') }} aktif! Diskon Rp {{ number_format(session('discount', 0), 0, ',', '.') }}
                </span>
            </div>
            @endif
            <a href="{{ route('checkout.index') }}" class="btn-checkout {{ count($cart) === 0 ? 'disabled' : '' }}">Lanjut ke Checkout <i class="bi bi-arrow-right"></i></a>
            <a href="{{ route('products.index') }}" class="btn-continue"><i class="bi bi-chevron-left"></i> Lanjut Belanja</a>
            <div class="guarantee-strip">
                <div class="guarantee-item"><i class="bi bi-shield-lock"></i><span>Pembayaran 100% aman & terenkripsi</span></div>
                <div class="guarantee-item"><i class="bi bi-arrow-repeat"></i><span>Garansi pengembalian 30 hari</span></div>
                <div class="guarantee-item"><i class="bi bi-box-seam"></i><span>Gratis ongkir di atas Rp 3.000.000</span></div>
            </div>
        </div>

    </div>
</div>

<div class="toast-wrap" id="toast">
    <div class="toast-inner"><i class="bi bi-check-circle-fill" id="toastIcon"></i><span id="toastMsg">Berhasil diperbarui</span></div>
</div>
@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

function showToast(msg, success = true) {
    const toast = document.getElementById('toast');
    const icon = document.getElementById('toastIcon');
    icon.className = success ? 'bi bi-check-circle-fill' : 'bi bi-x-circle-fill';
    icon.style.color = success ? 'var(--gold)' : '#f87171';
    document.getElementById('toastMsg').textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2800);
}

function changeQty(key, delta) {
    const qtyEl = document.getElementById('qty-' + key);
    let qty = parseInt(qtyEl.textContent) + delta;
    if (qty < 1) qty = 1;
    if (qty > 99) qty = 99;

    fetch('/cart/update/' + key, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ quantity: qty })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            qtyEl.textContent = qty;
            document.getElementById('subtotal-' + key).textContent = 'Rp ' + data.itemTotal;
            document.getElementById('summarySubtotal').textContent = 'Rp ' + data.total;
            location.reload();
        }
    })
    .catch(() => showToast('Gagal memperbarui kuantitas', false));
}

function removeItem(key) {
    if (!confirm('Hapus item ini dari keranjang?')) return;
    const el = document.getElementById('cart-item-' + key);
    el.style.opacity = '0';
    setTimeout(() => {
        fetch('/cart/remove/' + key, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(() => showToast('Gagal menghapus item', false));
    }, 200);
}

function applyPromo() {
    const code = document.getElementById('promoInput').value.trim().toUpperCase();
    if (!code) {
        showToast('Masukkan kode promo!', false);
        return;
    }
    
    fetch('{{ route("checkout.applyCoupon") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ coupon_code: code })
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message, data.success);
        if (data.success) {
            setTimeout(() => location.reload(), 1500);
        }
    })
    .catch(() => showToast('Gagal menerapkan kupon', false));
}
</script>
@endpush