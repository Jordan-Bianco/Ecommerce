<script setup>
import { ref } from 'vue';

const showMenu = ref(false)

const openMenu = () => {
    showMenu.value = true
}

const closeMenu = () => {
    showMenu.value = false
}

const showSettings = ref(false);

const toggleShowSettings = () => {
    showSettings.value = !showSettings.value
}
</script>
    
<template>
    <div>
        <svg @click="openMenu()" class="w-5 h-5 flex-none text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
    
        <aside
            :class="{ 'translate-x-full' : ! showMenu }"
            class="fixed top-0 right-0 bottom-0 bg-gradient-to-b from-slate-700 to-slate-800 flex-shrink-0 w-56 z-20 overflow-y-auto transition transform ease-linear">

            <header class="pl-6 py-5">
                <svg @click="closeMenu()" class="w-5 h-5 flex-none text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </header>

            <span class="block text-xxs uppercase text-slate-400 pl-6 pb-2">Dashboard</span>

            <Link
                class="block text-sm border-r-4 pl-6 py-2 transition"
                :class="route().current('dashboard') ? 'border-c-green-100 bg-slate-600 text-white' : 'border-transparent text-slate-300'"
                :href="route('dashboard')"
                @click="closeMenu()"
            >
                <span>Overview</span>
            </Link>

            <Link
                class="block text-sm border-r-4 pl-6 py-2 transition"
                :class="route().current('order.index') ? 'border-c-green-100 bg-slate-600 text-white' : 'border-transparent text-slate-300'"
                :href="route('order.index')"
                @click="closeMenu()"
            >
                <span>My orders</span>
            </Link>

            <Link
                class="block text-sm border-r-4 pl-6 py-2 border-transparent text-slate-300"
                :href="route('shop')"
                @click="closeMenu()"
            >
                <span>Shop</span>
            </Link>

            <span class="block text-xxs uppercase text-slate-400 pl-6 pt-8 pb-2">Account</span>

            <div class="relative">
                <div @click="toggleShowSettings()" class="flex items-center justify-between px-6 py-2 text-slate-300 text-sm cursor-pointer">
                    <span>Settings</span>
                    <svg class="w-[18px] h-[18px] transform transition duration-250" :class="{ 'rotate-180' : showSettings }" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                </div>

                <div v-if="showSettings">
                    <Link
                        class="flex items-center space-x-2 text-sm border-r-4 pl-8 py-2 transition"
                        :class="route().current('settings.profile.edit') ? 'border-c-green-100 bg-slate-600 text-white' : 'border-transparent text-slate-300'"
                        :href="route('settings.profile.edit')"
                        @click="closeMenu()"
                    >
                        <span>Profile</span>
                    </Link>

                    <Link
                        class="flex items-center space-x-2 text-sm border-r-4 pl-8 py-2 transition"
                        :class="route().current('settings.password.edit') ? 'border-c-green-100 bg-slate-600 text-white' : 'border-transparent text-slate-300'"
                        :href="route('settings.password.edit')"
                        @click="closeMenu()"
                    >
                        <span>Edit Password</span>
                    </Link>
                </div>
            </div>
        </aside>

        <div
            v-if="showMenu"
            class="bg-black fixed inset-0 opacity-10 z-10"
            @click="closeMenu()"
        ></div>
    </div>
</template>