<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import Bar from '@/Components/Dashboard/Bar.vue'
import pickBy from 'lodash/pickBy'

const props = defineProps({
    orders: Object,
    lastOrder: Object,
    timespan: String,
    chartData: Object
});

const filters = ref({
    timespan: props.timespan
})

const productImage = (product) => {
    let preview = product.images.find(image => {
        return image.is_preview;
    });

    return '/images/' + preview.url;
}

watch(filters.value, value => {
    Inertia.get(route('dashboard'), pickBy(value), { preserveState: true })
})
</script>

<template>
    <DashboardLayout>
        <Head title="Dashboard" />

            <header class="flex justify-between items-center mb-8">
                <h2 class="font-medium uppercase text-2xl">Dashboard</h2>

                <div>
                    <select v-model="filters.timespan" class="border-none shadow shadow-zinc-200 rounded text-xs focus:border-transparent focus:ring focus:ring-zinc-300 focus:ring-opacity-80">
                        <option value="current_week">Current Week</option>
                        <option value="last_week">Last week</option>
                        <option value="last_month">Last month</option>
                    </select>
                </div>
            </header>

            <div class="space-y-14">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl shadow shadow-zinc-200 px-3 py-5 xl:px-4 xl:py-6 flex items-center space-x-2.5 xl:space-x-4">
                        <div class="bg-c-green-100 bg-opacity-50 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package flex-none w-6 h-6 xl:w-7 xl:h-7 text-c-green-300"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        </div>
                        <div class="flex flex-col xl:space-y-1">
                            <span class="text-zinc-500 text-[13px] xl:text-sm leading-tight">Orders placed</span>
                            <span class="font-medium text-sm xl:text-base">{{ orders ? orders.orders_placed : 0 }}</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow shadow-zinc-200 px-3 py-5 xl:px-4 xl:py-6 flex items-center space-x-2.5 xl:space-x-4">
                        <div class="bg-c-green-100 bg-opacity-50 rounded-full p-2">
                            <svg class="w-6 h-6 xl:w-7 xl:h-7 flex-none text-c-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <div class="flex flex-col xl:space-y-1">
                            <span class="text-zinc-500 text-[13px] xl:text-sm leading-tight">Total spent</span>
                            <span class="font-medium text-sm xl:text-base">€{{ orders ? orders.total_spent : 0 }}</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow shadow-zinc-200 px-3 py-5 xl:px-4 xl:py-6 flex items-center space-x-2.5 xl:space-x-4">
                        <div class="bg-c-green-100 bg-opacity-50 rounded-full p-2">
                            <svg class="w-[21px] h-[21px] xl:w-[25px] xl:h-[25px] flex-none text-c-green-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M21,20H20V5a1,1,0,0,0-2,0V20H16V13a1,1,0,0,0-2,0v7H12V9a1,1,0,0,0-2,0V20H8V17a1,1,0,0,0-2,0v3H4V3A1,1,0,0,0,2,3V21a1,1,0,0,0,1,1H21a1,1,0,0,0,0-2Z"/></svg>
                        </div>
                        <div class="flex flex-col xl:space-y-1">
                            <span class="text-zinc-500 text-[13px] xl:text-sm leading-tight">Avg expense</span>
                            <span class="font-medium text-sm xl:text-base">€{{ orders ? orders.avg_expense : 0 }}</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow shadow-zinc-200 px-3 py-5 xl:px-4 xl:py-6 flex items-center space-x-2.5 xl:space-x-4">
                        <div class="bg-c-green-100 bg-opacity-50 rounded-full p-2">
                            <svg class="w-5 h-5 xl:w-[24px] xl:h-[24px] flex-none text-c-green-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M7,16a1.5,1.5,0,0,0,1.5-1.5.77.77,0,0,0,0-.15l2.79-2.79.23,0,.23,0,1.61,1.61s0,.05,0,.08a1.5,1.5,0,1,0,3,0v-.08L20,9.5h0A1.5,1.5,0,1,0,18.5,8a.77.77,0,0,0,0,.15l-3.61,3.61h-.16L13,10a1.49,1.49,0,0,0-3,0L7,13H7a1.5,1.5,0,0,0,0,3Zm13.5,4H3.5V3a1,1,0,0,0-2,0V21a1,1,0,0,0,1,1h18a1,1,0,0,0,0-2Z"/></svg>
                        </div>
                        <div class="flex flex-col xl:space-y-1">
                            <span class="text-zinc-500 text-[13px] xl:text-sm leading-tight">Max expense</span>
                            <span class="font-medium text-sm xl:text-base">€{{ orders ? orders.max_expense : 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:flex lg:space-x-4 lg:items-start space-y-10 lg:space-y-0 mt-8">
                <section class="lg:w-[70%] bg-white rounded-xl shadow shadow-zinc-200 px-4 py-6">
                    <Bar :data="chartData.data"></Bar>
                </section>
                <section class="lg:w-[30%]">
                    <div v-if="lastOrder" class="bg-white rounded-xl shadow shadow-zinc-200 px-4 py-6">
                        <header class="flex justify-between items-start">
                            <div>
                                <span class="font-medium text-base">Last order</span>
                                <span class="text-xs text-zinc-500 block">{{ $date(lastOrder.created_at).format('YYYY-MM-DD HH:mm') }}</span>
                            </div>

                            <span class="px-3 py-0.5 text-xs rounded-full bg-c-green-100 text-c-green-600">{{ lastOrder.status }}</span>
                        </header>

                        <div
                            v-for="product in lastOrder.products"
                            :key="product.id"
                            class="flex items-center space-x-4 my-4">

                                <Link :href="route('product.show', { slug: product.slug })" class="w-16 h-20 flex-none">
                                    <img :src="productImage(product)" alt="product_image" class="w-full h-full object-cover">
                                </Link>
                            
                                <div class="w-full">
                                    <span class="block text-sm font-medium leading-tight mb-1">{{ product.name }}</span>
                                    <span class="text-xs text-zinc-500 mr-2">x{{ product.pivot.quantity }}</span>
                                    <span class="text-xs">€{{ product.price }}</span>
                                </div>
                        </div>

                        <div class="flex justify-end">
                            <span class="bg-zinc-100 p-2 max-w-max rounded block font-medium text-sm">€{{ lastOrder.total }}</span>
                        </div>
                    </div>
                    <div v-else>
                        <div class="bg-white rounded-xl shadow shadow-zinc-200 px-4 py-6">
                            <span class="font-medium text-base block mb-2">Last order</span>
                            <span class="text-xs text-zinc-500 block">Your last order will appear here.</span>
                        </div>
                    </div>
                </section>
            </div>
    </DashboardLayout>
</template>
