<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3'

const flashMessage = ref({message: usePage().props.value.flash.message})

onMounted(() => {
    setTimeout(() => {
        usePage().props.value.flash.message = ''
    }, 3000)
});
</script>
    
<template>
    <div class="fixed top-20 md:right-12 right-4 bg-white shadow shadow-zinc-200 drop-shadow-md text-[13px] p-4 rounded-xl flex items-center space-x-4">
        <div class="p-1 rounded-full bg-c-green-100 text-c-green-300 bg-opacity-50">
            <svg class="w-5 h-5 flex-none" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        </div>
        <div>
            <span class="font-medium block">Success</span>
            <span class="text-zinc-500">{{ flashMessage.message }}</span>
        </div>
    </div>
</template>