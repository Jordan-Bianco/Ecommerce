<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    sortBy: String
})

const emits = defineEmits(['setSortBy']);

const sortField = ref(props.sortBy)

watch(sortField, value => {
    emits('setSortBy', value)
})
</script>
    
<template>
    <div>
        <select v-model="sortField" class="border border-zinc-300 rounded text-xs focus:border-transparent focus:ring focus:ring-zinc-300 focus:ring-opacity-80">
            <option value="">Sort by</option>
            <option value="best_selling">Best selling</option>
            <option value="price_desc">Price desc</option>
            <option value="price_asc">Price asc</option>
        </select>
    </div>
</template>