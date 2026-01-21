@extends('layout.app')

@section('title', 'Shopping Cart - Cloth')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="cartPage">
    <h1 class="text-4xl font-bold mb-8">Your Cart</h1>
    
    <!-- Empty Cart State -->
    <template x-if="Object.keys(cart).length === 0">
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h2 class="text-2xl font-bold mb-2">Your cart is empty</h2>
            <p class="text-gray-600 mb-6">Add some products to get started!</p>
            <a href="/" class="inline-block bg-black text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                Start Shopping
            </a>
        </div>
    </template>
    
    <!-- Cart Items -->
    <template x-if="Object.keys(cart).length > 0">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items List -->
            <div class="lg:col-span-2 space-y-4">
                <template x-for="(item, id) in cart" :key="id">
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 flex gap-6">
                        <!-- Product Image -->
                        <div class="w-24 h-24 shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                            <img :src="item.image ? '/storage/' + item.image : 'https://via.placeholder.com/96'" 
                                 :alt="item.name" 
                                 class="w-full h-full object-cover">
                        </div>
                        
                        <!-- Product Details -->
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-semibold text-lg mb-1" x-text="item.name"></h3>
                                <p class="text-gray-600 text-sm">Stock: <span x-text="item.stock"></span></p>
                            </div>
                            
                            <div class="flex items-center justify-between mt-4">
                                <!-- Quantity Controls -->
                                <div class="flex items-center gap-3 border border-gray-200 rounded-lg px-3 py-1">
                                    <button @click="updateQuantity(id, item.quantity - 1)" 
                                            class="text-gray-600 hover:text-black transition disabled:opacity-30"
                                            :disabled="item.quantity <= 1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <span class="font-medium w-8 text-center" x-text="item.quantity"></span>
                                    <button @click="updateQuantity(id, item.quantity + 1)" 
                                            class="text-gray-600 hover:text-black transition disabled:opacity-30"
                                            :disabled="item.quantity >= item.stock">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Price -->
                                <span class="text-xl font-bold" x-text="'Rp ' + formatPrice(item.price * item.quantity)"></span>
                            </div>
                        </div>
                        
                        <!-- Remove Button -->
                        <button @click="removeFromCart(id)" class="text-red-500 hover:text-red-700 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-200 p-6 sticky top-24">
                    <h2 class="text-2xl font-bold mb-6">Order Summary</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium" x-text="'Rp ' + formatPrice(calculateSubtotal())"></span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span class="font-medium">Free</span>
                        </div>
                        <hr class="my-4">
                        <div class="flex justify-between text-xl font-bold">
                            <span>Total</span>
                            <span x-text="'Rp ' + formatPrice(calculateSubtotal())"></span>
                        </div>
                    </div>
                    
                    <a href="{{ route('checkout') }}" 
                       class="w-full bg-black text-white py-3 rounded-full font-medium hover:bg-gray-800 transition text-center block">
                        Proceed to Checkout
                    </a>
                    
                    <a href="/" class="w-full border-2 border-gray-200 text-center py-3 rounded-full font-medium hover:bg-gray-50 transition mt-3 block">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </template>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('cartPage', () => ({
        cart: {},
        
        init() {
            this.loadCart();
        },
        
        loadCart() {
            this.cart = JSON.parse(localStorage.getItem('cart') || '{}');
        },
        
        calculateSubtotal() {
            let total = 0;
            for (let id in this.cart) {
                total += this.cart[id].price * this.cart[id].quantity;
            }
            return total;
        },
        
        formatPrice(price) {
            return new Intl.NumberFormat('id-ID').format(price);
        },
        
        updateQuantity(productId, newQuantity) {
            if (newQuantity < 1) return;
            
            if (newQuantity > this.cart[productId].stock) {
                alert('Stock tidak mencukupi!');
                return;
            }
            
            this.cart[productId].quantity = newQuantity;
            localStorage.setItem('cart', JSON.stringify(this.cart));
            window.dispatchEvent(new CustomEvent('cart-updated'));
        },
        
        removeFromCart(productId) {
            if (!confirm('Are you sure you want to remove this item?')) return;
            
            delete this.cart[productId];
            localStorage.setItem('cart', JSON.stringify(this.cart));
            window.dispatchEvent(new CustomEvent('cart-updated'));
        }
    }));
});
</script>
@endpush
@endsection