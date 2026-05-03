@extends('layouts.auth-admin')

@section('content')

{{-- Tabs --}}
<div class="auth-tabs">
    <button class="auth-tab active">Sign In</button>
    <a href="{{ route('admin.register') }}" class="auth-tab">Sign Up</a>
</div>

{{-- Heading --}}
<div class="form-heading">
    <h2>Admin Login</h2>
    <p>Enter your credentials to access the admin dashboard</p>
</div>

{{-- Success Alert --}}
@if(session('success'))
    <div class="alert alert-success d1">
        <i class="bi bi-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Form --}}
<form method="POST" action="{{ route('admin.login') }}" id="loginForm" novalidate>
    @csrf

    {{-- Email --}}
    <div class="field d1">
        <div class="field-box {{ $errors->has('email') ? 'is-error' : '' }}">
            <i class="bi bi-envelope field-icon"></i>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email"
                autocomplete="email"
            >
        </div>
        @error('email')
            <div class="field-error">
                <i class="bi bi-exclamation-triangle"></i>
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Password --}}
    <div class="field d2">
        <div class="field-box">
            <i class="bi bi-lock field-icon"></i>
            <input
                type="password"
                name="password"
                id="password"
                placeholder="Enter your password"
                autocomplete="current-password"
            >
            <button type="button" class="field-action" onclick="togglePassword('password')">
                <i class="bi bi-eye-slash" id="eye-icon"></i>
            </button>
        </div>
        @error('password')
            <div class="field-error">
                <i class="bi bi-exclamation-triangle"></i>
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Remember & Forgot --}}
    <div class="meta-row d3">
        <label class="remember-row">
            <input type="checkbox" name="remember" id="remember">
            <span>Remember me</span>
        </label>
        <a href="#" class="forgot-link">Forgot Password?</a>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-primary d4">
        <span id="btn-text">Sign In</span>
        <i class="bi bi-arrow-right" id="btn-icon"></i>
        <svg id="btn-spinner" class="hidden" width="16" height="16" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" opacity="0.25"></circle>
            <path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.75"></path>
        </svg>
    </button>
</form>

{{-- Divider --}}
<div class="divider d5">
    <div class="divider-line"></div>
    <span class="divider-text">Or continue with</span>
    <div class="divider-line"></div>
</div>

{{-- Social --}}
<div class="social-row two d5">
    <button class="btn-social">
        <svg width="16" height="16" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
    </button>
    <button class="btn-social">
        <i class="bi bi-github"></i>
    </button>
</div>

{{-- Bottom Link --}}
<div class="bottom-link d6">
    Don't have an account?
    <a href="{{ route('admin.register') }}">Create admin account</a>
</div>

@endsection

@push('scripts')
<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    const icon = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye-slash';
    }
}

document.getElementById('loginForm').addEventListener('submit', function() {
    document.getElementById('btn-text').textContent = 'Signing in...';
    document.getElementById('btn-icon').classList.add('hidden');
    document.getElementById('btn-spinner').classList.remove('hidden');
});

@if($errors->any())
    document.getElementById('loginForm').classList.add('shake');
@endif
</script>
@endpush
