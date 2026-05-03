@extends('layouts.admin')

@section('page_title', 'Product Management')
@section('page_desc', 'Add, edit, and manage all products in your catalog')

@section('content')

{{-- PAGE ACTIONS --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;animation:fadeUp 0.5s var(--transition);">
    <div style="display:flex;align-items:center;gap:12px;">
        <input type="text" placeholder="Search products..." style="background:var(--surface);border:1px solid var(--border);color:var(--white);padding:10px 14px;border-radius:8px;width:250px;font-family:'DM Sans',sans-serif;font-size:0.85rem;">
        <button style="background:none;border:1px solid var(--border);color:var(--muted);padding:10px 14px;border-radius:8px;font-size:0.85rem;cursor:pointer;font-family:'DM Sans',sans-serif;">
            <i class="bi bi-sliders"></i> Filter
        </button>
    </div>
    <button style="background:var(--gold);color:var(--black);padding:11px 18px;border:none;border-radius:8px;font-family:'Manrope',sans-serif;font-weight:700;font-size:0.85rem;cursor:pointer;display:flex;align-items:center;gap:8px;">
        <i class="bi bi-plus-circle"></i> Add New Product
    </button>
</div>

{{-- PRODUCTS GRID --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:32px;">
    @foreach($products as $product)
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden;transition:border-color 0.25s;animation:fadeUp 0.5s var(--transition);" onmouseover="this.style.borderColor='rgba(212,168,67,0.3)'" onmouseout="this.style.borderColor='var(--border)'">
            {{-- Product Image --}}
            <div style="background:var(--deep);height:180px;display:flex;align-items:center;justify-content:center;border-bottom:1px solid var(--border);">
                <i class="bi bi-image" style="font-size:3rem;color:var(--muted);opacity:0.3;"></i>
            </div>

            {{-- Product Info --}}
            <div style="padding:16px;">
                <p style="font-size:0.75rem;color:var(--muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.08em;font-weight:700;">{{ $product['category'] }}</p>
                <h3 style="font-size:0.95rem;font-weight:700;margin-bottom:8px;color:var(--white);">{{ $product['name'] }}</h3>

                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-top:1px solid rgba(255,255,255,0.04);border-bottom:1px solid rgba(255,255,255,0.04);margin-bottom:12px;">
                    <div>
                        <p style="font-size:0.72rem;color:var(--muted);margin-bottom:2px;">Price</p>
                        <p style="font-size:0.95rem;font-weight:700;color:var(--gold);">{{ $product['price'] }}</p>
                    </div>
                    <div style="text-align:right;">
                        <p style="font-size:0.72rem;color:var(--muted);margin-bottom:2px;">Stock</p>
                        <p style="font-size:0.95rem;font-weight:700;color:var(--white);">{{ $product['stock'] }}</p>
                    </div>
                </div>

                <div style="display:flex;gap:8px;">
                    <button style="flex:1;background:var(--gold-dim);border:1px solid rgba(212,168,67,0.3);color:var(--gold);padding:8px;border-radius:6px;font-size:0.8rem;cursor:pointer;font-family:'DM Sans',sans-serif;font-weight:600;">Edit</button>
                    <button style="flex:1;background:none;border:1px solid var(--border);color:var(--muted);padding:8px;border-radius:6px;font-size:0.8rem;cursor:pointer;font-family:'DM Sans',sans-serif;">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- ADD NEW PRODUCT MODAL / FORM --}}
<div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:32px;animation:fadeUp 0.5s var(--transition) 0.24s both;">
    <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:24px;">Add New Product</h2>

    <form style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

        {{-- Basic Information --}}
        <div>
            <label style="display:block;font-size:0.85rem;font-weight:600;margin-bottom:8px;color:var(--white);">Product Name</label>
            <input type="text" placeholder="e.g. MacBook Pro M3" style="width:100%;background:var(--deep);border:1px solid var(--border);color:var(--white);padding:10px 12px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:0.85rem;">
        </div>

        <div>
            <label style="display:block;font-size:0.85rem;font-weight:600;margin-bottom:8px;color:var(--white);">Category</label>
            <select style="width:100%;background:var(--deep);border:1px solid var(--border);color:var(--white);padding:10px 12px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:0.85rem;">
                <option>Select category</option>
                <option>Apple</option>
                <option>Dell</option>
                <option>Lenovo</option>
                <option>ASUS</option>
            </select>
        </div>

        <div>
            <label style="display:block;font-size:0.85rem;font-weight:600;margin-bottom:8px;color:var(--white);">Price</label>
            <input type="number" placeholder="$1,999" style="width:100%;background:var(--deep);border:1px solid var(--border);color:var(--white);padding:10px 12px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:0.85rem;">
        </div>

        <div>
            <label style="display:block;font-size:0.85rem;font-weight:600;margin-bottom:8px;color:var(--white);">Stock Quantity</label>
            <input type="number" placeholder="0" style="width:100%;background:var(--deep);border:1px solid var(--border);color:var(--white);padding:10px 12px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:0.85rem;">
        </div>

        <div style="grid-column:1/-1;">
            <label style="display:block;font-size:0.85rem;font-weight:600;margin-bottom:8px;color:var(--white);">Description</label>
            <textarea placeholder="Product description..." style="width:100%;background:var(--deep);border:1px solid var(--border);color:var(--white);padding:10px 12px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:0.85rem;min-height:100px;resize:vertical;"></textarea>
        </div>

        <div style="grid-column:1/-1;display:flex;gap:12px;padding-top:12px;border-top:1px solid var(--border);">
            <button type="button" style="flex:1;background:none;border:1px solid var(--border);color:var(--muted);padding:11px;border-radius:8px;font-size:0.85rem;cursor:pointer;font-family:'DM Sans',sans-serif;font-weight:600;">Cancel</button>
            <button type="submit" style="flex:1;background:var(--gold);color:var(--black);border:none;padding:11px;border-radius:8px;font-size:0.85rem;cursor:pointer;font-family:'Manrope',sans-serif;font-weight:700;">Add Product</button>
        </div>
    </form>
</div>

@endsection
