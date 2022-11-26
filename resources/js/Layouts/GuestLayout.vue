<script setup>
import ApplicationLogo from "@/Components/Breeze/ApplicationLogo.vue";
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-zinc-50">
        <div class="w-full sm:max-w-sm mt-6 p-6 bg-white sm:shadow-lg sm:shadow-zinc-300 sm:overflow-hidden sm:rounded-xl"><slot />
        </div>
    </div>
</template>
