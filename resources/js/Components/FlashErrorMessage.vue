<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3'

const flashMessage = ref({ error: usePage().props.value.flash.error })

onMounted(() => {
    setTimeout(() => {
        usePage().props.value.flash.error = ''
    }, 3000)
});
</script>
    
<template>
    <div class="fixed top-20 left-12 bg-white shadow shadow-zinc-200 drop-shadow-md text-[13px] p-4 rounded-xl flex items-center space-x-4 z-20">
        <div class="p-1 rounded-full bg-red-200 text-red-500 bg-opacity-50">
            <svg class="w-6 h-6 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <span class="font-medium block">Error</span>
            <span class="text-zinc-500">{{ flashMessage.error }}</span>
        </div>
    </div>
</template>