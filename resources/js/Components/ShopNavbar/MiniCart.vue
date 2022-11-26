<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    user: Object,
});

const showCartMenu = ref(false);
const processing = ref(false);
const clicked = ref(false)

const toggleCartMenu = () => {
    if (!props.user) {
        Inertia.get("login");
    }

    showCartMenu.value = !showCartMenu.value;
};

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

const saveForLater = (id) => {
    Inertia.post(route('cart.saveForLater', {id: id}))
}

const total = (cart) => {
    let total = 0;

    cart.filter(function (product) {
        total += product.price * product.pivot.quantity;
    });

    return total.toFixed(2);
};

const productImage = (product) => {
    let preview = product.images.find(image => {
        return image.is_preview;
    });

    return '/images/' + preview.url;
}
</script>

<template>
    <div>
        <div class="relative">
            <div
                @click="toggleCartMenu()"
                :class="{ 'bg-zinc-200' : showCartMenu }"
                class="hover:bg-zinc-200 p-2 rounded-full transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag flex-none text-zinc-600 w-[18px] h-[18px]"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            </div>

            <div
                v-if="props.user && $page.props.cart.length > 0"
                class="absolute top-0 -right-1 w-4 h-4 bg-c-green-600 text-white flex items-center justify-center text-xxs rounded-full">
                    {{ $page.props.cart.length }}
            </div>

        <transition name="fade">
            <div
                v-if="showCartMenu && props.user"
                class="absolute mt-2 right-0 bg-white w-[272px] max-h-max text-xs shadow-md z-30 rounded-xl">
                    <header class="flex items-center justify-between p-4">
                        <span class="font-medium text-sm">Cart</span>
                        <Link
                            :href="route('cart.index')"
                            class="flex items-center space-x-0.5 text-zinc-500 max-w-max hover:text-c-green-300"
                        >
                            <span class="text-xs">View cart</span>
                            <svg class="w-4 h-4 text-zinc-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        </Link>
                    </header>

                <div
                    v-if="$page.props.cart.length > 0"
                    class="overflow-y-auto max-h-80 mx-4 my-2">
                    
                    <transition-group name="list">
                        <div
                            v-for="product in $page.props.cart"
                            :key="product.id"
                            class="flex items-start space-x-3 p-4 bg-zinc-100 rounded mb-2">

                            <!-- Product image -->
                            <Link
                                :href="route('product.show', { slug: product.slug })"
                                class="w-12 h-16 flex-none">
                                    <img :src="productImage(product)" alt="product_image" class="w-full h-full object-cover">
                            </Link>

                            <div class="w-full">
                                <div class="flex justify-between space-x-2">
                                    <span class="block font-medium text-xs">{{ product.name }}</span>

                                    <form @submit.prevent="saveForLater(product.id)">
                                        <button
                                            type="submit"
                                            title="Save for later"
                                            class="text-zinc-500 hover:text-zinc-800">
                                                <svg class="w-4 h-4 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                        </button>
                                    </form>
                                </div>

                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-sm"><span class="text-c-green-600 font-medium">€</span>{{ product.price }}</span>
                                    
                                    <div class="flex items-center space-x-2">
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
                                </div>
                            </div>
                        </div>
                    </transition-group>
                </div>
                <div v-else>
                    <p class="p-4">Your cart is empty</p>
                </div>
                <footer v-if="$page.props.cart.length > 0" class="p-4">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-zinc-500 text-xs">Total</span>
                        <span class="text-sm"><span class="text-c-green-600 font-medium">€</span>{{ total($page.props.cart) }}</span>
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
                </footer>
            </div>
        </transition>
        </div>

        <div
            v-if="showCartMenu && user"
            class="bg-black fixed inset-0 opacity-10 z-20"
            @click="toggleCartMenu()"
        ></div>
    </div>
</template>
