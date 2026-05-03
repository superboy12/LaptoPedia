{{-- Tambahkan perubahan ini pada file layouts/app.blade.php yang sudah ada --}}
{{-- Ganti bagian keranjang di navbar (cari baris "Keranjang") dengan kode di bawah ini: --}}

{{-- ============================================================
     PERUBAHAN 1: Navbar cart icon → link ke halaman keranjang
     Cari blok ini di app.blade.php:

        {{-- Keranjang --}}
        <a href="#" class="nav-icon">
            <i class="bi bi-bag"></i>
            <span class="cart-dot" id="cartCount">0</span>
        </a>

     Ganti dengan:
============================================================ --}}
{{-- Keranjang --}}
<a href="{{ route('cart.index') }}" class="nav-icon">
    <i class="bi bi-bag"></i>
    <span class="cart-dot" id="cartCount">{{ collect(session('cart', []))->sum('quantity') }}</span>
</a>

{{-- ============================================================
     PERUBAHAN 2: Dropdown user menu — tambahkan link "Keranjang Saya"
     Cari baris:
        <a href="#" ...> <i class="bi bi-bag"></i> Pesanan Saya </a>
     Tambahkan di atasnya:
============================================================ --}}
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
