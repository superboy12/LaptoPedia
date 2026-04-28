@extends('layouts.app')

@section('content')
<style>
    .auth-container {
        max-width: 1100px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        min-height: 700px;
        display: flex;
    }
    
    /* Bagian Kiri (Gradient + Image Overlay) */
    .auth-left {
        width: 45%;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        position: relative;
        padding: 3rem;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
    }
    
    .auth-left::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: url('https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=800&q=80') center/cover;
        opacity: 0.15; mix-blend-mode: overlay; pointer-events: none;
    }

    .auth-left-content { position: relative; z-index: 10; }
    .icon-box { background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.5rem; backdrop-filter: blur(10px); }
    
    /* Bagian Kanan (Form) */
    .auth-right {
        width: 55%; padding: 4rem 5rem; display: flex; flex-direction: column; justify-content: center;
    }

    /* Input Styling ala Apple/Modern */
    .input-wrapper { position: relative; margin-bottom: 1.5rem; }
    .input-icon { position: absolute; top: 50%; transform: translateY(-50%); left: 18px; color: #94a3b8; font-size: 1.1rem; z-index: 10; }
    .form-control-custom {
        width: 100%; padding: 14px 20px 14px 50px; border-radius: 12px;
        border: 1px solid #e2e8f0; background: #f8fafc; font-size: 0.95rem; font-weight: 500;
        transition: all 0.3s ease;
    }
    .form-control-custom:focus { background: #ffffff; border-color: #6366f1; outline: none; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }

    .btn-primary-custom { background: #6366f1; color: white; border: none; border-radius: 12px; padding: 14px; font-weight: 600; width: 100%; transition: 0.3s; margin-top: 1rem; }
    .btn-primary-custom:hover { background: #4f46e5; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2); }

    .social-btn { border: 1px solid #e2e8f0; background: white; border-radius: 12px; padding: 12px; font-weight: 600; color: #475569; width: 48%; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s; text-decoration: none;}
    .social-btn:hover { background: #f8fafc; border-color: #cbd5e1; color: #0f172a; }
</style>

<div class="container py-4">
    <div class="auth-container">
        <div class="auth-left d-none d-md-flex">
            <div class="auth-left-content">
                <div class="icon-box"><i class="fa-solid fa-code"></i></div>
                <h1 class="fw-bolder mb-3">Welcome Back to LaptoPedia</h1>
                <p class="opacity-75 mb-5 fs-6">Your premium destination for the latest tech, reviews, and exclusive member deals. Log in to access your personalized dashboard.</p>
            </div>
        </div>

        <div class="auth-right">
            <div class="mb-5 text-center">
                <h3 class="fw-bolder" style="color: #0f172a;">Login to your account</h3>
                <p class="text-muted small">Welcome back, please enter your details.</p>
            </div>

            <div class="d-flex bg-light rounded-pill p-1 mb-4" style="border: 1px solid #e2e8f0;">
                <a href="#" class="w-50 text-center py-2 rounded-pill fw-bold text-dark bg-white shadow-sm text-decoration-none">Sign In</a>
                <a href="{{ route('register') }}" class="w-50 text-center py-2 rounded-pill fw-bold text-muted text-decoration-none">Sign Up</a>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-wrapper">
                    <i class="fa-regular fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control-custom @error('email') border-danger @enderror" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                    @error('email') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                </div>

                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="password" class="form-control-custom @error('password') border-danger @enderror" placeholder="Password" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 small">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label text-muted fw-medium" for="remember">Remember me</label>
                    </div>
                    <a href="#" class="text-decoration-none fw-bold" style="color: #6366f1;">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-primary-custom">Login</button>
            </form>

            <div class="text-center my-4 position-relative">
                <hr class="text-muted">
                <span class="bg-white px-3 text-muted small position-absolute top-50 start-50 translate-middle fw-bold">OR CONTINUE WITH</span>
            </div>

            <div class="d-flex justify-content-between">
                <a href="#" class="social-btn"><i class="fa-brands fa-google text-danger"></i> Google</a>
                <a href="#" class="social-btn"><i class="fa-brands fa-apple fs-5"></i> Apple</a>
            </div>
        </div>
    </div>
</div>
@endsection