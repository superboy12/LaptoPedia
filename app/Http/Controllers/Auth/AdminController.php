<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    // ─────────────────────────────────────────────
    //  SHOW ADMIN REGISTER
    // ─────────────────────────────────────────────

    public function showRegister()
    {
        return view('auth.admin-register');
    }

    // ─────────────────────────────────────────────
    //  REGISTER ADMIN
    // ─────────────────────────────────────────────

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:100', 'unique:users,email'],
            'no_telepon'   => ['nullable', 'string', 'max:20'],
            'password'     => ['required', 'confirmed', Password::min(8)],
        ], [
            'nama_lengkap.required' => 'Full name is required.',
            'email.required'        => 'Email is required.',
            'email.email'           => 'Invalid email format.',
            'email.unique'          => 'Email already registered.',
            'password.required'     => 'Password is required.',
            'password.confirmed'    => 'Password confirmation does not match.',
            'password.min'          => 'Password must be at least 8 characters.',
        ]);

        $admin = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'no_telepon'   => $request->no_telepon,
            'password'     => Hash::make($request->password),
            'role'         => 'admin',
        ]);

        Auth::login($admin);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Admin account created successfully! Welcome, ' . $admin->nama_lengkap . '!');
    }

    // ─────────────────────────────────────────────
    //  SHOW ADMIN LOGIN
    // ─────────────────────────────────────────────

    public function showLogin()
    {
        return view('auth.admin-login');
    }

    // ─────────────────────────────────────────────
    //  LOGIN ADMIN
    // ─────────────────────────────────────────────

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email is required.',
            'email.email'       => 'Invalid email format.',
            'password.required' => 'Password is required.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        // Attempt login
        if (Auth::attempt($credentials, $remember)) {
            // Check if user is admin
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'This account does not have admin access.']);
            }

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back, ' . Auth::user()->nama_lengkap . '!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Incorrect email or password.']);
    }

    // ─────────────────────────────────────────────
    //  ADMIN LOGOUT
    // ─────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been logged out.');
    }
}
