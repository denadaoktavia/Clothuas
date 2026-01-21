@extends('layout.app')

@section('title', 'Cloth')

@section('content')
<!-- BANNER -->
<section class="bg-linear-to-br from-gray-50 to-gray-100" id="shop">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-6">
                <h1 class="text-5xl lg:text-6xl font-bold leading-tight">
                    FIND CLOTHES<br/>
                    THAT MATCHES<br/>
                    YOUR STYLE
                </h1>
                <p class="text-gray-600 text-lg max-w-md">
                    Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.
                </p>
                <button class="bg-black text-white px-12 py-4 rounded-full font-medium hover:bg-gray-800 transition">
                    Shop Now
                </button>
                
                <!-- Stats -->
                <div class="flex flex-wrap gap-8 pt-8">
                    <div>
                        <div class="text-3xl font-bold">200+</div>
                        <div class="text-gray-600 text-sm">International Brands</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">2,000+</div>
                        <div class="text-gray-600 text-sm">High-Quality Products</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">30,000+</div>
                        <div class="text-gray-600 text-sm">Happy Customers</div>
                    </div>
                </div>
            </div>
            
            <!-- Right Image -->
            <div class="relative">
                <img src="{{asset('images/banner.png')}}" 
                     alt="Fashion Banner" 
                     class="rounded-3xl w-full h-150 object-cover">
                <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-black rounded-full flex items-center justify-center">
                    <span class="text-white text-2xl">✦</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Brands Section -->
<section class="bg-black py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center items-center gap-12">
            <div>
                <img src="{{asset('images/calvinklein-logo-1 1.png')}}" alt="Brand Logo">
            </div>               
            <div>
                <img src="{{asset('images/gucci-logo-1 1.png')}}" alt="Brand Logo">
            </div>               
            <div>
                <img src="{{asset('images/prada-logo-1 1.png')}}" alt="Brand Logo">
            </div>               
            <div>
                <img src="{{asset('images/versace-logo-1 1.png')}}" alt="Brand Logo">
            </div>               
            <div>
                <img src="{{asset('images/zara-logo-1 1.png')}}" alt="Brand Logo">
            </div>               
        </div>
    </div>
</section>

<!-- New Arrivals Section -->
<section class="py-20" id="new-arrivals" x-data="productSection">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-12">NEW ARRIVALS</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($newArrivals as $product)
            <div class="product-card bg-white rounded-2xl overflow-hidden border border-gray-100">
                <a href="/product/{{ $product->slug }}" class="block">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400' }}" 
                             alt="{{ $product->name }}" 
                             class="product-image w-full h-full object-cover cursor-pointer">
                    </div>
                </a>
                <div class="p-4 space-y-2">
                    <h3 class="font-semibold text-lg truncate">{{ $product->name }}</h3>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-sm text-gray-500">
                        Stock: <span class="font-medium {{ $product->stock < 10 ? 'text-red-500' : 'text-green-600' }}">
                            {{ $product->stock }}
                        </span>
                    </div>
                    <button 
                        @click="addToCart({
                            id: {{ $product->id }},
                            name: '{{ addslashes($product->name) }}',
                            price: {{ $product->price }},
                            image: '{{ $product->image }}',
                            slug: '{{ $product->slug }}',
                            stock: {{ $product->stock }}
                        })"
                        class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition mt-2">
                        Add to Cart
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="/shop" class="inline-block border-2 border-gray-200 px-12 py-3 rounded-full font-medium hover:bg-gray-50 transition">
                View All
            </a>
        </div>
    </div>
</section>

<!-- Divider -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <hr class="border-gray-200">
</div>

<!-- Top Selling Section -->
<section class="py-20" id="top-selling" x-data="productSection">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-12">TOP SELLING</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($topSelling as $product)
            <div class="product-card bg-white rounded-2xl overflow-hidden border border-gray-100">
                <a href="/product/{{ $product->slug }}" class="block">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400' }}" 
                             alt="{{ $product->name }}" 
                             class="product-image w-full h-full object-cover cursor-pointer">
                    </div>
                </a>
                <div class="p-4 space-y-2">
                    <h3 class="font-semibold text-lg truncate">{{ $product->name }}</h3>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-sm text-gray-500">
                        Stock: <span class="font-medium {{ $product->stock < 10 ? 'text-red-500' : 'text-green-600' }}">
                            {{ $product->stock }}
                        </span>
                    </div>
                    <button 
                        @click="addToCart({
                            id: {{ $product->id }},
                            name: '{{ addslashes($product->name) }}',
                            price: {{ $product->price }},
                            image: '{{ $product->image }}',
                            slug: '{{ $product->slug }}',
                            stock: {{ $product->stock }}
                        })"
                        class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition mt-2">
                        Add to Cart
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="/shop" class="inline-block border-2 border-gray-200 px-12 py-3 rounded-full font-medium hover:bg-gray-50 transition">
                View All
            </a>
        </div>
    </div>
</section>

<!-- Browse by Category -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-12">BROWSE BY CATEGORY</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($categories as $index => $category)
            <a href="/category/{{ $category->slug }}" 
               class="relative group overflow-hidden rounded-3xl bg-white hover:shadow-xl transition h-48">
                <div class="absolute inset-0 bg-linear-to-br from-gray-100 to-gray-200 group-hover:scale-105 transition"></div>
                <div class="relative z-10 p-8 flex items-start justify-between h-full">
                    <h3 class="text-3xl font-bold">{{ $category->name }}</h3>
                    <span class="text-sm text-gray-600">{{ $category->products_count }} items</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('productSection', () => ({
        addToCart(product) {
            // Get existing cart from localStorage
            let cart = JSON.parse(localStorage.getItem('cart') || '{}');
            
            // Check if product already in cart
            if (cart[product.id]) {
                // Check stock limit
                if (cart[product.id].quantity >= product.stock) {
                    alert('Stock tidak mencukupi!');
                    return;
                }
                cart[product.id].quantity++;
            } else {
                cart[product.id] = {
                    ...product,
                    quantity: 1
                };
            }
            
            // Save to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            
            // Dispatch event to update cart count in navbar
            window.dispatchEvent(new CustomEvent('cart-updated'));
            
            // Show success notification
            this.showNotification('Product added to cart!');
        },
        
        showNotification(message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'fixed top-20 right-4 bg-black text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-in';
            notification.textContent = message;
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('opacity-0', 'transition-opacity');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    }));
});
</script>

<style>
@keyframes slide-in {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-in {
    animation: slide-in 0.3s ease-out;
}
</style>
@endpush
@endsection