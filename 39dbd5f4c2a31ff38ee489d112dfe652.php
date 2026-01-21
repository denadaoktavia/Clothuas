<nav class="border-b border-gray-200 sticky top-0 bg-white/95 backdrop-blur-sm z-50" x-data="navCart">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="shrink-0">
                <a href="/" class="text-2xl font-bold tracking-tight">CLOTH</a>
            </div>
            
            <!-- Navigation -->
            <div class="hidden md:flex space-x-8">
                <a href="/#shop" class="text-sm font-medium text-black hover:text-gray-600 transition">Shop</a>
                <a href="/#new-arrivals" class="text-sm font-medium text-gray-600 hover:text-black transition">New Arrivals</a>
                <a href="/#top-selling" class="text-sm font-medium text-gray-600 hover:text-black transition">Top Selling</a>
            </div>
            
            <!-- Cart -->
            <div class="flex items-center">
                <a href="<?php echo e(route('cart.index')); ?>" class="relative p-2 hover:bg-gray-100 rounded-full transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span x-show="cartCount > 0" 
                          x-text="cartCount" 
                          class="absolute -top-1 -right-1 bg-black text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                    </span>
                </a>
            </div>
        </div>
    </div>
</nav>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('navCart', () => ({
        cartCount: 0,
        
        init() {
            this.updateCartCount();
            // Listen for cart updates
            window.addEventListener('cart-updated', () => {
                this.updateCartCount();
            });
        },
        
        updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart') || '{}');
            this.cartCount = Object.keys(cart).length;
        }
    }));
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\cloth\resources\views/components/navbar.blade.php ENDPATH**/ ?>