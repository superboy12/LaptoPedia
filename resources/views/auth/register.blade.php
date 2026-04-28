@extends('layouts.app')

@section('content')
<style>
    /* Menggunakan base CSS yang sama dengan Login agar konsisten */
    .auth-container { max-width: 1100px; margin: 0 auto; background: #ffffff; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); overflow: hidden; min-height: 700px; display: flex; }
    .auth-left { width: 45%; background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); position: relative; padding: 3rem; color: white; display: flex; flex-direction: column; justify-content: center; }
    .auth-left::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('https://images.unsplash.com/photo-1531297172867-4d6482b1f562?auto=format&fit=crop&w=800&q=80') center/cover; opacity: 0.1; mix-blend-mode: overlay; pointer-events: none; }
    .auth-left-content { position: relative; z-index: 10; }
    .icon-box { background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.5rem; backdrop-filter: blur(10px); }
    
    /* Feature List Register */
    .feature-list { list-style: none; padding: 0; margin-top: 2rem; }
    .feature-list li { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; padding: 12px 20px; margin-bottom: 1rem; display: flex; align-items: center; gap: 15px; font-weight: 500; font-size: 0.9rem;}
    .feature-list i { background: white; color: #4f46e5; padding: 5px; border-radius: 50%; font-size: 0.7rem; }

    .auth-right { width: 55%; padding: 3rem 5rem; display: flex; flex-direction: column; justify-content: center; }
    .input-wrapper { position: relative; margin-bottom: 1.2rem; }
    .input-icon { position: absolute; top: 50%; transform: translateY(-50%); left: 18px; color: #94a3b8; font-size: 1.1rem; z-index: 10; }
    .form-control-custom { width: 100%; padding: 14px 20px 14px 50px; border-radius: 12px; border: 1px solid #e2e8f0; background: #f8fafc; font-size: 0.95rem; font-weight: 500; transition: all 0.3s ease; }
    .form-control-custom:focus { background: #ffffff; border-color: #4f46e5; outline: none; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); }
    .btn-primary-custom { background: #4f46e5; color: white; border: none; border-radius: 12px; padding: 14px; font-weight: 600; width: 100%; transition: 0.3s; margin-top: 1rem; }
    .btn-primary-custom:hover { background: #4338ca; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2); }
    
    /* Password Strength Indicator */
    .pass-strength { display: flex; gap: 5px; margin-top: -10px; margin-bottom: 1.5rem; }
    .strength-bar { height: 4px; border-radius: 2px; background: #e2e8f0; flex-grow: 1; }
    .strength-bar.active-1 { background: #ef4444; } /* Red */
    .strength-bar.active-2 { background: #eab308; } /* Yellow */
    .strength-bar.active-3 { background: #22c55e; } /* Green */
</style>

<div class="container py-4">
    <div class="auth-container">
        <div class="auth-left d-none d-md-flex">
            <div class="auth-left-content">
                <div class="icon-box"><i class="fa-solid fa-bag-shopping"></i></div>
                <h1 class="fw-bolder mb-3">Join LaptoPedia Today</h1>
                <p class="opacity-75 fs-6 mb-4">Discover the best laptops at unbeatable prices. Join thousands of tech enthusiasts already saving big.</p>
                
                <ul class="feature-list">
                    <li><i class="fa-solid fa-star"></i> Exclusive member-only deals</li>
                    <li><i class="fa-solid fa-check"></i> Expert reviews & comparisons</li>
                    <li><i class="fa-solid fa-shield-halved"></i> Secure shopping guarantee</li>
                </ul>
            </div>
        </div>

        <div class="auth-right">
            <div class="mb-4">
                <h3 class="fw-bolder" style="color: #0f172a;">Create your account</h3>
                <p class="text-muted small">Enter your details to get started.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-wrapper">
                    <i class="fa-regular fa-user input-icon"></i>
                    <input type="text" name="name" class="form-control-custom @error('name') border-danger @enderror" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="input-wrapper">
                    <i class="fa-regular fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control-custom @error('email') border-danger @enderror" placeholder="Email Address" value="{{ old('email') }}" required>
                </div>

                <div class="input-wrapper mb-3">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="password" class="form-control-custom @error('password') border-danger @enderror" placeholder="Create Password" required>
                </div>
                
                <div class="pass-strength">
                    <div class="strength-bar active-1"></div>
                    <div class="strength-bar active-2"></div>
                    <div class="strength-bar"></div>
                    <span class="ms-2" style="font-size: 0.65rem; color: #eab308; font-weight: bold; line-height: 1;">Medium</span>
                </div>

                <div class="input-wrapper">
                    <i class="fa-solid fa-shield-check input-icon"></i>
                    <input type="password" name="password_confirmation" class="form-control-custom" placeholder="Confirm Password" required>
                </div>

                <div class="form-check my-3 small">
                    <input class="form-check-input" type="checkbox" required id="terms">
                    <label class="form-check-label text-muted fw-medium" for="terms">
                        I agree to the <a href="#" style="color: #4f46e5; font-weight: bold; text-decoration: none;">Terms & Conditions</a>
                    </label>
                </div>

                <button type="submit" class="btn-primary-custom">Create Account</button>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
                <p class="small text-muted mb-0">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #4f46e5;">Log in</a></p>
            </div>
        </div>
    </div>
</div>
@endsection