<script setup>
import { ref, watch } from 'vue';

const emits = defineEmits(['setPrice']);

const props = defineProps({
    min_price: String,
    max_price: String,
});

const selectedMin = ref(props.min_price);
const selectedMax = ref(props.max_price);

const selectPrice = () => {
    emits('setPrice', { 
        selectedMin: selectedMin.value,
        selectedMax: selectedMax.value
    })
};

watch(() => props.min_price, () => {    
    selectedMin.value = props.min_price 
})

watch(() => props.max_price, () => {    
    selectedMax.value = props.max_price 
})
</script>

<template>
    <section class="p-6 pb-0">
        <span class="block font-medium text-xs uppercase mb-4">Price</span>

        <div>
            <div class="flex items-center justify-between space-x-2">
                <input
                    type="number"
                    step="5"
                    min="0"
                    v-model="selectedMin"
                    placeholder="Min"
                    class="w-full bg-zinc-200 text-zinc-600 placeholder-zinc-400 rounded border-none focus:ring focus:ring-zinc-300 focus:ring-opacity-80 text-xs"
                />
                <input
                    type="number"
                    step="5"
                    min="0"
                    v-model="selectedMax"
                    placeholder="Max"
                    class="w-full bg-zinc-200 text-zinc-600 placeholder-zinc-400 rounded border-none focus:ring focus:ring-zinc-300 focus:ring-opacity-80 text-xs"
                />
            </div>
            <button
                @click="selectPrice()"
                class="text-xs bg-c-green-600 hover:bg-c-green-300 max-w-max py-2 px-4 text-white mt-3 rounded"
            >
                Apply
            </button>
        </div>
    </section>
</template>
