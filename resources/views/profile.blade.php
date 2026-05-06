@extends('layouts.app')

@push('styles')
<style>
/* ══════════════════════════════════════════
   PROFILE PAGE — Minimalist Premium
══════════════════════════════════════════ */
.profile-wrap {
    min-height: 100vh;
    background: var(--bg);
    padding-top: 52px;
    transition: background 0.4s ease;
}

/* ── Top Banner ── */
.profile-banner {
    height: 220px;
    background: linear-gradient(135deg,
        #0a0a0a 0%,
        #111 40%,
        rgba(212,168,67,0.08) 100%);
    position: relative;
    overflow: hidden;
}
[data-theme="light"] .profile-banner {
    background: linear-gradient(135deg,
        #f0f0f4 0%,
        #e8e8ef 40%,
        rgba(166,124,0,0.06) 100%);
}
.profile-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(212,168,67,0.06) 1px, transparent 1px);
    background-size: 28px 28px;
}
.profile-banner-glow {
    position: absolute;
    top: -80px; right: -80px;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(212,168,67,0.10) 0%, transparent 65%);
    pointer-events: none;
}

/* ── Profile Header Card ── */
.profile-header-section {
    max-width: 900px;
    margin: -64px auto 0;
    padding: 0 32px;
    position: relative;
    z-index: 2;
}
.profile-header-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 32px 36px 28px;
    display: flex;
    align-items: flex-end;
    gap: 28px;
    box-shadow: 0 16px 48px rgba(0,0,0,0.12);
    transition: background 0.4s ease, border-color 0.4s ease;
}

/* Avatar */
.profile-avatar-ring {
    width: 96px; height: 96px;
    border-radius: 50%;
    background: linear-gradient(135deg, #d4a843, #b8870e);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Manrope', sans-serif;
    font-size: 2rem; font-weight: 900;
    color: #000;
    flex-shrink: 0;
    box-shadow: 0 8px 24px rgba(212,168,67,0.25);
    margin-bottom: -4px;
    letter-spacing: -0.04em;
}

.profile-header-info { flex: 1; }
.profile-header-info h1 {
    font-family: 'Manrope', sans-serif;
    font-size: 1.55rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.04em;
    margin-bottom: 4px;
    transition: color 0.4s ease;
}
.profile-header-info .profile-email {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-bottom: 10px;
    transition: color 0.4s ease;
}
.profile-role-badge {
    display: inline-block;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    background: var(--gold-dim);
    color: var(--gold);
    padding: 3px 10px;
    border-radius: 100px;
}

.profile-header-stats {
    display: flex;
    gap: 32px;
    padding-left: 24px;
    border-left: 1px solid var(--border);
}
.profile-stat-item { text-align: center; }
.profile-stat-num {
    font-family: 'Manrope', sans-serif;
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--text);
    letter-spacing: -0.04em;
    line-height: 1;
    transition: color 0.4s ease;
}
.profile-stat-lbl {
    font-size: 0.7rem;
    color: var(--text-muted);
    margin-top: 4px;
    font-weight: 400;
    transition: color 0.4s ease;
}

/* ── Main Content ── */
.profile-main {
    max-width: 900px;
    margin: 28px auto 80px;
    padding: 0 32px;
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 24px;
    align-items: start;
}

/* Form Card */
.profile-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
    transition: background 0.4s ease, border-color 0.4s ease;
}
.profile-card-head {
    padding: 22px 28px 18px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.profile-card-head h2 {
    font-family: 'Manrope', sans-serif;
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.02em;
    transition: color 0.4s ease;
}
.profile-card-head span {
    font-size: 0.72rem;
    color: var(--text-muted);
    transition: color 0.4s ease;
}
.profile-card-body { padding: 28px; }

/* Form fields */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
}
.form-row.full { grid-template-columns: 1fr; }

.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-label {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: var(--text-muted);
    transition: color 0.4s ease;
}
.form-control {
    background: var(--bg);
    border: 1px solid var(--border);
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.88rem;
    padding: 11px 14px;
    border-radius: 10px;
    outline: none;
    width: 100%;
    transition: border-color 0.2s, background 0.4s ease, color 0.4s ease;
}
.form-control:focus { border-color: var(--gold); }
.form-control::placeholder { color: var(--text-muted); opacity: 0.6; }
.form-control[disabled] {
    opacity: 0.55;
    cursor: not-allowed;
}

.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #d4a843, #b8870e);
    color: #000;
    font-family: 'Manrope', sans-serif;
    font-weight: 700;
    font-size: 0.85rem;
    padding: 12px 28px;
    border-radius: 100px;
    border: none;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    letter-spacing: -0.01em;
}
.btn-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(212,168,67,0.3);
}

/* Sidebar cards */
.sidebar-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
    margin-bottom: 16px;
    transition: background 0.4s ease, border-color 0.4s ease;
}
.sidebar-card-head {
    padding: 18px 22px 14px;
    border-bottom: 1px solid var(--border);
    font-family: 'Manrope', sans-serif;
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.02em;
    transition: color 0.4s ease;
}
.sidebar-card-body { padding: 16px 22px; }

.sidebar-menu-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 10px;
    border-radius: 10px;
    font-size: 0.84rem;
    color: var(--text-muted);
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
    text-decoration: none;
}
.sidebar-menu-item:hover,
.sidebar-menu-item.active {
    background: var(--search-bg);
    color: var(--text);
}
.sidebar-menu-item.active { font-weight: 600; }
.sidebar-menu-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: var(--search-bg);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.88rem;
    flex-shrink: 0;
    transition: background 0.2s;
}
.sidebar-menu-item.active .sidebar-menu-icon,
.sidebar-menu-item:hover .sidebar-menu-icon {
    background: var(--gold-dim);
    color: var(--gold);
}

/* Info list */
.info-list { list-style: none; display: flex; flex-direction: column; gap: 14px; }
.info-list li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.82rem;
    border-bottom: 1px solid var(--border);
    padding-bottom: 12px;
}
.info-list li:last-child { border-bottom: none; padding-bottom: 0; }
.info-list .lbl { color: var(--text-muted); font-weight: 400; transition: color 0.4s; }
.info-list .val { color: var(--text); font-weight: 600; text-align: right; max-width: 55%; word-break: break-word; transition: color 0.4s; }

/* Alert success */
.alert-success {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(16,185,129,0.08);
    border: 1px solid rgba(16,185,129,0.25);
    color: #10b981;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 0.84rem;
    font-weight: 500;
    margin-bottom: 20px;
}

/* Danger zone */
.danger-zone {
    padding: 4px 0 8px;
}
.btn-danger-outline {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    padding: 10px 14px;
    border-radius: 10px;
    background: none;
    border: 1px solid rgba(248,113,113,0.25);
    color: #f87171;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.82rem;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s;
    text-align: left;
}
.btn-danger-outline:hover {
    background: rgba(248,113,113,0.07);
    border-color: rgba(248,113,113,0.4);
}

@media (max-width: 760px) {
    .profile-main { grid-template-columns: 1fr; }
    .profile-header-card { flex-direction: column; align-items: flex-start; }
    .profile-header-stats { border-left: none; border-top: 1px solid var(--border); padding-left: 0; padding-top: 16px; width: 100%; justify-content: space-around; }
    .form-row { grid-template-columns: 1fr; }
    .profile-header-section { padding: 0 20px; }
    .profile-main { padding: 0 20px; }
}
</style>
@endpush

@section('content')
<div class="profile-wrap">

    {{-- Banner --}}
    <div class="profile-banner">
        <div class="profile-banner-glow"></div>
    </div>

    {{-- Profile Header --}}
    <div class="profile-header-section">
        <div class="profile-header-card">
            {{-- Avatar (initials) --}}
            <div class="profile-avatar-ring">
                {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}{{ strtoupper(substr(strstr($user->nama_lengkap, ' '), 1, 1) ?: '') }}
            </div>

            <div class="profile-header-info">
                <h1>{{ $user->nama_lengkap }}</h1>
                <p class="profile-email">{{ $user->email }}</p>
                <span class="profile-role-badge">{{ $user->role }}</span>
            </div>

            <div class="profile-header-stats">
                <div class="profile-stat-item">
                    <div class="profile-stat-num">0</div>
                    <div class="profile-stat-lbl">Pesanan</div>
                </div>
                <div class="profile-stat-item">
                    <div class="profile-stat-num">0</div>
                    <div class="profile-stat-lbl">Ulasan</div>
                </div>
                <div class="profile-stat-item">
                    <div class="profile-stat-num">0</div>
                    <div class="profile-stat-lbl">Favorit</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main content --}}
    <div class="profile-main">

        {{-- Left: Edit Form --}}
        <div>
            <div class="profile-card">
                <div class="profile-card-head">
                    <h2>Informasi Pribadi</h2>
                    <span>Terakhir diperbarui hari ini</span>
                </div>
                <div class="profile-card-body">

                    @if(session('success'))
                    <div class="alert-success">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control"
                                    value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                    placeholder="Nama lengkap Anda">
                                @error('nama_lengkap')
                                    <span style="color:#f87171;font-size:0.75rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="no_telepon" class="form-control"
                                    value="{{ old('no_telepon', $user->no_telepon) }}"
                                    placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <div class="form-row full" style="margin-bottom:16px;">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            </div>
                        </div>

                        <div class="form-row full" style="margin-bottom:24px;">
                            <div class="form-group">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="3"
                                    placeholder="Jl. Contoh No. 1, Kota, Provinsi">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn-save">
                            <i class="bi bi-check-lg"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right: Sidebar --}}
        <div>
            {{-- Quick Menu --}}
            <div class="sidebar-card">
                <div class="sidebar-card-head">Menu Akun</div>
                <div class="sidebar-card-body" style="padding:12px;">
                    <a href="{{ route('profile') }}" class="sidebar-menu-item active">
                        <span class="sidebar-menu-icon"><i class="bi bi-person"></i></span>
                        Profil Saya
                    </a>
                    <a href="{{ route('cart.index') }}" class="sidebar-menu-item">
                        <span class="sidebar-menu-icon"><i class="bi bi-cart3"></i></span>
                        Keranjang Saya
                    </a>
                    <a href="#" class="sidebar-menu-item">
                        <span class="sidebar-menu-icon"><i class="bi bi-bag-check"></i></span>
                        Pesanan Saya
                    </a>
                    <a href="#" class="sidebar-menu-item">
                        <span class="sidebar-menu-icon"><i class="bi bi-heart"></i></span>
                        Wishlist
                    </a>
                </div>
            </div>

            {{-- Ringkasan Info --}}
            <div class="sidebar-card">
                <div class="sidebar-card-head">Ringkasan Akun</div>
                <div class="sidebar-card-body">
                    <ul class="info-list">
                        <li>
                            <span class="lbl">Status Akun</span>
                            <span class="val" style="color:#10b981;">● Aktif</span>
                        </li>
                        <li>
                            <span class="lbl">Telepon</span>
                            <span class="val">{{ $user->no_telepon ?: '—' }}</span>
                        </li>
                        <li>
                            <span class="lbl">Bergabung</span>
                            <span class="val">{{ $user->created_at ? $user->created_at->format('M Y') : '—' }}</span>
                        </li>
                        <li>
                            <span class="lbl">Tipe Akun</span>
                            <span class="val" style="text-transform:capitalize;">{{ $user->role }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="sidebar-card">
                <div class="sidebar-card-head">Zona Berbahaya</div>
                <div class="sidebar-card-body">
                    <div class="danger-zone">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-danger-outline">
                                <i class="bi bi-box-arrow-right"></i>
                                Keluar dari Akun
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
