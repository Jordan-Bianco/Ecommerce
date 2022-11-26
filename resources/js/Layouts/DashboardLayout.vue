<script setup>
import DashboardNavbar from "@/Components/Dashboard/DashboardNavbar.vue";
import DashboardAsideMenu from "@/Components/Dashboard/DashboardAsideMenu.vue";
import FlashMessage from '@/Components/FlashMessage.vue'
</script>

<template>
    <div class="h-screen md:flex md:flex-col bg-slate-100">
        <DashboardNavbar />

        <transition name="from-r">
            <FlashMessage v-if="$page.props.flash.message"></FlashMessage>
        </transition>

        <div class="md:flex md:flex-grow md:overflow-hidden">
            <DashboardAsideMenu />
            <main class="md:flex-1 px-4 py-6 md:p-8 lg:px-12 lg:py-8 md:overflow-y-auto bg-slate-100">
                <slot />
            </main>
        </div>
    </div>
</template>
