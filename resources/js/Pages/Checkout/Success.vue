<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';

const props = defineProps({
    customer: Object,
    order: Object
});

const productImage = (product) => {
    let preview = product.images.find(image => {
        return image.is_preview;
    });

    return '/images/' + preview.url;
}
</script>
    
<template>
    <ShopLayout>
        <div class="max-w-lg mx-auto">
            <div class="flex items-center space-x-3 my-10">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-xs text-zinc-500">Order #{{ order.id }}</p>
                    <p>Thank you {{ customer.name }}!</p>
                </div>
            </div>
            <div>
                <p class="pb-8 text-sm">Your order is confirmed. You can check your order in your
                    <Link :href="route('order.index')" class="text-c-green-300">dashboard</Link>
                </p>

                <div class="bg-zinc-100 p-4 mb-4 rounded">
                    <span class="block text-sm font-medium mb-4">Shipping details</span>
                    <span class="block text-sm">{{ order.detail.customer_name }}</span>
                    <span class="block text-sm">{{ order.detail.address1 }}</span>
                    <span class="block text-sm">{{ order.detail.address2 }}</span>
                    <span class="block text-sm">{{ order.detail.city }}, {{ order.detail.province + ',' }} {{ order.detail.country }}</span>
                    <span class="block text-sm">{{ order.detail.postalcode }}</span>
                </div>

                <div class="bg-zinc-100 p-4 mb-4 rounded">
                    <span class="block text-sm font-medium mb-4">Order details</span>
                    <div
                        v-for="product in order.products"
                        :key="product.id"
                        class="flex items-start space-x-4 mb-4">
                            
                            <Link :href="route('product.show', { slug: product.slug })" class="w-16 h-20 flex-none">
                                <img :src="productImage(product)" alt="product_image" class="w-full h-full object-cover">
                            </Link>
                        
                            <div class="w-full">
                                <span class="block text-sm font-medium">{{ product.name }}</span>
                                <span class="block text-sm text-zinc-500">x{{ product.pivot.quantity }}</span>
                                <span class="text-sm"><span class="text-c-green-600 font-medium">€</span>{{ product.price }}</span>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>