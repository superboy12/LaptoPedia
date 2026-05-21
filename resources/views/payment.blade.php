@extends('layouts.app')

@push('styles')
<style>
    .payment-page {
        min-height: 100vh;
        background: var(--black);
        padding: 52px 0 0;
    }

    .page-wrap {
        max-width: 860px;
        margin: 0 auto;
        padding: 64px 48px 120px;
    }

    .breadcrumb {
        display: flex; align-items: center; gap: 8px; margin-bottom: 48px;
    }
    .breadcrumb a { font-size: 0.78rem; color: var(--muted); text-decoration: none; transition: color 0.2s; }
    .breadcrumb a:hover { color: var(--white); }
    .breadcrumb i { font-size: 0.65rem; color: rgba(255,255,255,0.2); }
    .breadcrumb span { font-size: 0.78rem; color: var(--gold); font-weight: 600; }

    .checkout-steps {
        display: flex; align-items: center; justify-content: center;
        gap: 0; margin-bottom: 56px;
    }
    .step { display: flex; align-items: center; gap: 10px; }
    .step-line { width: 80px; height: 1px; background: rgba(255,255,255,0.1); margin: 0 4px; }
    .step-line.active { background: var(--gold); }
    .step-num {
        width: 34px; height: 34px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Manrope', sans-serif; font-size: 0.75rem; font-weight: 800;
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--muted); background: var(--surface); transition: all 0.3s;
    }
    .step.active .step-num { background: var(--gold); border-color: var(--gold); color: #000; }
    .step.done .step-num  { background: rgba(212,168,67,0.15); border-color: rgba(212,168,67,0.4); color: var(--gold); }
    .step-label { font-size: 0.73rem; font-weight: 600; color: var(--muted); white-space: nowrap; }
    .step.active .step-label { color: var(--white); }
    .step.done .step-label  { color: var(--gold); }

    /* Alert banners */
    .alert {
        border-radius: 12px; padding: 14px 20px;
        font-size: 0.83rem; margin-bottom: 20px;
        display: flex; align-items: center; gap: 10px;
    }
    .alert-success { background: rgba(34,197,94,0.1);  border: 1px solid rgba(34,197,94,0.3);  color: #4ade80; }
    .alert-warning { background: rgba(250,204,21,0.1); border: 1px solid rgba(250,204,21,0.3); color: #fbbf24; }
    .alert-danger  { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.3);  color: #f87171; }
    .alert-info    { background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.3); color: #60a5fa; }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .card-body { padding: 32px; }
    .card-title {
        font-family: 'Manrope', sans-serif;
        font-size: 0.7rem; font-weight: 700;
        letter-spacing: 0.12em; text-transform: uppercase;
        color: var(--gold); margin-bottom: 22px;
        display: flex; align-items: center; gap: 8px;
    }

    /* Order info grid */
    .oinfo-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 14px;
    }
    .oinfo-row {
        padding: 16px; background: rgba(255,255,255,0.03);
        border-radius: 12px; border: 1px solid var(--border);
    }
    .oinfo-label { font-size: 0.68rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px; }
    .oinfo-val   { font-size: 0.87rem; font-weight: 600; color: var(--white); }
    .oinfo-val.gold { color: var(--gold); font-size: 1.05rem; }

    /* Item list */
    .items-list { display: flex; flex-direction: column; gap: 12px; }
    .item-row {
        display: flex; align-items: center; gap: 14px;
        padding: 12px; background: rgba(255,255,255,0.03);
        border-radius: 12px;
    }
    .item-thumb {
        width: 50px; height: 50px; border-radius: 8px; flex-shrink: 0;
        overflow: hidden; background: rgba(255,255,255,0.05);
        display: flex; align-items: center; justify-content: center;
    }
    .item-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .item-info { flex: 1; min-width: 0; }
    .item-name { font-size: 0.83rem; font-weight: 600; color: var(--white); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .item-qty  { font-size: 0.72rem; color: var(--muted); margin-top: 2px; }
    .item-price { font-size: 0.85rem; font-weight: 700; color: var(--gold); white-space: nowrap; }

    .summary-divider { height: 1px; background: var(--border); margin: 18px 0; }
    .summary-row {
        display: flex; justify-content: space-between;
        font-size: 0.82rem; color: var(--muted); margin-bottom: 8px;
    }
    .summary-total {
        display: flex; justify-content: space-between; align-items: center;
        font-family: 'Manrope', sans-serif; font-size: 1.1rem; font-weight: 900;
        color: var(--white);
    }
    .summary-total .total-val { color: var(--gold); }

    /* Pay button section */
    .pay-section {
        display: flex; flex-direction: column; align-items: center;
        gap: 20px; padding: 36px;
    }
    .btn-pay {
        width: 100%; max-width: 420px;
        padding: 18px 32px;
        background: var(--gold);
        color: #000;
        border: none; border-radius: 14px;
        font-family: 'Manrope', sans-serif;
        font-size: 1rem; font-weight: 800;
        cursor: pointer; transition: all 0.2s;
        display: flex; align-items: center; justify-content: center; gap: 10px;
        letter-spacing: 0.01em;
    }
    .btn-pay:hover:not(:disabled) { background: #e8c84a; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(212,168,67,0.25); }
    .btn-pay:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

    .pay-secure-note {
        font-size: 0.73rem; color: var(--muted); text-align: center; line-height: 1.7;
    }
    .pay-secure-note i { color: var(--gold); }

    .pay-methods-wrap {
        display: flex; align-items: center; justify-content: center;
        gap: 8px; flex-wrap: wrap;
    }
    .pay-method-badge {
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--border);
        border-radius: 8px; padding: 5px 12px;
        font-size: 0.68rem; font-weight: 700;
        color: var(--muted); letter-spacing: 0.05em; text-transform: uppercase;
    }

    /* Sandbox notice */
    .sandbox-notice {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 18px;
        background: rgba(59,130,246,0.08);
        border: 1px solid rgba(59,130,246,0.2);
        border-radius: 10px; margin-bottom: 20px;
        font-size: 0.75rem; color: #93c5fd;
    }
    .sandbox-badge {
        background: rgba(59,130,246,0.2); color: #60a5fa;
        font-size: 0.62rem; font-weight: 800; letter-spacing: 0.1em;
        padding: 3px 8px; border-radius: 6px; text-transform: uppercase; flex-shrink: 0;
    }

    @media (max-width: 640px) {
        .page-wrap { padding: 40px 20px 80px; }
        .oinfo-grid { grid-template-columns: 1fr; }
        .checkout-steps { gap: 0; }
        .step-line { width: 40px; }
        .step-label { display: none; }
        .step.active .step-label { display: block; }
    }
</style>
@endpush

@section('content')
<div class="payment-page">
<div class="page-wrap">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('cart.index') }}">Keranjang</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('checkout.index') }}">Checkout</a>
        <i class="bi bi-chevron-right"></i>
        <span>Pembayaran</span>
    </div>

    {{-- Steps --}}
    <div class="checkout-steps">
        <div class="step done">
            <div class="step-num"><i class="bi bi-check2"></i></div>
            <div class="step-label">Keranjang</div>
        </div>
        <div class="step-line active"></div>
        <div class="step done">
            <div class="step-num"><i class="bi bi-check2"></i></div>
            <div class="step-label">Checkout</div>
        </div>
        <div class="step-line active"></div>
        <div class="step active">
            <div class="step-num">3</div>
            <div class="step-label">Pembayaran</div>
        </div>
    </div>

    {{-- Session alerts --}}
    @if(session('success'))
        <div class="alert alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('warning') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info"><i class="bi bi-info-circle-fill"></i> {{ session('info') }}</div>
    @endif

    {{-- Sandbox notice --}}
    <div class="sandbox-notice">
        <span class="sandbox-badge">Sandbox</span>
        Mode simulasi Midtrans aktif — tidak ada transaksi uang nyata. Gunakan kartu/akun test Midtrans.
    </div>

    {{-- Detail Pesanan --}}
    <div class="card">
        <div class="card-body">
            <div class="card-title"><i class="bi bi-receipt"></i> Detail Pesanan</div>
            <div class="oinfo-grid">
                <div class="oinfo-row">
                    <div class="oinfo-label">No. Pesanan</div>
                    <div class="oinfo-val">{{ $order->order_number }}</div>
                </div>
                <div class="oinfo-row">
                    <div class="oinfo-label">Tanggal Order</div>
                    <div class="oinfo-val">{{ $order->created_at->format('d M Y, H:i') }} WIB</div>
                </div>
                <div class="oinfo-row">
                    <div class="oinfo-label">Alamat Pengiriman</div>
                    <div class="oinfo-val">{{ $order->address }}</div>
                </div>
                <div class="oinfo-row">
                    <div class="oinfo-label">Total Tagihan</div>
                    <div class="oinfo-val gold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Item Pesanan --}}
    @if($order->items && $order->items->count() > 0)
    <div class="card">
        <div class="card-body">
            <div class="card-title"><i class="bi bi-bag"></i> Item Pesanan ({{ $order->items->count() }} produk)</div>
            <div class="items-list">
                @foreach($order->items as $item)
                <div class="item-row">
                    <div class="item-thumb">
                        @if($item->product_image)
                            <img src="{{ asset('storage/' . $item->product_image) }}" alt="{{ $item->product_name }}">
                        @else
                            <i class="bi bi-laptop" style="color:var(--muted);font-size:1.3rem;"></i>
                        @endif
                    </div>
                    <div class="item-info">
                        <div class="item-name">{{ $item->product_name }}</div>
                        <div class="item-qty">Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                    </div>
                    <div class="item-price">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                </div>
                @endforeach
            </div>
            <div class="summary-divider"></div>
            <div class="summary-total">
                <span>Total Pembayaran</span>
                <span class="total-val">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
    @endif

    {{-- Tombol Bayar Midtrans --}}
    <div class="card">
        <div class="card-title" style="padding: 32px 32px 0; margin-bottom: 0;">
            <i class="bi bi-credit-card-2-front"></i> Pilih Metode Pembayaran
        </div>
        <div class="pay-section">
            <div class="pay-methods-wrap">
                <span class="pay-method-badge">QRIS</span>
                <span class="pay-method-badge">GoPay</span>
                <span class="pay-method-badge">OVO</span>
                <span class="pay-method-badge">DANA</span>
                <span class="pay-method-badge">ShopeePay</span>
                <span class="pay-method-badge">Mandiri</span>
                <span class="pay-method-badge">BCA</span>
                <span class="pay-method-badge">BNI</span>
                <span class="pay-method-badge">BRI</span>
                <span class="pay-method-badge">Alfamart</span>
                <span class="pay-method-badge">Indomaret</span>
                <span class="pay-method-badge">Kartu Kredit</span>
            </div>

            <button id="pay-button" class="btn-pay">
                <i class="bi bi-shield-lock-fill"></i>
                Bayar Sekarang &mdash; Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </button>

            <p class="pay-secure-note">
                <i class="bi bi-shield-check"></i>
                Pembayaran diproses aman oleh <strong style="color:var(--white)">Midtrans</strong>.<br>
                Popup pemilihan metode pembayaran akan muncul setelah klik tombol di atas.
            </p>
        </div>
    </div>

</div>
</div>

{{-- ===== MIDTRANS SNAP ===== --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ $clientKey }}"></script>

<script>
    const snapToken = @json($order->snap_token);
    const finishUrl = @json(route('payment.finish', $order->id));
    const orderTotal = {{ $order->total_price }};

    const payBtn = document.getElementById('pay-button');

    payBtn.addEventListener('click', function () {
        payBtn.disabled = true;
        payBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" style="width:14px;height:14px;border-width:2px;display:inline-block;border-radius:50%;border:2px solid #000;border-top-color:transparent;animation:spin .6s linear infinite;"></span> Memuat...';

        window.snap.pay(snapToken, {
            onSuccess: function (result) {
                // Pembayaran berhasil (settlement/capture)
                const params = new URLSearchParams({
                    transaction_status: result.transaction_status,
                    payment_type: result.payment_type ?? '',
                    order_id: result.order_id ?? '',
                });
                window.location.href = finishUrl + '?' + params.toString();
            },
            onPending: function (result) {
                // Menunggu pembayaran (misal: bank transfer, alfamart)
                window.location.href = finishUrl + '?transaction_status=pending&payment_type=' + (result.payment_type ?? '');
            },
            onError: function (result) {
                console.error('Midtrans error:', result);
                alert('Terjadi kesalahan saat pembayaran. Silakan coba lagi.');
                resetBtn();
            },
            onClose: function () {
                // User tutup popup tanpa bayar
                resetBtn();
            }
        });
    });

    function resetBtn() {
        payBtn.disabled = false;
        payBtn.innerHTML = '<i class="bi bi-shield-lock-fill"></i> Bayar Sekarang &mdash; Rp ' + orderTotal;
    }
</script>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection
