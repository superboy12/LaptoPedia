<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Ini memastikan hanya user yang sudah login yang bisa mengakses halaman ini
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard (Beranda Utama).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Menggunakan with('category') agar pengambilan data lebih efisien (Eager Loading)
         $products = \App\Models\Product::with('category')->latest()->take(4)->get();
        
      return view('home', compact('products'));
    }

    /**
     * Menampilkan Halaman Detail Produk.
     *
     * @param string $slug
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function detail($slug)
    {
        // 1. Cari produk di database berdasarkan 'slug'-nya (URL-nya)
        // firstOrFail() akan otomatis menampilkan halaman 404 jika produk tidak ditemukan
        $product = \App\Models\Product::where('slug', $slug)->firstOrFail();

        // 2. Tampilkan file detail.blade.php yang ada di folder product
        // dan bawa data $product ke halaman tersebut
        return view('product.detail', compact('product'));
    }
}