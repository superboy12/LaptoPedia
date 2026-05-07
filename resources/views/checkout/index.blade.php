@extends('layouts.app')

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
/* Checkout Page Styles */
.checkout-page {
    padding-top: 52px;
    min-height: 100vh;
    background: var(--bg);
}

.checkout-header {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 36px 24px;
    text-align: center;
}
.checkout-header h1 {
    font-family: 'Manrope', sans-serif;
    font-size: 2.2rem;
    font-weight: 900;
    color: var(--text);
    margin-bottom: 8px;
}
.checkout-header p {
    color: var(--text-muted);
    font-size: 0.95rem;
}

.checkout-layout {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 24px 80px;
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 32px;
    align-items: start;
}

/* Sections */
.co-section {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}
.co-title {
    font-family: 'Manrope', sans-serif;
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--text);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.co-title i { color: var(--gold); }

/* Form Group */
.form-group { margin-bottom: 20px; }
.form-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 8px;
}
.form-input, .form-textarea {
    width: 100%;
    background: var(--bg);
    border: 1px solid var(--border);
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    padding: 12px 16px;
    border-radius: 10px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-input:focus, .form-textarea:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(212,168,67,0.1);
}
.form-textarea { resize: vertical; min-height: 100px; }

/* Map */
#map {
    width: 100%;
    height: 300px;
    border-radius: 10px;
    border: 1px solid var(--border);
    margin-bottom: 12px;
    z-index: 1; /* Prevent overlapping with sticky header */
}
.map-hint {
    font-size: 0.8rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Payment Options */
.payment-methods {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.pay-method-label {
    display: block;
    cursor: pointer;
}
.pay-method-label input { display: none; }
.pay-method-box {
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 16px;
    text-align: center;
    transition: all 0.2s;
    background: var(--bg);
}
.pay-method-label input:checked + .pay-method-box {
    border-color: var(--gold);
    background: var(--gold-dim);
    box-shadow: 0 4px 12px rgba(212,168,67,0.15);
}
.pay-method-box i {
    font-size: 1.8rem;
    color: var(--text-muted);
    margin-bottom: 8px;
    display: block;
}
.pay-method-label input:checked + .pay-method-box i { color: var(--gold); }
.pay-method-box span {
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--text);
}

/* Order Summary Sidebar */
.summary-box {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 28px;
    position: sticky;
    top: 80px;
}
.summary-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 16px;
}
.summary-img {
    width: 60px; height: 60px;
    border-radius: 8px;
    background: var(--surface-2);
    display: flex; align-items: center; justify-content: center;
    padding: 8px;
}
.summary-img img { max-width: 100%; max-height: 100%; object-fit: contain; }
.summary-detail { flex: 1; }
.summary-name { font-size: 0.85rem; font-weight: 700; color: var(--text); line-height: 1.3; margin-bottom: 4px; }
.summary-qty { font-size: 0.75rem; color: var(--text-muted); }
.summary-price { font-weight: 800; font-size: 0.85rem; color: var(--gold); }

.summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    color: var(--text-muted);
    margin-bottom: 12px;
}
.summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 1.2rem;
    font-weight: 900;
    color: var(--text);
    padding-top: 16px;
    border-top: 1px dashed var(--border);
    margin-bottom: 24px;
}

.btn-checkout {
    width: 100%;
    background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
    color: #000;
    border: none;
    padding: 16px;
    border-radius: 12px;
    font-family: 'Manrope', sans-serif;
    font-weight: 800;
    font-size: 1rem;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(212,168,67,0.3);
}

@media (max-width: 900px) {
    .checkout-layout { grid-template-columns: 1fr; }
    .summary-box { position: static; }
}
</style>
@endpush

@section('content')
<div class="checkout-page">

    <div class="checkout-header">
        <h1>Checkout</h1>
        <p>Lengkapi detail pengiriman dan pembayaran Anda</p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="checkout-layout">

            {{-- LEFT: FORMS --}}
            <div class="co-left">
                
                {{-- Alamat Pengiriman --}}
                <div class="co-section">
                    <h2 class="co-title"><i class="bi bi-geo-alt"></i> Alamat Pengiriman</h2>
                    
                    <div class="form-group">
                        <label class="form-label">Tandai Lokasi di Peta</label>
                        <div id="map"></div>
                        <div class="map-hint">
                            <i class="bi bi-info-circle"></i> Geser pin untuk menentukan titik koordinat yang akurat.
                        </div>
                        <input type="hidden" name="latitude" id="latInput" required>
                        <input type="hidden" name="longitude" id="lngInput" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Detail Alamat Lengkap</label>
                        <textarea name="address" class="form-textarea" placeholder="Contoh: Jl. Sudirman No. 123, Gedung Indah Lt. 4, Jakarta Pusat..." required>{{ old('address', auth()->user()->alamat) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor WhatsApp / Telepon</label>
                        <input type="tel" name="phone" class="form-input" placeholder="081234567890" value="{{ old('phone', auth()->user()->no_telepon) }}" required>
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div class="co-section">
                    <h2 class="co-title"><i class="bi bi-wallet2"></i> Metode Pembayaran</h2>
                    
                    <div class="payment-methods">
                        <label class="pay-method-label">
                            <input type="radio" name="payment_method" value="qris" required checked>
                            <div class="pay-method-box">
                                <i class="bi bi-qr-code-scan"></i>
                                <span>QRIS (E-Wallet & M-Banking)</span>
                            </div>
                        </label>
                        
                        <label class="pay-method-label">
                            <input type="radio" name="payment_method" value="transfer" required>
                            <div class="pay-method-box">
                                <i class="bi bi-bank"></i>
                                <span>Transfer Bank (Manual)</span>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            {{-- RIGHT: SUMMARY --}}
            <div class="co-right">
                <div class="summary-box">
                    <h2 class="co-title" style="font-size:1.1rem; margin-bottom:24px;">Ringkasan Pesanan</h2>
                    
                    <div class="summary-items-list" style="margin-bottom: 24px;">
                        @foreach($cart as $item)
                        <div class="summary-item">
                            <div class="summary-img">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                                @else
                                    <i class="bi bi-laptop" style="font-size:1.5rem;color:var(--text-muted);opacity:0.5;"></i>
                                @endif
                            </div>
                            <div class="summary-detail">
                                <div class="summary-name">{{ $item['name'] }}</div>
                                <div class="summary-qty">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                            </div>
                            <div class="summary-price">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="summary-row">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Biaya Pengiriman</span>
                        <span style="color:#4ade80;">Gratis</span>
                    </div>

                    <div class="summary-total">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn-checkout" id="btnSubmit">
                        <i class="bi bi-shield-lock"></i> Bayar Sekarang
                    </button>
                    
                    <p style="text-align:center; font-size:0.75rem; color:var(--text-muted); margin-top:16px;">
                        Dengan menekan tombol ini, Anda menyetujui Syarat & Ketentuan kami.
                    </p>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Default location (Jakarta Pusat)
    let defaultLat = -6.175110;
    let defaultLng = 106.827152;
    let zoomLevel  = 13;

    const map = L.map('map').setView([defaultLat, defaultLng], zoomLevel);

    // Dark theme maps layer (CartoDB Dark Matter)
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 20
    }).addTo(map);

    // Check if browser supports geolocation to get user's current location
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            defaultLat = position.coords.latitude;
            defaultLng = position.coords.longitude;
            map.setView([defaultLat, defaultLng], 15);
            updateMarker(defaultLat, defaultLng);
        });
    }

    // Initialize marker
    let marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);
    updateInputs(defaultLat, defaultLng);

    // Event when marker is dragged
    marker.on('dragend', function(e) {
        let position = marker.getLatLng();
        updateInputs(position.lat, position.lng);
    });

    // Event when map is clicked
    map.on('click', function(e) {
        let position = e.latlng;
        marker.setLatLng(position);
        updateInputs(position.lat, position.lng);
    });

    function updateMarker(lat, lng) {
        marker.setLatLng([lat, lng]);
        updateInputs(lat, lng);
    }

    function updateInputs(lat, lng) {
        document.getElementById('latInput').value = lat;
        document.getElementById('lngInput').value = lng;
    }

    // Form submission animation
    document.getElementById('checkoutForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';
        btn.style.opacity = '0.7';
        btn.disabled = true;
    });
});
</script>
@endpush
