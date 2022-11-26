<script setup>
import ShopLayout from "@/Layouts/ShopLayout.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    products: Array,
});

const toggleWhishlist = (id) => {
    Inertia.post(route("whishlist.toggle", { id: id }));
};

const emptyWhishlist = () => {
    Inertia.delete(route("whishlist.destroy"));
};

const moveToCartFromWhishlist = (id) => {
    Inertia.post(route("whishlist.moveToCart", { id: id }));
};

const productImage = (product) => {
    let preview = product.images.find(image => {
        return image.is_preview;
    });

    return '/images/' + preview.url;
}
</script>

<template>
    <ShopLayout>
        <Head title="Whishlist" />

        <div class="max-w-lg mx-auto">
            <header class="py-6">
                <h2 class="text-2xl uppercase font-medium">Whishlist</h2>
                <div class="flex items-center justify-between">
                    <span
                        v-if="products.length > 0"
                        class="text-zinc-500 text-sm">You have {{ products.length }} {{ products.length === 1 ? "product" : "products" }} in your whishlist</span>
                    <span
                        v-else
                        class="text-zinc-500 text-sm">You have no items in your whishlist</span>
                
                        <form @submit.prevent="emptyWhishlist()" v-if="products.length > 0">
                            <button
                                type="submit"
                                class="text-zinc-500 text-xs hover:underline"
                            >
                                Empty whishlist
                            </button>
                        </form>
                </div>
            </header>

            <transition-group name="list">
                <div
                    v-for="product in products"
                    :key="product.id"
                    class="flex items-start space-x-4 mb-4 bg-zinc-100 rounded p-4">
                        <Link :href="route('product.show', { slug: product.slug })" class="w-20 h-24">
                            <img :src="productImage(product)" alt="product_image" class="w-full h-full object-cover">
                        </Link>

                        <div class="w-full">
                            <div class="flex items-start justify-between mb-2">
                                <span class="text-xs font-medium">{{ product.name }}</span>
                                
                                <form @submit.prevent="toggleWhishlist(product.id)">
                                    <button
                                        type="submit"
                                        class="text-red-500 flex items-center space-x-1">
                                            <svg class="w-[17px] h-[17px] flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                            <span class="block text-xs text-zinc-600">Remove from whishlist</span>
                                    </button>
                                </form>
                            </div>

                            <form @submit.prevent="moveToCartFromWhishlist(product.id)" class="mb-2">
                                <button
                                    type="submit"
                                    class="text-zinc-600 flex items-center space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag flex-none text-zinc-600 w-[17px] h-[17px]"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                        <span class="block text-xs text-zinc-600">Move to cart</span>
                                </button>
                            </form>

                            <span class="text-sm"><span class="text-c-green-600 font-medium">€</span>{{ product.price }}</span>
                        </div>
                </div>
            </transition-group>
        </div>
    </ShopLayout>
</template>
