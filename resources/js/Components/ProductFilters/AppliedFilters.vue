<script setup>
import { ref, watch, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia';

import pickBy from 'lodash/pickBy'

const props = defineProps({
    filters: Object
})

const validFilters = ref({});

const removeFilter = (filter, value) => {
    if (value === null) {
        return props.filters[filter] = ''
    }

    props.filters[filter] = props.filters[filter].split(',');

    let index = props.filters[filter].indexOf(value);

    props.filters[filter].splice(index, 1);

    props.filters[filter] = props.filters[filter].join(',') 
}

onMounted(() => {
    validFilters.value = Object.assign({}, pickBy(props.filters));

    delete validFilters.value.search;
    delete validFilters.value.sortBy;
    delete validFilters.value.page;
}),

watch(() => Object.keys(pickBy(props.filters)), () => {
    validFilters.value = Object.assign({}, pickBy(props.filters));

    delete validFilters.value.search;
    delete validFilters.value.sortBy;
    delete validFilters.value.page;
})

const resetFilters = () => {
    Inertia.get(route("shop"))
}
</script>
    
<template>
<section
    v-if="Object.keys(validFilters).length !== 0"
    class="flex items-center space-x-2 my-4 flex-wrap gap-y-2">

        <button
            @click="resetFilters()"
            class="bg-zinc-200 text-zinc-500 hover:text-zinc-700 text-xs px-2.5 py-1 relative flex items-center space-x-1 rounded-full max-w-max">
                Remove all
        </button>  


        <div v-for="(value, filter) in validFilters" :key="filter">

            <div v-if="filter === 'category'" class="flex items-center space-x-2 relative">
                <div
                    v-for="val in value.split(',')"
                    :key="val"
                    class="bg-c-green-100 text-c-green-600 text-xs pl-2.5 pr-6 py-1 relative flex items-center space-x-1 rounded-full max-w-max">
                        <span>{{ val }}</span>
                        <span @click="removeFilter(filter, val)" class="absolute right-2 -bottom-[1px] text-lg cursor-pointer">&times;</span>
                </div>
            </div>

            <div v-if="filter === 'min_price'" class="relative">
                <div class="bg-c-green-100 text-c-green-600 text-xs pl-2.5 pr-6 py-1 relative flex items-center space-x-1 rounded-full max-w-max">
                    <span>Min €{{ value }}</span>
                    <span @click="removeFilter(filter, null)" class="absolute right-2 -bottom-[1px] text-lg cursor-pointer">&times;</span>
                </div>
            </div>

            <div v-if="filter === 'max_price'" class="relative">
                <div class="bg-c-green-100 text-c-green-600 text-xs pl-2.5 pr-6 py-1 relative flex items-center space-x-1 rounded-full max-w-max">
                    <span>Max €{{ value }}</span>
                    <span @click="removeFilter(filter, null)" class="absolute right-2 -bottom-[1px] text-lg cursor-pointer">&times;</span>
                </div>
            </div>

        </div>
    </section>
</template>