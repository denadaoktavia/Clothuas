

<?php $__env->startSection('title', 'Checkout - Cloth'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="checkoutPage">
    <h1 class="text-4xl font-bold mb-8">Checkout</h1>
    
    <!-- Empty Cart Redirect -->
    <template x-if="Object.keys(cart).length === 0">
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h2 class="text-2xl font-bold mb-2">Your cart is empty</h2>
            <p class="text-gray-600 mb-6">Please add items to your cart before checkout</p>
            <a href="/" class="inline-block bg-black text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                Start Shopping
            </a>
        </div>
    </template>
    
    <!-- Checkout Form -->
    <template x-if="Object.keys(cart).length > 0">
        <form @submit.prevent="processCheckout">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <h2 class="text-2xl font-bold mb-6">Shipping Information</h2>
                        
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" 
                                       id="name" 
                                       x-model="formData.name"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                            </div>
                            
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" 
                                       id="phone" 
                                       x-model="formData.phone"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                            </div>
                            
                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Shipping Address *</label>
                                <textarea id="address" 
                                          x-model="formData.address"
                                          required
                                          rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Items Preview -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 mt-6">
                        <h2 class="text-2xl font-bold mb-6">Order Items</h2>
                        
                        <div class="space-y-4">
                            <template x-for="(item, id) in cart" :key="id">
                                <div class="flex gap-4 pb-4 border-b border-gray-200 last:border-0">
                                    <div class="w-20 h-20 shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                                        <img :src="item.image ? '/storage/' + item.image : 'https://via.placeholder.com/80'" 
                                             :alt="item.name" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    
                                    <div class="flex-1">
                                        <h3 class="font-semibold" x-text="item.name"></h3>
                                        <p class="text-gray-600 text-sm">Qty: <span x-text="item.quantity"></span></p>
                                        <p class="font-bold mt-1" x-text="'Rp ' + formatPrice(item.price * item.quantity)"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
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
                            <div class="flex justify-between text-gray-600">
                                <span>Tax</span>
                                <span class="font-medium">Rp 0</span>
                            </div>
                            <hr class="my-4">
                            <div class="flex justify-between text-xl font-bold">
                                <span>Total</span>
                                <span x-text="'Rp ' + formatPrice(calculateSubtotal())"></span>
                            </div>
                        </div>
                        
                        <button type="submit" 
                                :disabled="isProcessing"
                                class="w-full bg-black text-white py-3 rounded-full font-medium hover:bg-gray-800 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!isProcessing">Place Order</span>
                            <span x-show="isProcessing">Processing...</span>
                        </button>
                        
                        <a href="<?php echo e(route('cart.index')); ?>" 
                           class="w-full border-2 border-gray-200 text-center py-3 rounded-full font-medium hover:bg-gray-50 transition mt-3 block">
                            Back to Cart
                        </a>
                        
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Note:</span> Your order will be processed after clicking "Place Order"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </template>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('checkoutPage', () => ({
        cart: {},
        formData: {
            name: '',
            phone: '',
            address: ''
        },
        isProcessing: false,
        
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
        
        async processCheckout() {
            if (this.isProcessing) return;
            
            // Validate form
            if (!this.formData.name || !this.formData.phone || !this.formData.address) {
                alert('Please fill all required fields');
                return;
            }
            
            this.isProcessing = true;
            
            try {
                // Prepare order data
                const orderData = {
                    name: this.formData.name,
                    phone: this.formData.phone,
                    address: this.formData.address,
                    sub_total: this.calculateSubtotal(),
                    total: this.calculateSubtotal(),
                    items: Object.values(this.cart).map(item => ({
                        product_id: item.id,
                        product_name: item.name,
                        quantity: item.quantity,
                        price: item.price,
                        subtotal: item.price * item.quantity
                    }))
                };
                
                // Send to server
                const response = await fetch('<?php echo e(route("checkout.process")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(orderData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Clear cart
                    localStorage.removeItem('cart');
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                    
                    // Show success message
                    alert(`Order placed successfully! Order ID: #${data.order_id}`);
                    
                    // Redirect to home
                    window.location.href = '/';
                } else {
                    alert(data.message || 'Something went wrong. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to process order. Please try again.');
            } finally {
                this.isProcessing = false;
            }
        }
    }));
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cloth\resources\views/pages/checkout.blade.php ENDPATH**/ ?>