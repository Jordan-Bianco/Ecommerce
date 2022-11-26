<script setup>
import { ref, watch } from 'vue';

const emits = defineEmits(['setCategory']);

const props = defineProps({
    categories: Array,
    category: String,
});

const selectedCategory = ref(props.category) 

const selectCategory = (categorySlug) => {

    if (! selectedCategory.value.includes(categorySlug)) {
        selectedCategory.value === '' 
            ? selectedCategory.value = categorySlug
            : selectedCategory.value += ',' + categorySlug         
    } else {
        // the url and laravel expect a string (of one or more categories separated by a comma)
        // To remove a category already present in the list,
        // I first turn the string into an array, then remove the category, and finally turn it back into a string
        selectedCategory.value = !Array.isArray(selectedCategory.value) ? selectedCategory.value.split(',') : selectedCategory.value;
       
        let index = selectedCategory.value.indexOf(categorySlug);

        selectedCategory.value.splice(index, 1);

        selectedCategory.value = selectedCategory.value.join(',') 
    }
};

watch(() => props.category, () => {    
    selectedCategory.value = props.category 
})

watch(() => selectedCategory.value, () => {
    emits('setCategory', selectedCategory.value)
})
</script>

<template>
    <section class="p-6 pb-0">
        <span class="block font-medium text-xs uppercase mb-4">Category</span>

        <ul class="">
            <li
                v-for="category in categories"
                :key="category.id"
                @click="selectCategory(category.slug)"
                class="text-xs text-zinc-500 flex items-start space-x-2 cursor-pointer px-2 py-1 rounded"
                :class="{ 'font-medium text-zinc-900 bg-zinc-100': selectedCategory && selectedCategory.includes(category.slug) }">
            
            <div
                class="w-4 h-4 flex justify-center items-center cursor-pointer rounded flex-none"
                :class="[ selectedCategory && selectedCategory.includes(category.slug) ? 'bg-c-green-600' : 'bg-zinc-300' ]">

                    <!-- Check svg -->
                    <svg
                        v-if="selectedCategory && selectedCategory.includes(category.slug)" 
                        class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="flex items-center justify-between w-full">
                    <span class="block">{{ category.name }}</span>
                    <span class="text-xxs block font-semibold bg-zinc-200 px-1.5 py-0.5 text-zinc-500 rounded">
                        {{ category.products_count }}
                    </span>
                </div>
            </li>
        </ul>
    </section>
</template>
