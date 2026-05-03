@extends('layouts.app')

@section('content')
<div style="padding: 120px 48px 80px; max-width: 1280px; margin: 0 auto;">
    <h1 style="font-size: 2rem; margin-bottom: 30px; color: white;">My Cart</h1>
    
    <div id="cartItems"></div>
    
    <div style="margin-top: 30px;">
        <a href="{{ url('/') }}" style="color: var(--gold);">← Continue Shopping</a>
    </div>
</div>

<script>
// Data harga produk (sinkron dengan yang di homepage)
const productPrices = {
    'MacBook Pro 16"': 28999000,
    'Dell XPS 15': 25999000,
    'ASUS ROG Strix G16': 32999000,
    'HP Spectre x360': 19999000
};

function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID').format(angka);
}

function loadCart() {
    const cart = JSON.parse(localStorage.getItem('my_cart') || '[]');
    const container = document.getElementById('cartItems');
    
    if (cart.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 80px; background: #1a1a1a; border-radius: 20px;">
                <i class="bi bi-cart-x" style="font-size: 4rem; color: #666;"></i>
                <p style="margin-top: 20px; color: #888;">Your cart is empty</p>
                <a href="/" style="display: inline-block; margin-top: 20px; color: var(--gold);">Go to Shop</a>
            </div>
        `;
        return;
    }
    
    let html = '<div style="background: #1a1a1a; border-radius: 20px; overflow: hidden;">';
    let subtotal = 0;
    
    cart.forEach((item, index) => {
        const price = productPrices[item.name] || 15000000;
        const itemTotal = price * item.quantity;
        subtotal += itemTotal;
        
        html += `
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <div style="flex: 2;">
                    <h3 style="margin-bottom: 5px; color: white;">${item.name}</h3>
                    <p style="color: rgba(255,255,255,0.5);">Rp ${formatRupiah(price)}</p>
                </div>
                <div style="flex: 1; text-align: center;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button onclick="updateQuantity(${index}, -1)" style="background: rgba(255,255,255,0.1); border: 1px solid #333; color: white; width: 30px; height: 30px; border-radius: 8px; cursor: pointer;">-</button>
                        <span style="color: white; min-width: 40px; text-align: center;">${item.quantity}</span>
                        <button onclick="updateQuantity(${index}, 1)" style="background: rgba(255,255,255,0.1); border: 1px solid #333; color: white; width: 30px; height: 30px; border-radius: 8px; cursor: pointer;">+</button>
                    </div>
                </div>
                <div style="flex: 1; text-align: right;">
                    <strong style="color: var(--gold);">Rp ${formatRupiah(itemTotal)}</strong>
                </div>
                <div style="margin-left: 15px;">
                    <button onclick="removeItem(${index})" style="background: rgba(239,68,68,0.2); border: 1px solid #ef4444; color: #ef4444; padding: 8px 12px; border-radius: 8px; cursor: pointer;">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    const shipping = subtotal >= 3000000 ? 0 : 50000;
    const total = subtotal + shipping;
    
    html += `
        <div style="padding: 24px; background: #0a0a0a;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: rgba(255,255,255,0.7);">
                <span>Subtotal</span>
                <span>Rp ${formatRupiah(subtotal)}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: rgba(255,255,255,0.7);">
                <span>Shipping</span>
                <span>${shipping === 0 ? 'FREE' : 'Rp ' + formatRupiah(shipping)}</span>
            </div>
            <div style="height: 1px; background: rgba(255,255,255,0.1); margin: 15px 0;"></div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 1.2rem;">
                <strong style="color: white;">Total</strong>
                <strong style="color: var(--gold);">Rp ${formatRupiah(total)}</strong>
            </div>
            <button onclick="checkout()" style="background: var(--gold); border: none; color: #000; padding: 14px 24px; border-radius: 12px; cursor: pointer; width: 100%; font-weight: 700; font-size: 1rem;">
                Proceed to Checkout
            </button>
            <button onclick="clearCart()" style="background: transparent; border: 1px solid rgba(255,255,255,0.2); color: white; padding: 12px 24px; border-radius: 12px; cursor: pointer; width: 100%; margin-top: 10px;">
                Clear Cart
            </button>
        </div>
    `;
    
    html += '</div>';
    container.innerHTML = html;
}

function updateQuantity(index, delta) {
    let cart = JSON.parse(localStorage.getItem('my_cart') || '[]');
    const newQuantity = cart[index].quantity + delta;
    
    if (newQuantity < 1) return;
    if (newQuantity > 99) return;
    
    cart[index].quantity = newQuantity;
    localStorage.setItem('my_cart', JSON.stringify(cart));
    
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartBadge = document.getElementById('cartCount');
    if (cartBadge) cartBadge.textContent = totalItems;
    
    loadCart(); // Refresh tampilan
}

function removeItem(index) {
    let cart = JSON.parse(localStorage.getItem('my_cart') || '[]');
    cart.splice(index, 1);
    localStorage.setItem('my_cart', JSON.stringify(cart));
    
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartBadge = document.getElementById('cartCount');
    if (cartBadge) cartBadge.textContent = totalItems;
    
    loadCart();
}

function clearCart() {
    if (confirm('Clear all items from cart?')) {
        localStorage.removeItem('my_cart');
        const cartBadge = document.getElementById('cartCount');
        if (cartBadge) cartBadge.textContent = 0;
        loadCart();
    }
}

function checkout() {
    const cart = JSON.parse(localStorage.getItem('my_cart') || '[]');
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }
    alert('Thank you for shopping! (Demo mode - Checkout successful)');
    localStorage.removeItem('my_cart');
    const cartBadge = document.getElementById('cartCount');
    if (cartBadge) cartBadge.textContent = 0;
    loadCart();
}

// Update badge saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const cart = JSON.parse(localStorage.getItem('my_cart') || '[]');
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartBadge = document.getElementById('cartCount');
    if (cartBadge) cartBadge.textContent = totalItems;
    loadCart();
});
</script>
@endsection