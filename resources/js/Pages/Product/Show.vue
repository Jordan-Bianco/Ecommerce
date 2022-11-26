<script setup>
import ShopLayout from "@/Layouts/ShopLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";
import {usePage} from '@inertiajs/inertia-vue3'

const props = defineProps({
    product: Object,
});

const processing = ref(false);

const addToCart = () => {
    Inertia.post(route("cart.store", { id: props.product.id }), [], {
        onStart: () => { processing.value = true; },
        onFinish: () => { processing.value = false; }
    });
};

const inWhishlist = (id) => {
    return usePage().props.value.whishlist.find(product => { return product.id === id }) ? true : false;
}

const toggleWhishlist = () => {
    Inertia.post(route("whishlist.toggle", { id: props.product.id }));
};

const productImage = () => {
    let preview = props.product.images.find(image => {
        return image.is_preview;
    });

    return '/images/' + preview.url;
}
</script>

<template>
    <ShopLayout>
        <Head :title="product.name" />

        <div class="max-w-2xl mx-auto sm:flex sm:space-x-8 mt-8">
            <!-- Product image -->
            <div class="w-full sm:w-1/2 h-96 flex-none">
                <img :src="productImage()" alt="product_image" class="w-full h-full object-cover">
            </div>

            <div class="mt-6 sm:mt-0">
                <h3 class="text-2xl font-medium mb-1">{{ product.name }}</h3>

                <form @submit.prevent="toggleWhishlist()" class="mb-4">
                    <button
                        type="submit"
                        class="flex items-center space-x-1"
                        :class="inWhishlist(product.id) ? 'text-red-500' : 'text-zinc-500 hover:text-red-500'">
                            <svg class="w-[17px] h-[17px] flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            <span class="block text-xs text-zinc-600">{{ inWhishlist(product.id) ? 'Remove from whishlist' : 'Add to whishlist' }}</span>
                        </button>
                </form>

                <span class="block text-zinc-500 text-sm mb-4">{{ product.category.name }}</span>
                
                <p class="text-xs text-zinc-500 mb-8">{{ product.description }}</p>

                <div class="flex items-start justify-between">
                    <span class="text-base"><span class="text-c-green-600 font-medium">€</span>{{ product.price }}</span>
                    
                    <form @submit.prevent="addToCart()">
                        <button
                            type="submit"
                            :disabled="processing"
                            :class="processing ? 'bg-c-green-300' : 'bg-c-green-600 hover:bg-c-green-300'"
                            class="text-white text-xxs w-32 py-3 rounded transition flex justify-center items-center space-x-2"
                        >
                            <svg v-if="!processing" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag flex-none w-[17px] h-[17px]"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            <span class="uppercase" v-if="!processing">Add to cart</span>
                            <svg v-else class="animate-spin-fast w-[17px] h-[17px] text-white" fill="currentColor" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                            <g> <path d="M256,512c-34.6,0-68.1-6.8-99.6-20.1C125.9,479,98.5,460.5,75,437s-42-50.9-54.9-81.4C6.8,324.1,0,290.5,0,256
                                    c0-9.9,8.1-18,18-18s18,8.1,18,18c0,29.7,5.8,58.5,17.3,85.6c11.1,26.2,26.9,49.8,47.1,70c20.2,20.2,43.8,36.1,69.9,47.1
                                    c27.1,11.5,55.9,17.3,85.6,17.3s58.5-5.8,85.6-17.3c26.2-11.1,49.8-27,70-47.2c20.2-20.2,36.1-43.8,47.1-69.9
                                    c11.5-27.1,17.3-55.9,17.3-85.6c0-29.7-5.8-58.5-17.3-85.6c-11.1-26.1-27.1-49.9-47.2-70c-20-20.1-43.8-36.1-69.9-47.1
                                    C314.5,41.8,285.7,36,256,36c-9.9,0-18-8.1-18-18s8.1-18,18-18c34.6,0,68.1,6.8,99.6,20.1C386.2,33,413.5,51.5,437,75
                                    s42,50.9,54.9,81.4c13.4,31.5,20.1,65.1,20.1,99.6c0,34.5-6.8,68.1-20.1,99.6C479,386.1,460.5,413.5,437,437s-50.9,42-81.4,54.9
                                    C324.1,505.3,290.6,512,256,512z"/>
                            </g>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>
