@extends('layouts.auth')

@section('title', 'Sign Up')

@push('styles')
<style>
    .font-manrope { font-family: 'Manrope', sans-serif; }
    .font-dmsans { font-family: 'DM Sans', sans-serif; }
    
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active{
        -webkit-box-shadow: 0 0 0 30px #111111 inset !important;
        -webkit-text-fill-color: white !important;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen flex bg-black font-dmsans">

    {{-- ─── LEFT PANEL ─── --}}
    <div class="hidden lg:flex lg:w-[45%] xl:w-[42%] relative overflow-hidden flex-col justify-between p-10 xl:p-14 border-r border-zinc-800/50">

        {{-- Orbs --}}
        <div class="absolute rounded-full blur-[110px] pointer-events-none w-[800px] h-[800px] top-[-250px] right-[-150px] animate-float" style="background: radial-gradient(circle, rgba(0,113,227,0.16) 0%, transparent 65%);"></div>
        <div class="absolute rounded-full blur-[110px] pointer-events-none w-[500px] h-[500px] bottom-[-120px] left-[-80px] animate-float-slow" style="background: radial-gradient(circle, rgba(212,168,67,0.10) 0%, transparent 65%); animation-delay: -3s;"></div>
        
        <div class="absolute inset-0 pointer-events-none opacity-30" style="background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px); background-size: 36px 36px; mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%); -webkit-mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);"></div>

        {{-- Logo --}}
        <div class="relative z-10 animate-slide-up delay-100">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
                    <i data-lucide="shopping-bag" class="w-5 h-5 text-white"></i>
                </div>
                <span class="font-manrope text-white text-xl font-bold tracking-tight">LaptoPedia</span>
            </a>
        </div>

        {{-- Center content --}}
        <div class="relative z-10 space-y-8">
            <div class="animate-slide-up delay-200">
                <p class="text-[#d4a843] text-xs font-bold uppercase tracking-[0.14em] mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-[#d4a843] rounded-full animate-pulse"></span>
                    Join Us Today
                </p>
                <h1 class="font-manrope text-white text-4xl xl:text-5xl font-black leading-tight tracking-tight">
                    Join LaptoPedia<br>
                    <span style="background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Today</span>
                </h1>
                <p class="text-white/50 text-base mt-5 leading-relaxed max-w-sm font-light">
                    Find the best laptops at affordable prices. Join thousands of tech enthusiasts who are already saving.
                </p>
            </div>

            {{-- Feature badges --}}
            <div class="space-y-3 animate-slide-up delay-300">
                <div class="rounded-xl px-4 py-3 flex items-center gap-4 bg-white/[0.02] border border-white/5 backdrop-blur-sm">
                    <div class="w-8 h-8 rounded-lg bg-[#d4a843]/10 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="tag" class="w-4 h-4 text-[#d4a843]"></i>
                    </div>
                    <span class="text-white/80 text-sm font-medium">Exclusive member-only offers</span>
                </div>
                <div class="rounded-xl px-4 py-3 flex items-center gap-4 bg-white/[0.02] border border-white/5 backdrop-blur-sm">
                    <div class="w-8 h-8 rounded-lg bg-[#d4a843]/10 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="star" class="w-4 h-4 text-[#d4a843]"></i>
                    </div>
                    <span class="text-white/80 text-sm font-medium">Expert reviews & comparisons</span>
                </div>
                <div class="rounded-xl px-4 py-3 flex items-center gap-4 bg-white/[0.02] border border-white/5 backdrop-blur-sm">
                    <div class="w-8 h-8 rounded-lg bg-[#d4a843]/10 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="shield-check" class="w-4 h-4 text-[#d4a843]"></i>
                    </div>
                    <span class="text-white/80 text-sm font-medium">Safe & trusted shopping guarantee</span>
                </div>
            </div>

            {{-- Stats --}}
            <div class="flex gap-8 pt-6 border-t border-white/10 animate-slide-up delay-400">
                <div>
                    <p class="font-manrope text-white font-black text-2xl">50K+</p>
                    <p class="text-white/40 text-xs mt-1">Happy Users</p>
                </div>
                <div class="w-px bg-white/10"></div>
                <div>
                    <p class="font-manrope text-white font-black text-2xl">5.000+</p>
                    <p class="text-white/40 text-xs mt-1">Laptops Listed</p>
                </div>
                <div class="w-px bg-white/10"></div>
                <div>
                    <p class="font-manrope text-white font-black text-2xl">4.9★</p>
                    <p class="text-white/40 text-xs mt-1">User Rating</p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="relative z-10 animate-slide-up delay-500">
            <p class="text-white/30 text-xs">© {{ date('Y') }} LaptoPedia. All rights reserved.</p>
        </div>
    </div>

    {{-- ─── RIGHT PANEL (Form) ─── --}}
    <div class="flex-1 bg-[#0a0a0a] flex flex-col overflow-y-auto relative">

        {{-- Top bar --}}
        <div class="flex items-center justify-between px-8 py-5 border-b border-white/5">
            <a href="{{ url('/') }}" class="flex lg:hidden items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-[#d4a843] flex items-center justify-center">
                    <i data-lucide="monitor" class="w-4 h-4 text-black"></i>
                </div>
                <span class="font-manrope text-white font-bold">LaptoPedia</span>
            </a>
            <div class="hidden lg:block"></div>
            <a href="#" class="text-sm text-white/50 hover:text-[#d4a843] transition-colors font-medium flex items-center gap-1.5">
                <i data-lucide="headphones" class="w-4 h-4"></i>
                Need help?
            </a>
        </div>

        {{-- Form area --}}
        <div class="flex-1 flex items-start justify-center px-8 py-8">
            <div class="w-full max-w-md">

                {{-- Tab: Sign In / Sign Up --}}
                <div class="flex bg-[#111111] border border-white/5 rounded-full p-1 mb-8 animate-slide-up delay-100">
                    <a href="{{ route('login') }}"
                       class="flex-1 text-center py-2.5 rounded-full text-sm font-medium text-white/50 hover:text-white transition-all">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex-1 text-center py-2.5 rounded-full text-sm font-semibold bg-[#222] text-white shadow-sm transition-all">
                        Sign Up
                    </a>
                </div>

                {{-- Heading --}}
                <div class="mb-7 animate-slide-up delay-100">
                    <h2 class="font-manrope text-3xl font-bold text-white tracking-tight">Create your account</h2>
                    <p class="text-white/50 text-sm mt-2 font-light">Enter your details to get started.</p>
                </div>

                {{-- Flash error global --}}
                @if($errors->any() && !$errors->has('nama_lengkap') && !$errors->has('email') && !$errors->has('no_telepon') && !$errors->has('password'))
                    <div class="mb-5 flex items-center gap-2.5 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl px-4 py-3 text-sm animate-fade-in">
                        <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                        An error occurred, please check the form.
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-4" novalidate>
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div class="animate-slide-up delay-200">
                        <div class="flex items-center gap-3 border rounded-xl px-4 py-3.5 transition-colors
                            {{ $errors->has('nama_lengkap') ? 'border-red-500/50 bg-red-500/5' : 'border-zinc-800 bg-[#111111] focus-within:border-[#d4a843]' }}">
                            <i data-lucide="user" class="w-4 h-4 text-white/40 flex-shrink-0"></i>
                            <input
                                type="text"
                                name="nama_lengkap"
                                id="nama_lengkap"
                                value="{{ old('nama_lengkap') }}"
                                placeholder="Your full name"
                                autocomplete="name"
                                class="flex-1 text-sm text-white placeholder-white/30 bg-transparent outline-none"
                            >
                            @if(!$errors->has('nama_lengkap') && old('nama_lengkap'))
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            @endif
                        </div>
                        @error('nama_lengkap')
                            <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                                <i data-lucide="alert-triangle" class="w-3 h-3"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="animate-slide-up delay-300">
                        <div class="flex items-center gap-3 border rounded-xl px-4 py-3.5 transition-colors
                            {{ $errors->has('email') ? 'border-red-500/50 bg-red-500/5' : 'border-zinc-800 bg-[#111111] focus-within:border-[#d4a843]' }}">
                            <i data-lucide="mail" class="w-4 h-4 {{ $errors->has('email') ? 'text-red-400' : 'text-white/40' }} flex-shrink-0"></i>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="Your email address"
                                autocomplete="email"
                                class="flex-1 text-sm text-white placeholder-white/30 bg-transparent outline-none"
                            >
                            @if($errors->has('email'))
                                <i data-lucide="alert-circle" class="w-4 h-4 text-red-400 flex-shrink-0"></i>
                            @endif
                        </div>
                        @error('email')
                            <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                                <i data-lucide="alert-triangle" class="w-3 h-3"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- No. Telepon --}}
                    <div class="animate-slide-up delay-300">
                        <div class="flex items-center gap-3 border border-zinc-800 bg-[#111111] focus-within:border-[#d4a843] rounded-xl px-4 py-3.5 transition-colors">
                            <i data-lucide="phone" class="w-4 h-4 text-white/40 flex-shrink-0"></i>
                            <input
                                type="tel"
                                name="no_telepon"
                                id="no_telepon"
                                value="{{ old('no_telepon') }}"
                                placeholder="+62 812 3456 7890"
                                autocomplete="tel"
                                class="flex-1 text-sm text-white placeholder-white/30 bg-transparent outline-none"
                            >
                        </div>
                        @error('no_telepon')
                            <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                                <i data-lucide="alert-triangle" class="w-3 h-3"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="animate-slide-up delay-400">
                        <div class="flex items-center gap-3 border border-zinc-800 bg-[#111111] focus-within:border-[#d4a843] rounded-xl px-4 py-3.5 transition-colors">
                            <i data-lucide="lock" class="w-4 h-4 text-white/40 flex-shrink-0"></i>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Create a password"
                                autocomplete="new-password"
                                oninput="checkStrength(this.value)"
                                class="flex-1 text-sm text-white placeholder-white/30 bg-transparent outline-none"
                            >
                            <button type="button" onclick="togglePassword('password', 'eye-pass')"
                                class="text-white/40 hover:text-white transition-colors">
                                <i data-lucide="eye-off" id="eye-pass" class="w-4 h-4"></i>
                            </button>
                        </div>

                        {{-- Strength bar --}}
                        <div class="mt-2 space-y-1.5">
                            <div class="flex gap-1.5" id="strength-bars">
                                <div class="h-1 flex-1 rounded-full bg-zinc-800 transition-colors duration-300" id="bar1"></div>
                                <div class="h-1 flex-1 rounded-full bg-zinc-800 transition-colors duration-300" id="bar2"></div>
                                <div class="h-1 flex-1 rounded-full bg-zinc-800 transition-colors duration-300" id="bar3"></div>
                                <div class="h-1 flex-1 rounded-full bg-zinc-800 transition-colors duration-300" id="bar4"></div>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-xs text-white/40">Password strength</p>
                                <p class="text-xs font-semibold" id="strength-label"></p>
                            </div>
                        </div>

                        @error('password')
                            <p class="text-red-400 text-xs mt-1 flex items-center gap-1">
                                <i data-lucide="alert-triangle" class="w-3 h-3"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="animate-slide-up delay-500">
                        <div class="flex items-center gap-3 border border-zinc-800 bg-[#111111] focus-within:border-[#d4a843] rounded-xl px-4 py-3.5 transition-colors">
                            <i data-lucide="lock" class="w-4 h-4 text-white/40 flex-shrink-0"></i>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                placeholder="Confirm password"
                                autocomplete="new-password"
                                oninput="checkMatch()"
                                class="flex-1 text-sm text-white placeholder-white/30 bg-transparent outline-none"
                            >
                            <i data-lucide="check-circle-2" id="match-icon" class="w-4 h-4 text-emerald-400 hidden flex-shrink-0"></i>
                            <button type="button" onclick="togglePassword('password_confirmation', 'eye-confirm')"
                                class="text-white/40 hover:text-white transition-colors">
                                <i data-lucide="eye-off" id="eye-confirm" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Terms --}}
                    <div class="flex items-start gap-2.5 animate-slide-up delay-500 pt-1">
                        <input type="checkbox" name="terms" id="terms" required
                            class="w-4 h-4 mt-0.5 rounded border-zinc-700 bg-zinc-900 text-[#d4a843] focus:ring-[#d4a843] focus:ring-offset-black cursor-pointer flex-shrink-0">
                        <label for="terms" class="text-sm text-white/60 cursor-pointer leading-snug">
                            I agree to the
                            <a href="#" class="font-semibold text-[#d4a843] hover:underline">Terms & Conditions</a>
                            and
                            <a href="#" class="font-semibold text-[#d4a843] hover:underline">Privacy Policy</a>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <div class="animate-slide-up delay-600 pt-2">
                        <button type="submit" id="submitBtn"
                            class="w-full py-3.5 rounded-full bg-white text-black font-manrope font-bold text-sm flex items-center justify-center gap-2 hover:bg-gray-200 transition-all hover:scale-[1.02]">
                            <i data-lucide="user-plus" class="w-4 h-4" id="btn-icon"></i>
                            <span id="btn-text">Create Account</span>
                            <svg id="btn-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                {{-- Divider --}}
                <div class="my-5 flex items-center gap-3 animate-slide-up delay-600">
                    <div class="flex-1 h-px bg-white/10"></div>
                    <span class="text-xs text-white/30 font-medium uppercase tracking-wider">Or sign up with</span>
                    <div class="flex-1 h-px bg-white/10"></div>
                </div>

                {{-- Social --}}
                <div class="grid grid-cols-2 gap-3 animate-slide-up delay-600">
                    <button class="rounded-xl py-3 flex items-center justify-center gap-2 bg-[#111111] border border-white/5 hover:bg-white/5 transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-sm text-white/80 font-medium">Google</span>
                    </button>
                    <button class="rounded-xl py-3 flex items-center justify-center gap-2 bg-[#1877F2] border border-[#1877F2] hover:bg-[#1877F2]/90 transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="white">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="text-sm text-white font-medium">Facebook</span>
                    </button>
                </div>

                {{-- Login link --}}
                <p class="text-center text-sm text-white/50 mt-8 animate-slide-up delay-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-semibold text-[#d4a843] hover:text-[#f0d080] transition-colors">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-lucide', 'eye');
        } else {
            input.type = 'password';
            icon.setAttribute('data-lucide', 'eye-off');
        }
        lucide.createIcons();
    }

    function checkStrength(val) {
        let score = 0;
        if (val.length >= 8)  score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const colors = ['', '#ef4444', '#f97316', '#eab308', '#22c55e'];
        const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
        const textColors = ['', 'text-red-400', 'text-orange-400', 'text-yellow-400', 'text-green-400'];

        for (let i = 1; i <= 4; i++) {
            const bar = document.getElementById('bar' + i);
            bar.style.backgroundColor = i <= score ? colors[score] : '#27272a'; // zinc-800
        }

        const label = document.getElementById('strength-label');
        label.textContent = val.length > 0 ? labels[score] : '';
        label.className = 'text-xs font-semibold ' + (val.length > 0 ? textColors[score] : '');
    }

    function checkMatch() {
        const pass    = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;
        const icon    = document.getElementById('match-icon');
        if (confirm.length > 0 && pass === confirm) {
            icon.classList.remove('hidden');
        } else {
            icon.classList.add('hidden');
        }
        lucide.createIcons();
    }

    document.getElementById('registerForm').addEventListener('submit', function (e) {
        const terms = document.getElementById('terms');
        if (!terms.checked) {
            e.preventDefault();
            terms.classList.add('ring-2', 'ring-red-500/50');
            return;
        }
        document.getElementById('btn-text').textContent = 'Creating account...';
        document.getElementById('btn-icon').classList.add('hidden');
        document.getElementById('btn-spinner').classList.remove('hidden');
    });

    @if($errors->any())
        document.getElementById('registerForm').classList.add('shake');
    @endif

    setTimeout(() => lucide.createIcons(), 50);
</script>
@endpush