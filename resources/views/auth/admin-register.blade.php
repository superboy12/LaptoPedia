@extends('layouts.auth-admin')

@section('content')

{{-- Tabs --}}
<div class="auth-tabs">
    <a href="{{ route('admin.login') }}" class="auth-tab">Sign In</a>
    <button class="auth-tab active">Sign Up</button>
</div>

{{-- Heading --}}
<div class="form-heading">
    <h2>Create Admin Account</h2>
    <p>Register to access the admin dashboard</p>
</div>

{{-- Form --}}
<form method="POST" action="{{ route('admin.register') }}" id="registerForm" novalidate>
    @csrf

    {{-- Full Name --}}
    <div class="field d1">
        <div class="field-box {{ $errors->has('nama_lengkap') ? 'is-error' : '' }}">
            <i class="bi bi-person field-icon"></i>
            <input
                type="text"
                name="nama_lengkap"
                value="{{ old('nama_lengkap') }}"
                placeholder="Your full name"
                autocomplete="name"
            >
        </div>
        @error('nama_lengkap')
            <div class="field-error">
                <i class="bi bi-exclamation-triangle"></i>
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Email --}}
    <div class="field d2">
        <div class="field-box {{ $errors->has('email') ? 'is-error' : '' }}">
            <i class="bi bi-envelope field-icon"></i>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Work email"
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

    {{-- Phone --}}
    <div class="field d2">
        <div class="field-box">
            <i class="bi bi-telephone field-icon"></i>
            <input
                type="tel"
                name="no_telepon"
                value="{{ old('no_telepon') }}"
                placeholder="Phone number"
                autocomplete="tel"
            >
        </div>
    </div>

    {{-- Password --}}
    <div class="field d3">
        <div class="field-box">
            <i class="bi bi-lock field-icon"></i>
            <input
                type="password"
                name="password"
                id="password"
                placeholder="Create a password"
                autocomplete="new-password"
                oninput="checkStrength(this.value)"
            >
            <button type="button" class="field-action" onclick="togglePassword('password')">
                <i class="bi bi-eye-slash" id="eye-pass"></i>
            </button>
        </div>

        <div class="strength-wrap">
            <div class="strength-bars">
                <div class="strength-bar" id="bar1"></div>
                <div class="strength-bar" id="bar2"></div>
                <div class="strength-bar" id="bar3"></div>
                <div class="strength-bar" id="bar4"></div>
            </div>
            <div class="strength-meta">
                <span class="strength-hint">Password strength</span>
                <span class="strength-label" id="strength-label"></span>
            </div>
        </div>

        @error('password')
            <div class="field-error">
                <i class="bi bi-exclamation-triangle"></i>
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="field d4">
        <div class="field-box">
            <i class="bi bi-lock field-icon"></i>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                placeholder="Confirm password"
                autocomplete="new-password"
                oninput="checkMatch()"
            >
            <i class="bi bi-check-circle" id="match-icon" style="display:none;color:#4ade80;font-size:0.88rem;"></i>
        </div>
    </div>

    {{-- Terms --}}
    <div class="check-row d4">
        <input type="checkbox" name="terms" id="terms" required>
        <label for="terms">
            I agree to the
            <a href="#">Terms of Service</a>
            and
            <a href="#">Privacy Policy</a>
        </label>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-primary d5">
        <span id="btn-text">Create Account</span>
        <svg id="btn-spinner" class="hidden" width="16" height="16" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" opacity="0.25"></circle>
            <path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.75"></path>
        </svg>
    </button>
</form>

{{-- Divider --}}
<div class="divider d5">
    <div class="divider-line"></div>
    <span class="divider-text">Or register with</span>
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
    Already have an account?
    <a href="{{ route('admin.login') }}">Sign in</a>
</div>

@endsection

@push('scripts')
<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    const icon = document.getElementById(id === 'password' ? 'eye-pass' : 'eye-confirm');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye-slash';
    }
}

function checkStrength(val) {
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const colors = ['', '#f87171', '#fb923c', '#facc15', '#4ade80'];
    for (let i = 1; i <= 4; i++) {
        document.getElementById('bar' + i).style.backgroundColor = i <= score ? colors[score] : 'var(--surface-2)';
    }

    const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
    const label = document.getElementById('strength-label');
    label.textContent = val.length > 0 ? labels[score] : '';
    label.style.color = colors[score] || 'var(--muted)';
}

function checkMatch() {
    const pass = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    const icon = document.getElementById('match-icon');
    icon.style.display = confirm.length > 0 && pass === confirm ? 'block' : 'none';
}

document.getElementById('registerForm').addEventListener('submit', function(e) {
    if (!document.getElementById('terms').checked) {
        e.preventDefault();
        document.getElementById('terms').style.boxShadow = '0 0 0 2px #f87171';
        return;
    }
    document.getElementById('btn-text').textContent = 'Creating account...';
    document.getElementById('btn-spinner').classList.remove('hidden');
});

@if($errors->any())
    document.getElementById('registerForm').classList.add('shake');
@endif
</script>
@endpush
