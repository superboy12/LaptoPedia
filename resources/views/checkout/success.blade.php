@extends('layouts.app')

@push('styles')
<style>
.success-page {
    padding: 100px 24px;
    min-height: 100vh;
    background: var(--bg);
    display: flex;
    align-items: center;
    justify-content: center;
}

.success-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 24px;
    width: 100%;
    max-width: 600px;
    padding: 48px;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

.sc-icon {
    width: 80px; height: 80px;
    font-size: 2.5rem;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px;
}

.sc-icon.success {
    background: rgba(34, 197, 94, 0.1);
    color: #4ade80;
    box-shadow: 0 0 0 8px rgba(34, 197, 94, 0.05);
}

.sc-icon.pending {
    background: rgba(212, 168, 67, 0.1);
    color: var(--gold);
    box-shadow: 0 0 0 8px rgba(212, 168, 67, 0.05);
}

.sc-title {
    font-family: 'Manrope', sans-serif;
    font-size: 2rem;
    font-weight: 900;
    color: var(--text);
    margin-bottom: 8px;
    letter-spacing: -0.03em;
}
.sc-desc {
    color: var(--text-muted);
    font-size: 1rem;
    margin-bottom: 32px;
}

/* Order Info */
.order-info {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    text-align: left;
    margin-bottom: 32px;
}
.info-row {
    display: flex; justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    font-size: 0.95rem;
}
.info-row:last-child { margin-bottom: 0; }
.info-label { color: var(--text-muted); }
.info-val { font-weight: 700; color: var(--text); }
.info-val.highlight { color: var(--gold); font-size: 1.1rem; }

/* Status Badges */
.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
.status-badge.pending {
    background: rgba(212, 168, 67, 0.1);
    color: var(--gold);
    border: 1px solid rgba(212, 168, 67, 0.2);
}
.status-badge.paid {
    background: rgba(34, 197, 94, 0.1);
    color: #4ade80;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

/* Payment Instructions */
.payment-box {
    border: 2px dashed var(--gold);
    border-radius: 16px;
    padding: 32px;
    background: var(--gold-dim);
    margin-bottom: 32px;
}
.payment-box.paid {
    border: 2px dashed #22c55e;
    background: rgba(34, 197, 94, 0.05);
}
.pb-title {
    font-family: 'Manrope', sans-serif;
    font-weight: 800;
    color: var(--gold);
    margin-bottom: 16px;
    font-size: 1.1rem;
}
.pb-title.paid {
    color: #4ade80;
}
.pb-instruction {
    font-size: 0.85rem;
    color: var(--text);
    line-height: 1.6;
}

/* Buttons */
.btn-group { display: flex; gap: 16px; }
.btn-home {
    flex: 1;
    background: transparent;
    border: 1px solid var(--border);
    color: var(--text);
    padding: 14px;
    border-radius: 12px;
    font-weight: 700; font-family: 'DM Sans', sans-serif;
    transition: all 0.2s;
    text-decoration: none;
    text-align: center;
}
.btn-home:hover { background: var(--search-bg); border-color: var(--border-hover); }

.btn-confirm {
    flex: 1;
    background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
    color: #000;
    border: none;
    padding: 14px;
    border-radius: 12px;
    font-weight: 800; font-family: 'Manrope', sans-serif;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
}
.btn-confirm:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(212,168,67,0.3); }
.btn-confirm:disabled { opacity: 0.7; cursor: not-allowed; }

@media (max-width: 600px) {
    .btn-group { flex-direction: column; }
}
</style>
@endpush

@section('content')
<div class="success-page">
    <div class="success-card">
        @if($order->status === 'paid')
            <div class="sc-icon success">
                <i class="bi bi-check-lg"></i>
            </div>
            <h1 class="sc-title">Pembayaran Berhasil!</h1>
            <p class="sc-desc">Terima kasih, pembayaran Anda telah berhasil diverifikasi secara otomatis.</p>
        @else
            <div class="sc-icon pending">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <h1 class="sc-title">Pesanan Berhasil Dibuat</h1>
            <p class="sc-desc">Langkah terakhir! Silakan selesaikan pembayaran pesanan Anda.</p>
        @endif

        <div class="order-info">
            <div class="info-row">
                <span class="info-label">ID Pesanan</span>
                <span class="info-val">{{ $order->order_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal</span>
                <span class="info-val">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status Transaksi</span>
                <span class="info-val">
                    @if($order->status === 'paid')
                        <span class="status-badge paid">Sudah Dibayar</span>
                    @else
                        <span class="status-badge pending">Menunggu Pembayaran</span>
                    @endif
                </span>
            </div>
            <div style="border-top: 1px dashed var(--border); margin: 16px 0;"></div>
            <div class="info-row">
                <span class="info-label">Total Tagihan</span>
                <span class="info-val highlight">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->status === 'pending')
        <div class="payment-box">
            <h3 class="pb-title">Pembayaran Instan via Midtrans</h3>
            <div class="pb-instruction">
                Selesaikan pembayaran Anda menggunakan metode QRIS (GoPay/OVO/Dana), Virtual Account Bank (BCA, Mandiri, BNI, BRI), Kartu Kredit, atau metode pembayaran lainnya.
            </div>
            <button id="pay-button" class="btn-confirm" style="width: 100%; border: none; margin-top: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="bi bi-wallet2"></i> Bayar Sekarang
            </button>
        </div>
        @else
        <div class="payment-box paid">
            <h3 class="pb-title paid">Laptop Anda Siap Diproses</h3>
            <div class="pb-instruction" style="color: var(--text-muted);">
                Tim LaptoPedia sedang mempersiapkan pengiriman laptop pesanan Anda. Kami akan segera menghubungi nomor telepon <strong>{{ $order->phone }}</strong> jika ada informasi tambahan terkait pengantaran.
            </div>
        </div>
        @endif

        <div class="btn-group">
            <a href="{{ route('home') }}" class="btn-home">Kembali ke Beranda</a>
            @if($order->status === 'pending')
                <a href="{{ route('support') }}" class="btn-home" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="bi bi-question-circle"></i> Butuh Bantuan?
                </a>
            @endif
        </div>

    </div>
</div>
@endsection

@push('scripts')
@if($order->status === 'pending' && $order->snap_token)
<!-- Midtrans Snap JS -->
<script type="text/javascript" 
        src="https://app.{{ config('midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}">
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const payButton = document.getElementById('pay-button');
    
    function triggerPayment() {
        if (payButton) {
            payButton.disabled = true;
            payButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Membuka Gerbang Pembayaran...';
        }
        
        window.snap.pay('{{ $order->snap_token }}', {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                window.location.href = "{{ route('checkout.success', $order->order_number) }}";
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                window.location.href = "{{ route('checkout.success', $order->order_number) }}";
            },
            onError: function(result) {
                console.error('Payment error:', result);
                alert("Terjadi kesalahan pada pembayaran Anda. Silakan coba kembali.");
                if (payButton) {
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="bi bi-wallet2"></i> Bayar Sekarang';
                }
            },
            onClose: function() {
                console.log('Payment popup closed by customer');
                if (payButton) {
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="bi bi-wallet2"></i> Bayar Sekarang';
                }
            }
        });
    }

    // Otomatis buka popup pembayaran ketika halaman selesai dimuat
    setTimeout(triggerPayment, 800);

    // Buka popup jika tombol diklik manual
    if (payButton) {
        payButton.addEventListener('click', function(e) {
            e.preventDefault();
            triggerPayment();
        });
    }
});
</script>
@endif
@endpush

