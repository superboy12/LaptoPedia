<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LaptoPedia') — Platform Laptop Terbaik</title>

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Syne', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50:  '#eff0ff',
                            100: '#dfe1ff',
                            200: '#c6c9ff',
                            300: '#a4a8ff',
                            400: '#817eff',
                            500: '#6860fa',
                            600: '#5a47ef',
                            700: '#4d38d4',
                            800: '#3e2fab',
                            900: '#372e8a',
                            950: '#221c52',
                        },
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-slow': 'float 9s ease-in-out infinite',
                        'slide-up': 'slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                        'fade-in': 'fadeIn 0.5s ease forwards',
                        'shimmer': 'shimmer 2.5s linear infinite',
                        'pulse-soft': 'pulseSoft 3s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '33%': { transform: 'translateY(-12px) rotate(1deg)' },
                            '66%': { transform: 'translateY(-6px) rotate(-1deg)' },
                        },
                        slideUp: {
                            from: { opacity: '0', transform: 'translateY(24px)' },
                            to:   { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            from: { opacity: '0' },
                            to:   { opacity: '1' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-1000px 0' },
                            '100%': { backgroundPosition: '1000px 0' },
                        },
                        pulseSoft: {
                            '0%, 100%': { opacity: '0.6' },
                            '50%': { opacity: '1' },
                        },
                    },
                }
            }
        }
    </script>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f0e1a;
        }

        .mesh-bg {
            background:
                radial-gradient(ellipse 80% 60% at 20% 50%, rgba(104, 96, 250, 0.35) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 80% 20%, rgba(129, 126, 255, 0.2) 0%, transparent 55%),
                radial-gradient(ellipse 50% 50% at 60% 80%, rgba(62, 47, 171, 0.3) 0%, transparent 60%),
                linear-gradient(135deg, #0f0e1a 0%, #1a1535 50%, #0d1226 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(20px);
        }

        .input-field {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-field:focus-within {
            border-color: #6860fa;
            box-shadow: 0 0 0 3px rgba(104, 96, 250, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #6860fa 0%, #4d38d4 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s;
        }
        .btn-primary:hover::before { left: 100%; }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 30px rgba(104, 96, 250, 0.45);
        }
        .btn-primary:active { transform: translateY(0px); }

        .orb {
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            position: absolute;
            pointer-events: none;
        }

        .strength-bar {
            height: 4px;
            border-radius: 2px;
            transition: width 0.4s ease, background-color 0.4s ease;
        }

        .delay-100 { animation-delay: 0.1s; opacity: 0; }
        .delay-200 { animation-delay: 0.2s; opacity: 0; }
        .delay-300 { animation-delay: 0.3s; opacity: 0; }
        .delay-400 { animation-delay: 0.4s; opacity: 0; }
        .delay-500 { animation-delay: 0.5s; opacity: 0; }
        .delay-600 { animation-delay: 0.6s; opacity: 0; }

        .feature-badge {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .feature-badge:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: translateX(4px);
        }

        .btn-social {
            transition: all 0.25s ease;
            border: 1.5px solid #e5e7eb;
        }
        .btn-social:hover {
            border-color: #6860fa;
            background: #f5f4ff;
            transform: translateY(-1px);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%       { transform: translateX(-6px); }
            40%       { transform: translateX(6px); }
            60%       { transform: translateX(-4px); }
            80%       { transform: translateX(4px); }
        }
        .shake { animation: shake 0.4s ease; }

        input[type="checkbox"]:checked {
            background-color: #6860fa;
            border-color: #6860fa;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #6860fa44; border-radius: 3px; }
    </style>
</head>
<body class="h-full mesh-bg min-h-screen">

    @yield('content')

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
