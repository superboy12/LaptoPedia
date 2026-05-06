<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', 'Dashboard') — LaptoPedia Admin</title>

    {{-- Fonts: Premium Editorial & Modern --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --black:        #000000;
            --off-black:    #0a0a0a;
            --deep:         #111111;
            --surface:      #1a1a1a;
            --surface-2:    #242424;
            --border:       rgba(255,255,255,0.08);
            --border-hover: rgba(255,255,255,0.18);
            --white:        #ffffff;
            --off-white:    #f5f5f7;
            --muted:        rgba(255,255,255,0.45);
            --gold:         #d4a843;
            --gold-light:   #e8c06a;
            --gold-dim:     rgba(212,168,67,0.12);
            --transition:   cubic-bezier(0.4,0,0.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--black);
            background-image: radial-gradient(circle at top right, rgba(212,168,67,0.05), transparent 400px),
                              radial-gradient(circle at bottom left, rgba(0,113,227,0.03), transparent 400px);
            color: var(--white);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }

        h1,h2,h3,h4,h5,h6 { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Manrope', sans-serif; }
        a { text-decoration: none; color: inherit; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--black); }
        ::-webkit-scrollbar-thumb { background: var(--surface-2); border-radius: 3px; }

        .admin-layout {
            display: grid;
            grid-template-columns: 180px 1fr;
            grid-template-rows: 52px 1fr;
            min-height: 100vh;
        }

        .admin-sidebar {
            grid-row: 1 / -1;
            background: var(--deep);
            border-right: 1px solid var(--border);
            padding: 24px 0;
            overflow-y: auto;
            position: fixed;
            width: 180px;
            height: 100vh;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 0 20px;
            margin-bottom: 32px;
            font-family: 'Manrope', sans-serif;
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sidebar-brand em { font-style: normal; color: var(--gold); }
        .sidebar-brand-icon {
            width: 28px; height: 28px;
            background: var(--gold-dim);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 0.85rem;
        }

        .sidebar-menu { list-style: none; }
        .sidebar-menu-item { margin-bottom: 4px; }
        .sidebar-menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: var(--muted);
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.25s, background 0.25s;
            position: relative;
        }
        .sidebar-menu-link:hover {
            color: var(--white);
            background: rgba(255,255,255,0.04);
        }
        .sidebar-menu-link.active {
            color: var(--gold);
            background: var(--gold-dim);
        }
        .sidebar-menu-link i { font-size: 1rem; }

        .sidebar-label {
            padding: 12px 20px 8px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.2);
            margin-top: 20px;
        }

        .admin-topbar {
            grid-column: 2;
            grid-row: 1;
            background: rgba(17, 17, 17, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 99;
        }

        .topbar-title {
            font-family: 'Manrope', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: -0.03em;
        }
        .topbar-subtitle {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px 12px;
        }
        .topbar-search input {
            background: none;
            border: none;
            outline: none;
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            width: 200px;
        }
        .topbar-search input::placeholder { color: var(--muted); }
        .topbar-search i { color: var(--muted); font-size: 0.85rem; }

        .topbar-icon {
            background: none;
            border: none;
            color: var(--muted);
            font-size: 1.1rem;
            cursor: pointer;
            position: relative;
            transition: color 0.2s;
        }
        .topbar-icon:hover { color: var(--white); }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-left: 12px;
            border-left: 1px solid var(--border);
        }
        .user-avatar {
            width: 32px; height: 32px;
            border-radius: 6px;
            background: var(--gold-dim);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-weight: 700;
            font-size: 0.9rem;
        }
        .user-name { font-size: 0.85rem; font-weight: 600; }
        .user-role { font-size: 0.72rem; color: var(--muted); }
        .user-dropdown {
            cursor: pointer;
            position: relative;
        }

        .admin-main {
            grid-column: 2;
            grid-row: 2;
            overflow-y: auto;
            padding: 40px 48px;
        }

        .page-header {
            margin-bottom: 32px;
            animation: fadeUp 0.5s var(--transition);
        }
        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 4px;
            color: var(--white);
        }
        .page-desc {
            font-size: 0.95rem;
            color: var(--muted);
            font-weight: 300;
            font-family: 'DM Sans', sans-serif;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 1200px) {
            .admin-layout { grid-template-columns: 140px 1fr; }
            .admin-sidebar { width: 140px; }
            .admin-main { padding: 32px 32px; }
            .sidebar-brand { padding: 0 16px; font-size: 0.9rem; }
            .sidebar-menu-link { padding: 9px 16px; font-size: 0.8rem; }
        }

        @media (max-width: 768px) {
            .admin-layout { grid-template-columns: 1fr; }
            .admin-sidebar { display: none; }
            .admin-topbar { margin-left: 0; padding: 0 24px; }
            .admin-main { margin-left: 0; padding: 24px; }
            .topbar-search { display: none; }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="admin-layout">

    {{-- SIDEBAR --}}
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-shield-lock sidebar-brand-icon"></i>
            <span>Lapto<em>Pedia</em></span>
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.products') }}" class="sidebar-menu-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                    <i class="bi bi-box"></i>
                    Products
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.orders') }}" class="sidebar-menu-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check"></i>
                    Orders
                </a>
            </li>
        </ul>

        <div class="sidebar-label">Other</div>
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="bi bi-gear"></i>
                    Settings
                </a>
            </li>
        </ul>

        <div class="sidebar-label">Account</div>
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <form method="POST" action="{{ route('admin.logout') }}" style="width:100%;">
                    @csrf
                    <button type="submit" class="sidebar-menu-link" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    {{-- TOP BAR --}}
    <nav class="admin-topbar">
        <div>
            <div class="topbar-title">@yield('page_title', 'Dashboard')</div>
            <div class="topbar-subtitle">{{ now()->format('l, F j, Y') }}</div>
        </div>

        <div class="topbar-actions">
            <div class="topbar-search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search anything...">
            </div>

            <button class="topbar-icon">
                <i class="bi bi-bell"></i>
            </button>

            <button class="topbar-icon">
                <i class="bi bi-envelope"></i>
            </button>

            <div class="topbar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 2)) }}
                </div>
                <div>
                    <div class="user-name">{{ Auth::user()->nama_lengkap }}</div>
                    <div class="user-role">Super Admin</div>
                </div>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="admin-main">
        <div class="page-header">
            <h1 class="page-title">@yield('page_title', 'Dashboard')</h1>
            <p class="page-desc">@yield('page_desc', 'Manage your store and track performance')</p>
        </div>

        @if(session('success'))
            <div style="background:rgba(34,197,94,0.07);border:1px solid rgba(34,197,94,0.2);color:#4ade80;padding:12px 16px;border-radius:8px;margin-bottom:24px;display:flex;align-items:center;gap:10px;font-size:0.85rem;animation:fadeUp 0.3s var(--transition);">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</div>

@stack('scripts')
</body>
</html>
