@extends('layouts.app')

@push('styles')
<style>
/* ── CATALOG PAGE ── */
.catalog-page {
    padding-top: 52px;
    min-height: 100vh;
    background: var(--bg);
}

/* CATALOG HEADER */
.catalog-hero {
    background: var(--bg-2);
    border-bottom: 1px solid var(--border);
    padding: 48px 48px 36px;
    transition: background 0.4s ease;
}
.catalog-hero-inner {
    max-width: 1280px;
    margin: 0 auto;
}
.catalog-hero-inner .section-label { margin-bottom: 8px; }
.catalog-hero-inner h1 {
    font-family: 'Manrope', sans-serif;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 900;
    color: var(--text);
    letter-spacing: -0.05em;
    margin-bottom: 24px;
    transition: color 0.4s ease;
}

/* SEARCH BAR */
.catalog-search-row {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.catalog-search-wrap {
    flex: 1;
    min-width: 240px;
    max-width: 560px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 12px 18px;
    transition: border-color 0.25s, background 0.4s ease;
}
.catalog-search-wrap:focus-within {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(212,168,67,0.12);
}
.catalog-search-wrap i { color: var(--text-muted); font-size: 1rem; }
.catalog-search-input {
    flex: 1;
    background: none;
    border: none;
    outline: none;
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
}
.catalog-search-input::placeholder { color: var(--text-muted); }

/* Sort select */
.catalog-sort {
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem;
    padding: 12px 14px;
    border-radius: 12px;
    outline: none;
    cursor: pointer;
    transition: border-color 0.25s, background 0.4s ease;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23999' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 34px;
}
.catalog-sort:focus { border-color: var(--gold); }

/* RESULTS COUNT */
.results-count {
    font-size: 0.82rem;
    color: var(--text-muted);
    font-family: 'DM Sans', sans-serif;
    margin-left: auto;
}
.results-count strong { color: var(--text); font-weight: 700; }

/* CATALOG LAYOUT */
.catalog-body {
    max-width: 1280px;
    margin: 0 auto;
    padding: 36px 48px 80px;
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 36px;
    align-items: start;
}

/* ── FILTER SIDEBAR ── */
.filter-sidebar {
    position: sticky;
    top: 72px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    transition: background 0.4s ease, border-color 0.4s ease;
}
.filter-title {
    font-family: 'Manrope', sans-serif;
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--text-muted);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.filter-clear-btn {
    background: none;
    border: none;
    color: var(--gold);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    padding: 0;
    text-transform: none;
    letter-spacing: 0;
}
.filter-clear-btn:hover { opacity: 0.75; }

.filter-section { margin-bottom: 24px; }
.filter-section-label {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 12px;
    font-family: 'Manrope', sans-serif;
    display: block;
}

/* Category pills */
.cat-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    padding: 9px 12px;
    border-radius: 8px;
    font-size: 0.82rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--text-muted);
    background: none;
    border: none;
    cursor: pointer;
    text-align: left;
    transition: background 0.2s, color 0.2s;
    margin-bottom: 2px;
    text-decoration: none;
}
.cat-pill:hover { background: var(--search-bg); color: var(--text); }
.cat-pill.active {
    background: var(--gold-dim);
    color: var(--gold);
    font-weight: 700;
}
.cat-pill .cat-count {
    margin-left: auto;
    font-size: 0.72rem;
    background: var(--surface-2);
    padding: 2px 7px;
    border-radius: 100px;
    color: var(--text-muted);
}

/* Price range */
.price-range-inputs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}
.price-input {
    background: var(--bg);
    border: 1px solid var(--border);
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.82rem;
    padding: 9px 10px;
    border-radius: 8px;
    outline: none;
    width: 100%;
    transition: border-color 0.25s, background 0.4s ease;
}
.price-input:focus { border-color: var(--gold); }
.price-input::placeholder { color: var(--text-muted); }

/* Filter apply button */
.btn-apply-filter {
    width: 100%;
    background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
    color: #000;
    border: none;
    font-family: 'Manrope', sans-serif;
    font-weight: 800;
    font-size: 0.85rem;
    padding: 12px;
    border-radius: 10px;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}
.btn-apply-filter:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(212,168,67,0.3);
}

.filter-divider {
    height: 1px;
    background: var(--border);
    margin: 16px 0;
}

/* ── PRODUCT GRID ── */
.products-main { min-height: 400px; }

.products-catalog-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 40px;
}

/* PRODUCT CARD — Clean Dashboard Style */
.pcat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.3s cubic-bezier(0.2,0.8,0.2,1), box-shadow 0.3s ease, border-color 0.3s ease;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    animation: fadeUpCard 0.5s cubic-bezier(0.2,0.8,0.2,1) both;
}
.pcat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 48px rgba(0,0,0,0.18);
    border-color: rgba(212,168,67,0.35);
}

@keyframes fadeUpCard {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}
.pcat-card:nth-child(1) { animation-delay: 0.05s; }
.pcat-card:nth-child(2) { animation-delay: 0.10s; }
.pcat-card:nth-child(3) { animation-delay: 0.15s; }
.pcat-card:nth-child(4) { animation-delay: 0.20s; }
.pcat-card:nth-child(5) { animation-delay: 0.25s; }
.pcat-card:nth-child(6) { animation-delay: 0.30s; }

.pcat-img-wrap {
    background: var(--surface-2);
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    border-bottom: 1px solid var(--border);
    overflow: hidden;
    transition: background 0.4s ease;
}
.pcat-img-wrap img {
    max-height: 140px;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.5s cubic-bezier(0.2,0.8,0.2,1);
}
.pcat-card:hover .pcat-img-wrap img { transform: scale(1.08) translateY(-4px); }
.pcat-img-placeholder {
    font-size: 3.5rem;
    color: var(--text-muted);
    opacity: 0.2;
}

.pcat-body { padding: 18px; flex: 1; display: flex; flex-direction: column; }

.pcat-category {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--gold);
    margin-bottom: 6px;
    font-family: 'DM Sans', sans-serif;
}

.pcat-name {
    font-family: 'Manrope', sans-serif;
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.02em;
    margin-bottom: 8px;
    line-height: 1.3;
    transition: color 0.4s ease;
}

.pcat-desc {
    font-size: 0.78rem;
    color: var(--text-muted);
    line-height: 1.6;
    font-weight: 300;
    flex: 1;
    margin-bottom: 16px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.4s ease;
}

.pcat-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding-top: 14px;
    border-top: 1px solid var(--border);
}

.pcat-price {
    font-family: 'Manrope', sans-serif;
    font-size: 1.05rem;
    font-weight: 900;
    color: var(--text);
    letter-spacing: -0.03em;
    transition: color 0.4s ease;
}

.pcat-stock {
    font-size: 0.7rem;
    color: var(--text-muted);
    font-family: 'DM Sans', sans-serif;
    margin-top: 2px;
}
.pcat-stock.low { color: #fb923c; }
.pcat-stock.out { color: #f87171; }

.btn-pcat-detail {
    background: var(--text);
    color: var(--bg);
    border: none;
    font-family: 'Manrope', sans-serif;
    font-size: 0.78rem;
    font-weight: 800;
    padding: 9px 16px;
    border-radius: 100px;
    cursor: pointer;
    transition: transform 0.2s, opacity 0.2s;
    white-space: nowrap;
}
.btn-pcat-detail:hover { opacity: 0.85; transform: translateY(-1px); }

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 80px 24px;
    color: var(--text-muted);
}
.empty-state i { font-size: 4rem; opacity: 0.2; margin-bottom: 20px; display: block; }
.empty-state h3 {
    font-family: 'Manrope', sans-serif;
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--text);
    margin-bottom: 8px;
    letter-spacing: -0.02em;
}
.empty-state p { font-size: 0.88rem; }

/* PAGINATION */
.pagination-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.pagination-wrap .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    border-radius: 8px;
    font-size: 0.82rem;
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    color: var(--text-muted);
    border: 1px solid var(--border);
    background: var(--surface);
    text-decoration: none;
    transition: all 0.2s;
}
.pagination-wrap .page-link:hover { border-color: var(--gold); color: var(--gold); }
.pagination-wrap .page-link.active {
    background: var(--gold-dim);
    border-color: rgba(212,168,67,0.4);
    color: var(--gold);
    font-weight: 800;
}
.pagination-wrap .page-link.disabled { opacity: 0.35; pointer-events: none; }

/* RESPONSIVE */
@media (max-width: 1100px) {
    .products-catalog-grid { grid-template-columns: repeat(2, 1fr); }
    .catalog-body { grid-template-columns: 200px 1fr; gap: 24px; padding: 28px 24px 60px; }
    .catalog-hero { padding: 36px 24px 28px; }
}
@media (max-width: 768px) {
    .catalog-body { grid-template-columns: 1fr; }
    .filter-sidebar { position: static; }
    .products-catalog-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
    .catalog-hero { padding: 28px 16px 20px; }
}
@media (max-width: 520px) {
    .products-catalog-grid { grid-template-columns: 1fr; }
    .catalog-body { padding: 20px 16px 60px; }
    .results-count { display: none; }
}
</style>
@endpush

@section('content')
<div class="catalog-page">

    {{-- CATALOG HERO / SEARCH BAR --}}
    <div class="catalog-hero">
        <div class="catalog-hero-inner">
            <span class="section-label">Katalog Lengkap</span>
            <h1>Temukan Laptop<br>Impian Anda</h1>

            <form method="GET" action="{{ route('products.index') }}" id="catalogForm">
                <div class="catalog-search-row">
                    {{-- Search Input --}}
                    <div class="catalog-search-wrap">
                        <i class="bi bi-search"></i>
                        <input
                            type="text"
                            name="search"
                            class="catalog-search-input"
                            placeholder="Cari merek, spesifikasi, nama laptop..."
                            value="{{ request('search') }}"
                            autocomplete="off"
                            id="searchInput"
                        >
                        @if(request('search'))
                        <button type="button" onclick="clearSearch()" style="background:none;border:none;color:var(--text-muted);cursor:pointer;padding:0;font-size:0.9rem;display:flex;align-items:center;">
                            <i class="bi bi-x-circle"></i>
                        </button>
                        @endif
                    </div>

                    {{-- Sort --}}
                    <select name="sort" class="catalog-sort" onchange="this.form.submit()">
                        <option value="latest"     {{ request('sort','latest') === 'latest'     ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc"  {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>Harga: Terendah</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga: Tertinggi</option>
                        <option value="name"       {{ request('sort') === 'name'       ? 'selected' : '' }}>Nama A–Z</option>
                    </select>

                    {{-- Carry hidden filters when re-sorting --}}
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('min_price'))
                        <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                    @endif
                    @if(request('max_price'))
                        <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                    @endif

                    {{-- Results count --}}
                    <span class="results-count">
                        Menampilkan <strong>{{ $products->total() }}</strong> produk
                    </span>
                </div>
            </form>
        </div>
    </div>

    {{-- BODY: sidebar + grid --}}
    <div class="catalog-body">

        {{-- ── FILTER SIDEBAR ── --}}
        <aside class="filter-sidebar">
            <form method="GET" action="{{ route('products.index') }}" id="filterForm">

                {{-- Preserve search & sort --}}
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                <div class="filter-title">
                    Filter
                    @if(request()->hasAny(['category','min_price','max_price']))
                        <a href="{{ route('products.index', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}" class="filter-clear-btn">Reset</a>
                    @endif
                </div>

                {{-- Category Filter --}}
                <div class="filter-section">
                    <span class="filter-section-label">Kategori</span>
                    <input type="hidden" name="category" id="categoryInput" value="{{ request('category', 'all') }}">

                    <a href="javascript:void(0)"
                       class="cat-pill {{ !request('category') || request('category') === 'all' ? 'active' : '' }}"
                       onclick="setCategory('all')">
                        <i class="bi bi-grid-3x3-gap" style="font-size:0.85rem;"></i>
                        Semua
                        <span class="cat-count">{{ $products->total() }}</span>
                    </a>

                    @foreach($categories as $cat)
                    <a href="javascript:void(0)"
                       class="cat-pill {{ request('category') === $cat->slug ? 'active' : '' }}"
                       onclick="setCategory('{{ $cat->slug }}')">
                        <i class="bi bi-laptop" style="font-size:0.85rem;"></i>
                        {{ $cat->name }}
                    </a>
                    @endforeach
                </div>

                <div class="filter-divider"></div>

                {{-- Price Range Filter --}}
                <div class="filter-section">
                    <span class="filter-section-label">Rentang Harga (Rp)</span>
                    <div class="price-range-inputs">
                        <input
                            type="number"
                            name="min_price"
                            class="price-input"
                            placeholder="Min"
                            value="{{ request('min_price') }}"
                            min="0"
                            step="500000"
                        >
                        <input
                            type="number"
                            name="max_price"
                            class="price-input"
                            placeholder="Max"
                            value="{{ request('max_price') }}"
                            min="0"
                            step="500000"
                        >
                    </div>

                    {{-- Price shortcut chips --}}
                    <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:10px;">
                        @php
                            $priceRanges = [
                                ['label'=>'< 10 Jt',  'min'=>0,        'max'=>10000000],
                                ['label'=>'10–20 Jt', 'min'=>10000000, 'max'=>20000000],
                                ['label'=>'20–30 Jt', 'min'=>20000000, 'max'=>30000000],
                                ['label'=>'> 30 Jt',  'min'=>30000000, 'max'=>0],
                            ];
                        @endphp
                        @foreach($priceRanges as $range)
                        <button type="button"
                            class="price-chip"
                            onclick="setPriceRange({{ $range['min'] }}, {{ $range['max'] }})"
                            style="
                                background:var(--surface-2);
                                border:1px solid var(--border);
                                color:var(--text-muted);
                                font-size:0.7rem;
                                font-family:'DM Sans',sans-serif;
                                font-weight:600;
                                padding:4px 10px;
                                border-radius:100px;
                                cursor:pointer;
                                transition:all 0.2s;
                            "
                            onmouseover="this.style.borderColor='rgba(212,168,67,0.4)';this.style.color='var(--gold)';"
                            onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-muted)';"
                        >{{ $range['label'] }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="filter-divider"></div>

                <button type="submit" class="btn-apply-filter">
                    <i class="bi bi-funnel"></i> Terapkan Filter
                </button>

            </form>
        </aside>

        {{-- ── PRODUCT GRID ── --}}
        <div class="products-main">

            @if($products->count() > 0)
                <div class="products-catalog-grid">
                    @foreach($products as $product)
                    <div class="pcat-card" onclick="window.location='{{ route('product.detail', $product->slug) }}'">

                        {{-- Image --}}
                        <div class="pcat-img-wrap">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <i class="bi bi-laptop pcat-img-placeholder"></i>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="pcat-body">
                            <div class="pcat-category">{{ $product->category->name ?? '—' }}</div>
                            <div class="pcat-name">{{ $product->name }}</div>
                            <div class="pcat-desc">{{ $product->description }}</div>

                            <div class="pcat-footer">
                                <div>
                                    <div class="pcat-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    @if($product->stock > 10)
                                        <div class="pcat-stock">Stok: {{ $product->stock }}</div>
                                    @elseif($product->stock > 0)
                                        <div class="pcat-stock low">Stok Terbatas: {{ $product->stock }}</div>
                                    @else
                                        <div class="pcat-stock out">Habis</div>
                                    @endif
                                </div>
                                <a href="{{ route('product.detail', $product->slug) }}" class="btn-pcat-detail" onclick="event.stopPropagation()">
                                    Detail <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                @if($products->hasPages())
                <div class="pagination-wrap">
                    {{-- Previous --}}
                    @if($products->onFirstPage())
                        <span class="page-link disabled"><i class="bi bi-chevron-left"></i></span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="page-link"><i class="bi bi-chevron-left"></i></a>
                    @endif

                    {{-- Pages --}}
                    @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if($page == $products->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="page-link"><i class="bi bi-chevron-right"></i></a>
                    @else
                        <span class="page-link disabled"><i class="bi bi-chevron-right"></i></span>
                    @endif
                </div>
                @endif

            @else
                {{-- EMPTY STATE --}}
                <div class="empty-state">
                    <i class="bi bi-search"></i>
                    <h3>Produk Tidak Ditemukan</h3>
                    <p>Coba ubah kata kunci atau hapus filter yang aktif.</p>
                    <a href="{{ route('products.index') }}" style="display:inline-flex;align-items:center;gap:6px;margin-top:24px;padding:10px 22px;background:var(--gold-dim);border:1px solid rgba(212,168,67,0.3);color:var(--gold);border-radius:100px;font-size:0.85rem;font-weight:700;font-family:'Manrope',sans-serif;text-decoration:none;transition:background 0.2s;">
                        <i class="bi bi-x-circle"></i> Reset Filter
                    </a>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Set category filter & submit
function setCategory(slug) {
    document.getElementById('categoryInput').value = slug;
    // Update active pill UI
    document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
    event.currentTarget.classList.add('active');
    document.getElementById('filterForm').submit();
}

// Set price range shortcut
function setPriceRange(min, max) {
    document.querySelector('input[name="min_price"]').value = min > 0 ? min : '';
    document.querySelector('input[name="max_price"]').value = max > 0 ? max : '';
}

// Clear search input
function clearSearch() {
    document.getElementById('searchInput').value = '';
    document.getElementById('catalogForm').submit();
}

// Live search with debounce
let searchTimer;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        document.getElementById('catalogForm').submit();
    }, 500);
});
</script>
@endpush
