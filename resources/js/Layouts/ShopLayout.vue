<script setup>
import ShopNavbar from "@/Components/ShopNavbar.vue";
import FlashErrorMessage from '@/Components/FlashErrorMessage.vue'
</script>

<template>
    <div>
        <div class="min-h-screen bg-white">
            <ShopNavbar />

            <transition name="list">
                <FlashErrorMessage v-if="$page.props.flash.error"></FlashErrorMessage>
            </transition>

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto px-6 md:px-0">
                <slot />
            </main>
            <footer class="sticky top-[100vh] h-56 mt-10 bg-zinc-800">Footer</footer>
        </div>
    </div>
</template>
