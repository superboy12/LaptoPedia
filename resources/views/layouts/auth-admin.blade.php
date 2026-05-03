<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LaptoPedia') — Premium Laptops</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500&display=swap" rel="stylesheet">

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
            color: var(--white);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1,h2,h3,h4,h5,h6 { font-family: 'Manrope', sans-serif; letter-spacing: -0.03em; }
        a { text-decoration: none; color: inherit; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--black); }
        ::-webkit-scrollbar-thumb { background: var(--surface-2); border-radius: 3px; }

        .admin-auth-topbar {
            height: 56px;
            background: var(--deep);
            border-bottom: 1px solid var(--border);
            padding: 0 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-brand {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: -0.04em;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .topbar-brand em { font-style: normal; color: var(--gold); }

        .help-link {
            font-size: 0.82rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }
        .help-link:hover { color: var(--white); }

        .admin-auth-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
        }

        .admin-auth-form-wrap {
            width: 100%;
            max-width: 420px;
        }

        .auth-tabs {
            display: flex;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 4px;
            margin-bottom: 32px;
        }

        .auth-tab {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--muted);
            transition: all 0.25s;
            cursor: pointer;
            border: none;
            background: none;
            font-family: 'DM Sans', sans-serif;
        }

        .auth-tab.active {
            background: var(--surface-2);
            color: var(--white);
            font-weight: 600;
        }

        .auth-tab:hover:not(.active) { color: rgba(255,255,255,0.65); }

        .form-heading {
            margin-bottom: 28px;
        }

        .form-heading h2 {
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 6px;
            letter-spacing: -0.03em;
        }

        .form-heading p {
            font-size: 0.82rem;
            color: var(--muted);
            font-weight: 300;
        }

        .alert {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 11px 13px;
            border-radius: 8px;
            font-size: 0.8rem;
            margin-bottom: 16px;
        }

        .alert-success {
            background: rgba(34,197,94,0.07);
            border: 1px solid rgba(34,197,94,0.18);
            color: #4ade80;
        }

        .field {
            margin-bottom: 12px;
        }

        .field-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 12px 14px;
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .field-box:focus-within {
            border-color: rgba(212,168,67,0.45);
            box-shadow: 0 0 0 3px rgba(212,168,67,0.07);
        }

        .field-box.is-error {
            border-color: rgba(239,68,68,0.45);
            box-shadow: 0 0 0 3px rgba(239,68,68,0.06);
        }

        .field-icon { color: var(--muted); font-size: 0.88rem; flex-shrink: 0; }

        .field-box input {
            flex: 1;
            background: none;
            border: none;
            outline: none;
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
        }

        .field-box input::placeholder { color: rgba(255,255,255,0.22); }

        .field-action {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .field-action:hover { color: var(--white); }

        .field-error {
            font-size: 0.74rem;
            color: #f87171;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .strength-wrap { margin-top: 7px; }
        .strength-bars { display: flex; gap: 4px; margin-bottom: 4px; }
        .strength-bar {
            flex: 1; height: 3px;
            border-radius: 2px;
            background: var(--surface-2);
            transition: background 0.35s ease;
        }
        .strength-meta { display: flex; justify-content: space-between; }
        .strength-hint { font-size: 0.71rem; color: var(--muted); font-weight: 300; }
        .strength-label { font-size: 0.71rem; font-weight: 700; }

        .check-row {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 18px;
        }

        .check-row input[type="checkbox"] {
            width: 15px; height: 15px;
            margin-top: 2px;
            accent-color: var(--gold);
            cursor: pointer;
            flex-shrink: 0;
        }

        .check-row label { font-size: 0.8rem; color: var(--muted); cursor: pointer; line-height: 1.5; }
        .check-row a { color: var(--gold); transition: color 0.2s; }
        .check-row a:hover { color: var(--gold-light); }

        .meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .remember-row { display: flex; align-items: center; gap: 7px; }
        .remember-row input { accent-color: var(--gold); cursor: pointer; }
        .remember-row label { font-size: 0.8rem; color: var(--muted); cursor: pointer; }
        .forgot-link { font-size: 0.8rem; color: var(--gold); font-weight: 500; transition: color 0.2s; }
        .forgot-link:hover { color: var(--gold-light); }

        .btn-primary {
            width: 100%;
            padding: 13px;
            border-radius: 9px;
            border: none;
            cursor: pointer;
            font-family: 'Manrope', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--gold);
            color: var(--black);
            transition: background 0.25s, transform 0.2s, box-shadow 0.25s;
        }

        .btn-primary:hover {
            background: var(--gold-light);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(212,168,67,0.22);
        }

        .btn-primary:active { transform: translateY(0); }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 18px 0;
        }

        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider-text {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.22);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* ── SOCIAL BUTTONS ── */
        .social-row { display: grid; gap: 8px; }
        .social-row.two { grid-template-columns: 1fr 1fr; }
        .social-row.three { grid-template-columns: 1fr 1fr 1fr; }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 11px;
            border-radius: 9px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: rgba(255,255,255,0.65);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            cursor: pointer;
            transition: border-color 0.25s, background 0.25s, color 0.25s;
        }

        .btn-social:hover {
            border-color: rgba(212,168,67,0.28);
            background: var(--gold-dim);
            color: var(--white);
        }

        .bottom-link {
            text-align: center;
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 20px;
        }

        .bottom-link a { color: var(--gold); font-weight: 600; transition: color 0.2s; }
        .bottom-link a:hover { color: var(--gold-light); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%     { transform: translateX(-6px); }
            40%     { transform: translateX(6px); }
            60%     { transform: translateX(-3px); }
            80%     { transform: translateX(3px); }
        }

        .shake { animation: shake 0.4s ease; }

        .field, .d1, .d2, .d3, .d4, .d5, .d6 {animation: fadeUp 0.5s var(--transition) both;}
        .d1 { animation-delay: 0.10s; opacity: 0; }
        .d2 { animation-delay: 0.17s; opacity: 0; }
        .d3 { animation-delay: 0.22s; opacity: 0; }
        .d4 { animation-delay: 0.27s; opacity: 0; }
        .d5 { animation-delay: 0.32s; opacity: 0; }
        .d6 { animation-delay: 0.37s; opacity: 0; }

        @media (max-width: 768px) {
            .admin-auth-topbar { padding: 0 24px; }
            .admin-auth-main { padding: 32px 16px; }
            .admin-auth-form-wrap { max-width: 100%; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- TOPBAR --}}
<div class="admin-auth-topbar">
    <a href="{{ url('/') }}" class="topbar-brand">
        Lapto<em>Pedia</em>
    </a>
    <a href="#" class="help-link">
        <i class="bi bi-headset"></i>
        Need help?
    </a>
</div>

{{-- MAIN --}}
<div class="admin-auth-main">
    <div class="admin-auth-form-wrap">
        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
