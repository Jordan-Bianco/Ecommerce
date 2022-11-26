<script setup>
import { ref } from 'vue';
import ShopLayout from "@/Layouts/ShopLayout.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    products: Array,
    savedProducts: Array,
    total: String|Number,
});

const processing = ref(false);
const clicked = ref(false);

const increase = (id) => {
    Inertia.patch(route("cart.increase", { id: id }), [], {
        onStart: () => { processing.value = true; },
        onFinish: () => { processing.value = false; },
    });
};

const decrease = (id) => {
    Inertia.patch(route("cart.decrease", { id: id }), [], {
        onStart: () => { processing.value = true; },
        onFinish: () => { processing.value = false; },
    });
};

const removeItem = (id) => {
    Inertia.delete(route("cart.destroy", { id: id }));
};

const saveForLater = (id) => {
    Inertia.post(route('cart.saveForLater', {id: id}))
}

const moveToCart = (id) => {
    Inertia.post(route("cart.moveToCart", { id: id }));
};

const emptyCart = () => {
    Inertia.delete(route("cart.empty"));
};

const total = () => {
    return props.total;
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
        <Head title="Cart" />

        <div class="max-w-2xl mx-auto">
            <header class="py-6 border-b border-zinc-200">
                <h2 class="text-2xl uppercase font-medium">Shopping cart</h2>
                <div class="flex items-center justify-between">
                    <span
                        v-if="products.length > 0"
                        class="text-zinc-500 text-sm">You have {{ products.length }} {{ products.length === 1 ? "product" : "products" }} in your cart</span>
                
                    <p v-else class="text-zinc-500 text-sm">Your cart is empty. <Link :href="route('shop')" class="text-c-green-600">Continue shopping</Link></p>

                    <form @submit.prevent="emptyCart()" v-if="products.length > 0">
                        <button
                            type="submit"
                            class="text-zinc-500 text-xs hover:underline"
                        >
                            Empty cart
                        </button>
                    </form>
                </div>
            </header>

            <section v-if="products.length > 0">
                <table class="w-full my-5">
                    <tr class="">
                        <th class="text-left font-normal uppercase text-xxs text-zinc-400 pb-6">
                            Product details
                        </th>
                        <th class="text-left font-normal uppercase text-xxs text-zinc-400 pb-6">
                            Quantity
                        </th>
                        <th class="text-left font-normal uppercase text-xxs text-zinc-400 pb-6">
                            Price
                        </th>
                        <th class="text-left font-normal uppercase text-xxs text-zinc-400 pb-6 hidden sm:block">
                            Total
                        </th>
                    </tr>

                    <tr v-for="product in products" :key="product.id">
                        <td>
                            <div class="flex items-start space-x-4 mb-6">
                                <Link :href="route('product.show', { slug: product.slug })" class="w-20 h-24">
                                    <img :src="productImage(product)" alt="product_image" class="w-full h-full object-cover">
                                </Link>

                                <div class="flex flex-col justify-around">
                                    <span class="text-sm font-medium">{{ product.name }}</span>
                                    
                                    <div class="flex items-center space-x-2">
                                        <form @submit.prevent="removeItem(product.id)">
                                            <button
                                                type="submit"
                                                class="text-zinc-500 hover:underline text-xxs">
                                                    Remove
                                            </button>
                                        </form>
                                        <form @submit.prevent="saveForLater(product.id)">
                                            <button
                                                type="submit"
                                                class="text-zinc-500 hover:underline text-xxs"
                                            >
                                                Save for later
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-sm align-top">
                            <div class="flex flex-col sm:flex-row items-center sm:space-x-2 sm:space-y-0 space-y-1 ">
                                <form @submit.prevent="decrease(product.id)">
                                    <button
                                        type="submit"
                                        :disabled="processing"
                                        :class="processing ? 'bg-zinc-300' : 'bg-zinc-300 hover:bg-c-green-300 hover:text-white'"
                                        class="w-4 h-4 rounded flex items-center justify-center transition"
                                    >
                                        &minus;
                                    </button>
                                </form>
                                <span class="font-medium">{{ product.pivot.quantity }}</span>
                                <form @submit.prevent="increase(product.id)">
                                    <button
                                        type="submit"
                                        :disabled="processing"
                                        :class="processing ? 'bg-zinc-300' : 'bg-zinc-300 hover:bg-c-green-300 hover:text-white'"
                                        class="w-4 h-4 rounded flex items-center justify-center transition"
                                    >
                                        &plus;
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td class="text-sm align-top">
                            <span class="text-sm"><span class="text-c-green-600 font-medium">€</span>{{ product.price }}</span>
                        </td>
                        <td class="text-sm align-top hidden sm:block">
                            <span class="text-sm"><span class="text-c-green-600 font-medium">€</span>{{ (product.pivot.quantity * product.price).toFixed(2) }}</span>
                        </td>
                    </tr>
                </table>

                <footer class="flex justify-end py-6 border-t border-zinc-200">
                    <div class="space-y-3 w-1/3">
                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500 uppercase text-xs">Total</span>
                            <span class="text-sm"><span class="text-c-green-600 font-medium">€</span>{{ total() }}</span>
                        </div>

                        <Link
                            :href="route('checkout')"
                            method="post"
                            as="button"
                            @click="clicked = true"
                            class="flex justify-center items-center text-xxs bg-c-green-600 hover:bg-c-green-300 w-full py-3 text-white uppercase cursor-pointer rounded"
                        >
                            <span v-if="!clicked">checkout</span>
                            <svg v-else class="animate-spin-fast w-[16px] h-[16px] text-white" fill="currentColor" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g> <path d="M256,512c-34.6,0-68.1-6.8-99.6-20.1C125.9,479,98.5,460.5,75,437s-42-50.9-54.9-81.4C6.8,324.1,0,290.5,0,256
                                        c0-9.9,8.1-18,18-18s18,8.1,18,18c0,29.7,5.8,58.5,17.3,85.6c11.1,26.2,26.9,49.8,47.1,70c20.2,20.2,43.8,36.1,69.9,47.1
                                        c27.1,11.5,55.9,17.3,85.6,17.3s58.5-5.8,85.6-17.3c26.2-11.1,49.8-27,70-47.2c20.2-20.2,36.1-43.8,47.1-69.9
                                        c11.5-27.1,17.3-55.9,17.3-85.6c0-29.7-5.8-58.5-17.3-85.6c-11.1-26.1-27.1-49.9-47.2-70c-20-20.1-43.8-36.1-69.9-47.1
                                        C314.5,41.8,285.7,36,256,36c-9.9,0-18-8.1-18-18s8.1-18,18-18c34.6,0,68.1,6.8,99.6,20.1C386.2,33,413.5,51.5,437,75
                                        s42,50.9,54.9,81.4c13.4,31.5,20.1,65.1,20.1,99.6c0,34.5-6.8,68.1-20.1,99.6C479,386.1,460.5,413.5,437,437s-50.9,42-81.4,54.9
                                        C324.1,505.3,290.6,512,256,512z"/>
                                </g>
                                </svg>
                        </Link>
                    </div>
                </footer>
            </section>

            <section v-if="savedProducts.length > 0" class="mt-10">
                <header class="mb-5">
                    <h2 class="text-lg uppercase font-medium">Saved products</h2>
                    <span class="text-zinc-500 text-xs">You have {{ savedProducts.length }} {{ savedProducts.length === 1 ? "product" : "products" }} saved</span>
                </header>

                <transition-group name="list">
                    <div
                        v-for="product in savedProducts"
                        :key="product.id"
                        class="flex items-start space-x-4 mb-4 bg-zinc-100 rounded p-4">
                            <Link :href="route('product.show', { slug: product.slug })" class="w-16 h-20">
                                <img :src="productImage(product)" alt="product_image" class="w-full h-full object-cover">
                            </Link>

                            <div class="w-full">
                                <div class="sm:flex sm:items-start sm:justify-between sm:mb-2 sm:space-y-0 space-y-1">
                                    <span class="text-sm sm:text-xs font-medium">{{ product.name }}</span>
                                    <form @submit.prevent="removeItem(product.id)">
                                        <button
                                            type="submit"
                                            class="text-zinc-600 flex items-center space-x-1 hover:text-zinc-800">
                                                <svg class="w-4 h-4 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                                <span class="block text-xs text-zinc-600">Remove from saved for later</span>
                                        </button>
                                    </form>
                                </div>

                                <form @submit.prevent="moveToCart(product.id)" class="mb-2 mt-2 sm:mt-0">
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
                
            </section>
        </div>
    </ShopLayout>
</template>
