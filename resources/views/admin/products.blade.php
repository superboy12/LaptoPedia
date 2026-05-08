@extends('layouts.admin')

@section('page_title', 'Product Management')
@section('page_desc', 'Tambah, edit, dan kelola semua produk di katalog Anda')

@push('styles')
<style>
/* Modal overlay */
.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.7);
    backdrop-filter: blur(4px);
    z-index: 1000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.modal-overlay.open { display: flex; }

.modal-box {
    background: var(--deep);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 32px;
    width: 100%;
    max-width: 640px;
    max-height: 90vh;
    overflow-y: auto;
    animation: slideUp 0.3s cubic-bezier(0.2,0.8,0.2,1);
}
.modal-box-small {
    max-width: 480px;
}

@keyframes slideUp {
    from { opacity:0; transform: translateY(20px) scale(0.97); }
    to   { opacity:1; transform: translateY(0) scale(1); }
}

.modal-title {
    font-family: 'Manrope', sans-serif;
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--white);
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Form inputs */
.f-group { margin-bottom: 18px; }
.f-label {
    display: block;
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--white);
    margin-bottom: 8px;
    font-family: 'Manrope', sans-serif;
}
.f-label span { color: var(--gold); }
.f-input, .f-select, .f-textarea {
    width: 100%;
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--white);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem;
    padding: 11px 14px;
    border-radius: 10px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.f-input:focus, .f-select:focus, .f-textarea:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(212,168,67,0.1);
}
.f-input::placeholder, .f-textarea::placeholder { color: var(--muted); }
.f-select option { background: #1a1a1a; }
.f-textarea { min-height: 100px; resize: vertical; }

.f-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

/* Image upload zone */
.img-upload-zone {
    border: 2px dashed var(--border);
    border-radius: 10px;
    padding: 24px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
}
.img-upload-zone:hover { border-color: var(--gold); background: var(--gold-dim); }
.img-upload-zone.has-file { border-color: rgba(34,197,94,0.4); background: rgba(34,197,94,0.06); }

/* Product grid */
.prod-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 18px;
    margin-bottom: 28px;
}

.prod-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    transition: border-color 0.25s, transform 0.25s, box-shadow 0.25s;
    animation: fadeUp 0.4s var(--transition) both;
}
.prod-card:hover {
    border-color: rgba(212,168,67,0.35);
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.25);
}

.prod-img {
    background: var(--deep);
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid var(--border);
    overflow: hidden;
}
.prod-img img { max-height: 130px; max-width: 100%; object-fit: contain; }
.prod-img i { font-size: 3rem; color: var(--muted); opacity: 0.3; }

.prod-info { padding: 14px; }
.prod-cat  { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gold); margin-bottom: 4px; }
.prod-name { font-size: 0.9rem; font-weight: 700; color: var(--white); margin-bottom: 10px; line-height: 1.3; }
.prod-meta { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 12px; }
.prod-price { font-size: 0.9rem; font-weight: 800; color: var(--gold); }
.prod-stock { font-size: 0.75rem; color: var(--muted); }

.prod-actions { display: flex; gap: 8px; }
.btn-edit {
    flex: 1;
    background: var(--gold-dim);
    border: 1px solid rgba(212,168,67,0.3);
    color: var(--gold);
    padding: 8px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: background 0.2s;
}
.btn-edit:hover { background: rgba(212,168,67,0.2); }
.btn-del {
    background: none;
    border: 1px solid var(--border);
    color: var(--muted);
    padding: 8px 10px;
    border-radius: 8px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-del:hover { border-color: rgba(239,68,68,0.4); color: #f87171; background: rgba(239,68,68,0.07); }

/* Search bar */
.search-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 10px 14px;
    flex: 1; max-width: 320px;
    transition: border-color 0.2s;
}
.search-bar:focus-within { border-color: var(--gold); }
.search-bar input {
    background: none; border: none; outline: none;
    color: var(--white); font-family: 'DM Sans', sans-serif; font-size: 0.85rem;
    width: 100%;
}
.search-bar input::placeholder { color: var(--muted); }
.search-bar i { color: var(--muted); font-size: 0.9rem; }

/* Empty state */
.empty-products {
    text-align: center;
    padding: 80px 20px;
    color: var(--muted);
}
.empty-products i { font-size: 4rem; opacity: 0.15; display: block; margin-bottom: 16px; }

/* Preview img in form */
#imgPreview, #editImgPreview { max-height: 100px; max-width: 100%; object-fit: contain; border-radius: 8px; margin-top: 10px; display: none; }

/* Category badge & management */
.category-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 12px;
}

.categories-container {
    background: var(--surface);
    border-radius: 14px;
    padding: 20px;
    margin-bottom: 28px;
    border: 1px solid var(--border);
}

.categories-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 12px;
}

.category-badge {
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--border);
    border-radius: 100px;
    padding: 6px 14px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.2s;
}
.category-badge:hover {
    border-color: var(--gold);
    background: rgba(212,168,67,0.1);
}
.category-badge .cat-name {
    color: var(--white);
    font-size: 0.8rem;
}
.category-badge .cat-edit {
    color: var(--gold);
    cursor: pointer;
    font-size: 0.75rem;
}
.category-badge .cat-delete {
    color: var(--muted);
    cursor: pointer;
    font-size: 0.75rem;
}
.category-badge .cat-delete:hover { color: #f87171; }

.btn-category {
    background: rgba(212,168,67,0.15);
    border: 1px solid rgba(212,168,67,0.3);
    color: var(--gold);
    padding: 8px 18px;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-category:hover {
    background: rgba(212,168,67,0.25);
}
</style>
@endpush

@section('content')

{{-- SUCCESS ALERT --}}
@if(session('success'))
<div style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.25);color:#4ade80;padding:14px 18px;border-radius:10px;margin-bottom:24px;display:flex;align-items:center;gap:10px;animation:fadeUp 0.3s var(--transition);">
    <i class="bi bi-check-circle"></i> {{ session('success') }}
</div>
@endif

{{-- CATEGORY MANAGEMENT SECTION --}}
<div class="categories-container">
    <div class="category-header">
        <h4 style="font-family:'Manrope',sans-serif;font-size:0.9rem;color:var(--gold);margin:0;">
            <i class="bi bi-tags"></i> Kelola Kategori
        </h4>
        <button onclick="openModal('categoryModal')" class="btn-category">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </button>
    </div>
    
    <div class="categories-grid">
        @forelse($categories as $cat)
        <div class="category-badge">
            <span class="cat-name">{{ $cat->name }}</span>
            <i class="bi bi-pencil cat-edit" onclick="openEditCategory({{ $cat->id }}, '{{ $cat->name }}')"></i>
            <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}" style="display:inline;" onsubmit="return confirm('Hapus kategori {{ $cat->name }}? Produk dalam kategori ini akan kehilangan kategori.');">
                @csrf @method('DELETE')
                <i class="bi bi-x-lg cat-delete" onclick="this.closest('form').submit()"></i>
            </form>
        </div>
        @empty
        <div style="color:var(--muted);font-size:0.8rem;">Belum ada kategori. Klik "Tambah Kategori" untuk membuat.</div>
        @endforelse
    </div>
</div>

{{-- TOP BAR --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;gap:14px;flex-wrap:wrap;animation:fadeUp 0.4s var(--transition);">
    <form method="GET" action="{{ route('admin.products') }}" style="display:flex;align-items:center;gap:10px;">
        <div class="search-bar">
            <i class="bi bi-search"></i>
            <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}" autocomplete="off">
        </div>
        @if(request('search'))
        <a href="{{ route('admin.products') }}" style="color:var(--muted);font-size:0.82rem;">Reset</a>
        @endif
    </form>

    <div style="display:flex;align-items:center;gap:10px;">
        <span style="font-size:0.82rem;color:var(--muted);">
            {{ $products->total() }} produk
        </span>
        <button onclick="openModal('addModal')"
            style="background:var(--gold);color:#000;padding:10px 18px;border:none;border-radius:10px;font-family:'Manrope',sans-serif;font-weight:800;font-size:0.85rem;cursor:pointer;display:flex;align-items:center;gap:8px;transition:opacity 0.2s;"
            onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </button>
    </div>
</div>

{{-- PRODUCT GRID --}}
@if($products->count() > 0)
<div class="prod-grid">
    @foreach($products as $product)
    <div class="prod-card" style="animation-delay: {{ $loop->index * 0.05 }}s;">
        <div class="prod-img">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <i class="bi bi-laptop"></i>
            @endif
        </div>
        <div class="prod-info">
            <div class="prod-cat">{{ $product->category->name ?? '—' }}</div>
            <div class="prod-name">{{ $product->name }}</div>
            <div class="prod-meta">
                <div class="prod-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="prod-stock">Stok: {{ $product->stock }}</div>
            </div>
            <div class="prod-actions">
                <button class="btn-edit" onclick='openEdit(
                    {{ $product->id }},
                    {{ $product->category_id }},
                    {{ json_encode($product->name) }},
                    {{ json_encode($product->description) }},
                    {{ $product->price }},
                    {{ $product->stock }},
                    {{ json_encode($product->image ? asset("storage/" . $product->image) : null) }},
                    {{ json_encode($product->variations) }},
                    {{ json_encode($product->spec_title) }},
                    {{ json_encode($product->spec_description) }},
                    {{ json_encode($product->highlights) }}
                )'>
                    <i class="bi bi-pencil"></i> Edit
                </button>
                <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}"
                      onsubmit="return confirm('Hapus produk ini?');" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-del"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Pagination --}}
@if($products->hasPages())
<div style="display:flex;align-items:center;justify-content:center;gap:6px;margin-bottom:16px;">
    @if($products->onFirstPage())
        <span style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:var(--muted);font-size:0.82rem;opacity:0.4;">← Prev</span>
    @else
        <a href="{{ $products->previousPageUrl() }}" style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:var(--muted);font-size:0.82rem;text-decoration:none;transition:border-color 0.2s;" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">← Prev</a>
    @endif

    @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
        @if($page == $products->currentPage())
            <span style="padding:6px 12px;border:1px solid rgba(212,168,67,0.4);border-radius:8px;background:var(--gold-dim);color:var(--gold);font-weight:700;font-size:0.82rem;">{{ $page }}</span>
        @else
            <a href="{{ $url }}" style="padding:6px 12px;border:1px solid var(--border);border-radius:8px;color:var(--muted);font-size:0.82rem;text-decoration:none;transition:border-color 0.2s;" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">{{ $page }}</a>
        @endif
    @endforeach

    @if($products->hasMorePages())
        <a href="{{ $products->nextPageUrl() }}" style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:var(--muted);font-size:0.82rem;text-decoration:none;transition:border-color 0.2s;" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">Next →</a>
    @else
        <span style="padding:6px 14px;border:1px solid var(--border);border-radius:8px;color:var(--muted);font-size:0.82rem;opacity:0.4;">Next →</span>
    @endif
</div>
@endif

@else
<div class="empty-products">
    <i class="bi bi-box"></i>
    <h3 style="font-family:'Manrope',sans-serif;font-size:1.2rem;font-weight:800;color:var(--white);margin-bottom:8px;">Belum ada produk</h3>
    <p style="font-size:0.85rem;">Klik "Tambah Produk" untuk menambahkan produk pertama Anda.</p>
</div>
@endif


{{-- ═══════════ MODAL TAMBAH KATEGORI ═══════════ --}}
<div class="modal-overlay" id="categoryModal" onclick="closeOnBg(event,'categoryModal')">
    <div class="modal-box modal-box-small">
        <div class="modal-title">
            <span><i class="bi bi-tag" style="color:var(--gold);margin-right:8px;"></i>Tambah Kategori</span>
            <button onclick="closeModal('categoryModal')" style="background:none;border:none;color:var(--muted);cursor:pointer;font-size:1.1rem;"><i class="bi bi-x-lg"></i></button>
        </div>

        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="f-group">
                <label class="f-label">Nama Kategori <span>*</span></label>
                <input type="text" name="name" class="f-input" placeholder="cth: Laptop, Aksesoris, Gaming" required>
            </div>

            <div style="display:flex;gap:10px;padding-top:16px;border-top:1px solid var(--border);">
                <button type="button" onclick="closeModal('categoryModal')"
                    style="flex:1;background:none;border:1px solid var(--border);color:var(--muted);padding:12px;border-radius:10px;cursor:pointer;font-family:'DM Sans',sans-serif;font-weight:600;">
                    Batal
                </button>
                <button type="submit"
                    style="flex:2;background:var(--gold);color:#000;border:none;padding:12px;border-radius:10px;cursor:pointer;font-family:'Manrope',sans-serif;font-weight:800;font-size:0.9rem;transition:opacity 0.2s;"
                    onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    <i class="bi bi-check-lg"></i> Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════ MODAL EDIT KATEGORI ═══════════ --}}
<div class="modal-overlay" id="editCategoryModal" onclick="closeOnBg(event,'editCategoryModal')">
    <div class="modal-box modal-box-small">
        <div class="modal-title">
            <span><i class="bi bi-pencil" style="color:var(--gold);margin-right:8px;"></i>Edit Kategori</span>
            <button onclick="closeModal('editCategoryModal')" style="background:none;border:none;color:var(--muted);cursor:pointer;font-size:1.1rem;"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="editCategoryForm" method="POST">
            @csrf
            @method('PUT')
            <div class="f-group">
                <label class="f-label">Nama Kategori <span>*</span></label>
                <input type="text" name="name" id="editCategoryName" class="f-input" required>
            </div>

            <div style="display:flex;gap:10px;padding-top:16px;border-top:1px solid var(--border);">
                <button type="button" onclick="closeModal('editCategoryModal')"
                    style="flex:1;background:none;border:1px solid var(--border);color:var(--muted);padding:12px;border-radius:10px;cursor:pointer;font-family:'DM Sans',sans-serif;font-weight:600;">
                    Batal
                </button>
                <button type="submit"
                    style="flex:2;background:var(--gold);color:#000;border:none;padding:12px;border-radius:10px;cursor:pointer;font-family:'Manrope',sans-serif;font-weight:800;font-size:0.9rem;transition:opacity 0.2s;"
                    onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    <i class="bi bi-check-lg"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════ MODAL TAMBAH PRODUK ═══════════ --}}
<div class="modal-overlay" id="addModal" onclick="closeOnBg(event,'addModal')">
    <div class="modal-box">
        <div class="modal-title">
            <span><i class="bi bi-plus-circle" style="color:var(--gold);margin-right:8px;"></i>Tambah Produk Baru</span>
            <button onclick="closeModal('addModal')" style="background:none;border:none;color:var(--muted);cursor:pointer;font-size:1.1rem;"><i class="bi bi-x-lg"></i></button>
        </div>

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="f-row">
                <div class="f-group">
                    <label class="f-label">Nama Produk <span>*</span></label>
                    <input type="text" name="name" class="f-input" placeholder="cth: MacBook Pro M3" required>
                </div>
                <div class="f-group">
                    <label class="f-label">Kategori <span>*</span></label>
                    <select name="category_id" class="f-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="f-row">
                <div class="f-group">
                    <label class="f-label">Harga (Rp) <span>*</span></label>
                    <input type="number" name="price" class="f-input" placeholder="28999000" min="0" required>
                </div>
                <div class="f-group">
                    <label class="f-label">Stok <span>*</span></label>
                    <input type="number" name="stock" class="f-input" placeholder="10" min="0" required>
                </div>
            </div>

            <div class="f-group">
                <label class="f-label">Deskripsi / Spesifikasi <span>*</span></label>
                <textarea name="description" class="f-textarea" placeholder="M3 Pro chip · 18GB RAM · 512GB SSD · Liquid Retina XDR..." required></textarea>
            </div>

            <!-- Spec Highlights Section -->
            <div style="margin: 20px 0; padding: 15px; background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid var(--border);">
                <h4 style="margin-bottom: 15px; font-family: 'Manrope', sans-serif; font-size: 0.95rem; color: var(--gold); border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                    <i class="bi bi-star-fill"></i> Spec Highlights (Max 4)
                </h4>
                <div class="f-row" style="margin-bottom: 12px;">
                    <div class="f-group">
                        <label class="f-label">Judul Highlight Section</label>
                        <input type="text" name="spec_title" class="f-input" placeholder="cth: Mendobrak Batas.">
                    </div>
                </div>
                <div class="f-group" style="margin-bottom: 15px;">
                    <label class="f-label">Deskripsi Highlight Section</label>
                    <textarea name="spec_description" class="f-textarea" style="height: 60px;" placeholder="Arsitektur kustom yang mengoptimalkan..."></textarea>
                </div>

                <div id="addHighlightsList">
                    @for($i=0; $i<4; $i++)
                    <div style="padding: 10px; background: rgba(0,0,0,0.2); border-radius: 8px; margin-bottom: 10px; border: 1px solid rgba(255,255,255,0.05);">
                        <div class="f-row" style="margin-bottom: 8px;">
                            <input type="text" name="highlights[{{$i}}][label]" class="f-input" placeholder="Label (cth: PROCESSOR)">
                            <input type="text" name="highlights[{{$i}}][title]" class="f-input" placeholder="Title (cth: Pro-Class)">
                        </div>
                        <input type="text" name="highlights[{{$i}}][description]" class="f-input" placeholder="Deskripsi Singkat">
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Variasi Kapasitas -->
            <div class="f-group">
                <label class="f-label">Kapasitas & Harga Spesifik <span style="color:var(--muted);font-weight:400;">(Opsional)</span></label>
                <div id="addCapacitiesList">
                    <div class="f-row" style="margin-bottom:8px;">
                        <input type="text" name="capacities[0][value]" class="f-input" placeholder="cth: 256GB | 12GB">
                        <input type="number" name="capacities[0][price]" class="f-input" placeholder="Harga Total (Rp)" min="0">
                    </div>
                </div>
                <button type="button" onclick="addCapacityRow('addCapacitiesList')" style="background:none;border:none;color:var(--gold);font-size:0.8rem;cursor:pointer;padding:0;margin-top:4px;">+ Tambah Kapasitas</button>
            </div>

            <!-- Variasi Warna -->
            <div class="f-group">
                <label class="f-label">Warna <span style="color:var(--muted);font-weight:400;">(Opsional)</span></label>
                <div id="addColorsList">
                    <div style="display:flex;gap:14px;margin-bottom:8px;">
                        <input type="text" name="colors[0][value]" class="f-input" placeholder="cth: Space Gray" style="flex:1;">
                    </div>
                </div>
                <button type="button" onclick="addColorRow('addColorsList')" style="background:none;border:none;color:var(--gold);font-size:0.8rem;cursor:pointer;padding:0;margin-top:4px;">+ Tambah Warna</button>
            </div>

            <div class="f-group">
                <label class="f-label">Gambar Produk</label>
                <div class="img-upload-zone" id="addUploadZone" onclick="document.getElementById('addImageInput').click()">
                    <i class="bi bi-cloud-upload" style="font-size:2rem;color:var(--muted);display:block;margin-bottom:8px;"></i>
                    <p style="font-size:0.82rem;color:var(--muted);">Klik untuk upload gambar<br><span style="font-size:0.72rem;">JPG, PNG, WEBP · Max 3MB</span></p>
                    <img id="imgPreview" src="" alt="Preview">
                </div>
                <input type="file" id="addImageInput" name="image" accept="image/*" style="display:none;" onchange="previewImg(this,'imgPreview','addUploadZone')">
            </div>

            <div style="display:flex;gap:10px;padding-top:16px;border-top:1px solid var(--border);">
                <button type="button" onclick="closeModal('addModal')"
                    style="flex:1;background:none;border:1px solid var(--border);color:var(--muted);padding:12px;border-radius:10px;cursor:pointer;font-family:'DM Sans',sans-serif;font-weight:600;">
                    Batal
                </button>
                <button type="submit"
                    style="flex:2;background:var(--gold);color:#000;border:none;padding:12px;border-radius:10px;cursor:pointer;font-family:'Manrope',sans-serif;font-weight:800;font-size:0.9rem;transition:opacity 0.2s;"
                    onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    <i class="bi bi-check-lg"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════ MODAL EDIT PRODUK ═══════════ --}}
<div class="modal-overlay" id="editModal" onclick="closeOnBg(event,'editModal')">
    <div class="modal-box">
        <div class="modal-title">
            <span><i class="bi bi-pencil" style="color:var(--gold);margin-right:8px;"></i>Edit Produk</span>
            <button onclick="closeModal('editModal')" style="background:none;border:none;color:var(--muted);cursor:pointer;font-size:1.1rem;"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="f-row">
                <div class="f-group">
                    <label class="f-label">Nama Produk <span>*</span></label>
                    <input type="text" name="name" id="editName" class="f-input" required>
                </div>
                <div class="f-group">
                    <label class="f-label">Kategori <span>*</span></label>
                    <select name="category_id" id="editCategory" class="f-select" required>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="f-row">
                <div class="f-group">
                    <label class="f-label">Harga (Rp) <span>*</span></label>
                    <input type="number" name="price" id="editPrice" class="f-input" min="0" required>
                </div>
                <div class="f-group">
                    <label class="f-label">Stok <span>*</span></label>
                    <input type="number" name="stock" id="editStock" class="f-input" min="0" required>
                </div>
            </div>

            <div class="f-group">
                <label class="f-label">Deskripsi / Spesifikasi <span>*</span></label>
                <textarea name="description" id="editDescription" class="f-textarea" required></textarea>
            </div>

            <!-- Spec Highlights Section -->
            <div style="margin: 20px 0; padding: 15px; background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid var(--border);">
                <h4 style="margin-bottom: 15px; font-family: 'Manrope', sans-serif; font-size: 0.95rem; color: var(--gold); border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                    <i class="bi bi-star-fill"></i> Spec Highlights (Max 4)
                </h4>
                <div class="f-row" style="margin-bottom: 12px;">
                    <div class="f-group">
                        <label class="f-label">Judul Highlight Section</label>
                        <input type="text" name="spec_title" id="editSpecTitle" class="f-input" placeholder="cth: Mendobrak Batas.">
                    </div>
                </div>
                <div class="f-group" style="margin-bottom: 15px;">
                    <label class="f-label">Deskripsi Highlight Section</label>
                    <textarea name="spec_description" id="editSpecDescription" class="f-textarea" style="height: 60px;" placeholder="Arsitektur kustom yang mengoptimalkan..."></textarea>
                </div>

                <div id="editHighlightsList">
                    @for($i=0; $i<4; $i++)
                    <div style="padding: 10px; background: rgba(0,0,0,0.2); border-radius: 8px; margin-bottom: 10px; border: 1px solid rgba(255,255,255,0.05);">
                        <div class="f-row" style="margin-bottom: 8px;">
                            <input type="text" name="highlights[{{$i}}][label]" id="editHlLabel{{$i}}" class="f-input" placeholder="Label (cth: PROCESSOR)">
                            <input type="text" name="highlights[{{$i}}][title]" id="editHlTitle{{$i}}" class="f-input" placeholder="Title (cth: Pro-Class)">
                        </div>
                        <input type="text" name="highlights[{{$i}}][description]" id="editHlDesc{{$i}}" class="f-input" placeholder="Deskripsi Singkat">
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Variasi Kapasitas -->
            <div class="f-group">
                <label class="f-label">Kapasitas & Harga Spesifik <span style="color:var(--muted);font-weight:400;">(Opsional)</span></label>
                <div id="editCapacitiesList"></div>
                <button type="button" onclick="addCapacityRow('editCapacitiesList')" style="background:none;border:none;color:var(--gold);font-size:0.8rem;cursor:pointer;padding:0;margin-top:4px;">+ Tambah Kapasitas</button>
            </div>

            <!-- Variasi Warna -->
            <div class="f-group">
                <label class="f-label">Warna <span style="color:var(--muted);font-weight:400;">(Opsional)</span></label>
                <div id="editColorsList"></div>
                <button type="button" onclick="addColorRow('editColorsList')" style="background:none;border:none;color:var(--gold);font-size:0.8rem;cursor:pointer;padding:0;margin-top:4px;">+ Tambah Warna</button>
            </div>

            <div class="f-group">
                <label class="f-label">Ganti Gambar <span style="color:var(--muted);font-weight:400;">(opsional)</span></label>
                <div style="margin-bottom:10px;">
                    <img id="editImgPreview" src="" alt="Current" style="display:none; max-height:80px; border-radius:8px;">
                </div>
                <div class="img-upload-zone" id="editUploadZone" onclick="document.getElementById('editImageInput').click()">
                    <i class="bi bi-cloud-upload" style="font-size:1.5rem;color:var(--muted);display:block;margin-bottom:6px;"></i>
                    <p style="font-size:0.78rem;color:var(--muted);">Klik untuk ganti gambar</p>
                </div>
                <input type="file" id="editImageInput" name="image" accept="image/*" style="display:none;" onchange="previewImg(this,'editUploadZonePreview','editUploadZone')">
                <img id="editUploadZonePreview" src="" alt="Preview" style="display:none;max-height:80px;margin-top:8px;border-radius:8px;">
            </div>

            <div style="display:flex;gap:10px;padding-top:16px;border-top:1px solid var(--border);">
                <button type="button" onclick="closeModal('editModal')"
                    style="flex:1;background:none;border:1px solid var(--border);color:var(--muted);padding:12px;border-radius:10px;cursor:pointer;font-family:'DM Sans',sans-serif;font-weight:600;">
                    Batal
                </button>
                <button type="submit"
                    style="flex:2;background:var(--gold);color:#000;border:none;padding:12px;border-radius:10px;cursor:pointer;font-family:'Manrope',sans-serif;font-weight:800;font-size:0.9rem;transition:opacity 0.2s;"
                    onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    <i class="bi bi-check-lg"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
function closeOnBg(e, id) { if (e.target === document.getElementById(id)) closeModal(id); }

// Preview gambar sebelum upload
function previewImg(input, previewId, zoneId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    const zone = document.getElementById(zoneId);
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        preview.src = e.target.result;
        preview.style.display = 'block';
        if (zone) zone.classList.add('has-file');
    };
    reader.readAsDataURL(file);
}

// Buka modal edit kategori
function openEditCategory(id, name) {
    const form = document.getElementById('editCategoryForm');
    form.action = `/admin/categories/${id}`;
    document.getElementById('editCategoryName').value = name;
    openModal('editCategoryModal');
}

// Buka modal edit produk
let capIndex = 100;
let colIndex = 100;

function openEdit(id, category_id, name, description, price, stock, image, variations, spec_title, spec_description, highlights) {
    const form = document.getElementById('editForm');
    form.action = `/admin/products/${id}`;

    document.getElementById('editName').value = name;
    document.getElementById('editCategory').value = category_id;
    document.getElementById('editPrice').value = price;
    document.getElementById('editStock').value = stock;
    document.getElementById('editDescription').value = description;
    document.getElementById('editSpecTitle').value = spec_title || '';
    document.getElementById('editSpecDescription').value = spec_description || '';

    // Reset highlights
    for(let i=0; i<4; i++) {
        document.getElementById(`editHlLabel${i}`).value = '';
        document.getElementById(`editHlTitle${i}`).value = '';
        document.getElementById(`editHlDesc${i}`).value = '';
    }

    // Fill highlights
    if (highlights && highlights.length > 0) {
        highlights.forEach((hl, i) => {
            if (i < 4) {
                document.getElementById(`editHlLabel${i}`).value = hl.label || '';
                document.getElementById(`editHlTitle${i}`).value = hl.title || '';
                document.getElementById(`editHlDesc${i}`).value = hl.description || '';
            }
        });
    }

    const prevImg = document.getElementById('editImgPreview');
    if (image && image !== 'null') {
        prevImg.src = image;
        prevImg.style.display = 'block';
    } else {
        prevImg.style.display = 'none';
    }

    // Reset upload zone
    document.getElementById('editImageInput').value = '';
    const uploadPrev = document.getElementById('editUploadZonePreview');
    uploadPrev.style.display = 'none';
    document.getElementById('editUploadZone').classList.remove('has-file');

    // Populate Variations
    const editCapList = document.getElementById('editCapacitiesList');
    editCapList.innerHTML = '';
    const editColList = document.getElementById('editColorsList');
    editColList.innerHTML = '';

    capIndex = 100;
    colIndex = 100;

    if (variations && variations.length > 0) {
        variations.forEach(v => {
            if (v.type === 'capacity') {
                const div = document.createElement('div');
                div.className = 'f-row';
                div.style.marginBottom = '8px';
                div.style.position = 'relative';
                div.innerHTML = `
                    <input type="text" name="capacities[${capIndex}][value]" class="f-input" value="${v.value.replace(/"/g, '&quot;')}">
                    <input type="number" name="capacities[${capIndex}][price]" class="f-input" value="${v.price}">
                    <button type="button" onclick="this.parentElement.remove()" style="position:absolute;right:-30px;top:10px;background:none;border:none;color:#ef4444;cursor:pointer;"><i class="bi bi-trash"></i></button>
                `;
                editCapList.appendChild(div);
                capIndex++;
            } else if (v.type === 'color') {
                const div = document.createElement('div');
                div.style.display = 'flex';
                div.style.gap = '14px';
                div.style.marginBottom = '8px';
                div.style.position = 'relative';
                div.innerHTML = `
                    <input type="text" name="colors[${colIndex}][value]" class="f-input" value="${v.value.replace(/"/g, '&quot;')}" style="flex:1;">
                    <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#ef4444;cursor:pointer;"><i class="bi bi-trash"></i></button>
                `;
                editColList.appendChild(div);
                colIndex++;
            }
        });
    }

    openModal('editModal');
}

function addCapacityRow(listId) {
    const list = document.getElementById(listId);
    const div = document.createElement('div');
    div.className = 'f-row';
    div.style.marginBottom = '8px';
    div.style.position = 'relative';
    div.innerHTML = `
        <input type="text" name="capacities[${capIndex}][value]" class="f-input" placeholder="cth: 256GB | 12GB">
        <input type="number" name="capacities[${capIndex}][price]" class="f-input" placeholder="Harga Total (Rp)" min="0">
        <button type="button" onclick="this.parentElement.remove()" style="position:absolute;right:-30px;top:10px;background:none;border:none;color:#ef4444;cursor:pointer;"><i class="bi bi-trash"></i></button>
    `;
    list.appendChild(div);
    capIndex++;
}

function addColorRow(listId) {
    const list = document.getElementById(listId);
    const div = document.createElement('div');
    div.style.display = 'flex';
    div.style.gap = '14px';
    div.style.marginBottom = '8px';
    div.style.position = 'relative';
    div.innerHTML = `
        <input type="text" name="colors[${colIndex}][value]" class="f-input" placeholder="cth: Warna" style="flex:1;">
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#ef4444;cursor:pointer;"><i class="bi bi-trash"></i></button>
    `;
    list.appendChild(div);
    colIndex++;
}

// ESC untuk close modal
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeModal('addModal');
        closeModal('editModal');
        closeModal('categoryModal');
        closeModal('editCategoryModal');
    }
});
</script>
@endpush