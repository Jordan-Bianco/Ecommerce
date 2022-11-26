<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import pickBy from 'lodash/pickBy'

const props = defineProps({
    orders: Array
})

const selectedOrder = ref({});
const filters = ref({
    sortBy: ''
});

const selectOrder = (order) => {
    selectedOrder.value = order
}

const resetSelectOrder = () => {
    selectedOrder.value = {}
}

watch(filters.value, value => {
    Inertia.get(route("order.index"), pickBy(value), {
        preserveState: true,
        replace: true,
    });
});

const productImage = (product) => {
    let preview = product.images.find(image => {
        return image.is_preview;
    });

    return '/images/' + preview.url;
}
</script>
    
<template>
    <DashboardLayout>
        <Head title="My orders" />
        
        <header class="flex items-center justify-between mb-8">
            <h2 class="font-medium uppercase text-2xl">My orders</h2>
            
            <select v-model="filters.sortBy" class="border-none shadow shadow-zinc-200 rounded text-xs focus:border-transparent focus:ring focus:ring-zinc-300 focus:ring-opacity-80">
                <option value="">Sort by</option>
                <option value="total_desc">Total desc</option>
                <option value="total_asc">Total asc</option>
            </select>
        </header>

        <table class="w-full">
            <tr class="w-full bg-white border-b">
                <th class="text-left font-medium text-xs px-4 py-3 w-16">ID</th>
                <th class="text-left font-medium text-xs px-4 py-3 ">Purchased on</th>
                <th class="text-right font-medium text-xs px-4 py-3 ">Total</th>
                <th class="text-center font-medium text-xs px-4 py-3 ">Status</th>
                <th class="text-center font-medium text-xs px-4 py-3 ">Items</th>
                <th></th>
            </tr>
            <tr
                v-for="order in orders"
                :key="order.id"
                class="even:bg-zinc-100 odd:bg-white text-sm border-b">
                    <td class="px-4 py-3 text-left ">
                        <span class="text-xs font-medium">#{{ order.id }}</span>
                    </td>
                    <td class="px-4 py-3 text-left ">
                        <span class="text-xs text-zinc-500">{{ $date(order.created_at).format('YYYY-MM-DD HH:mm') }}</span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <span>€{{ order.total }}</span>
                    </td>
                    <td class="px-4 py-3 text-center ">
                        <span
                            :class="{ 'bg-c-green-100 text-c-green-600' : order.status === 'Paid' }"
                            class="px-3 py-0.5 text-xs rounded-full">
                                {{ order.status }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center ">
                        <span>{{ order.products.length }}</span>
                    </td>
                    <td>
                        <svg
                            @click="selectOrder(order)"
                            class="w-5 h-5 text-zinc-500 hover:text-zinc-700 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                    </td>
            </tr>
        </table>

        <div
            class="bg-white w-80 fixed p-4 right-0 top-0 bottom-0 transform transition duration-150 ease-linear z-20"
            :class="{ 'translate-x-full' : Object.keys(selectedOrder).length === 0 }">

                <header class="mb-6">
                    <span class="font-medium block">Order number: {{ selectedOrder.id }}</span>
                    <span class="text-xs text-zinc-500 -mt-0.5 block">{{ $date(selectedOrder.created_at).format('YYYY-MM-DD HH:mm') }}</span>
                </header>

                <div class="bg-zinc-100 p-4 mb-4 rounded">
                    <span class="block text-sm font-medium mb-4">Order details</span>
                    <div
                        v-for="product, index in selectedOrder.products"
                        :key="index"
                        class="bg-zinc-100 rounded pb-4 flex items-start space-x-3">

                            <div class="w-16 h-20 flex-none">
                                <img :src="productImage(product)" alt="" class="w-full h-full object-cover">
                            </div>

                            <div>
                                <span class="block font-medium text-sm">{{ product.name }}</span>
                                <span class="block text-zinc-500 text-sm">x{{ product.pivot.quantity }}</span>
                                <span class="block text-zinc-500 text-sm">€{{ product.pivot.unit_price }}</span>
                            </div>
                    </div>
                </div>

                <div class="bg-zinc-100 rounded p-4 flex items-center justify-between mt-4">
                    <span class="text-zinc-500 uppercase text-xs">Total</span>
                    <span class="font-medium block">€{{ selectedOrder.total }}</span>
                </div>
        </div>

         <div
            v-if="Object.keys(selectedOrder).length > 0 "
            @click="resetSelectOrder()"
            class="bg-black fixed inset-0 opacity-10 z-10"
        ></div>

    </DashboardLayout>
</template>