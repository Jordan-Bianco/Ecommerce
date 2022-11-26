<script setup>
import { ref } from 'vue';

const showSettings = ref(false);

const toggleShowSettings = () => {
    showSettings.value = !showSettings.value
}
</script>

<template>
    <aside class="hidden md:block bg-gradient-to-b from-slate-700 to-slate-800 flex-shrink-0 w-56 overflow-y-auto">

        <span class="block text-xxs uppercase text-slate-400 pl-[30px] pt-8 pb-2">Dashboard</span>

        <Link
            class="block text-sm border-l-4 pl-6 py-2 transition"
            :class="route().current('dashboard') ? 'border-c-green-100 bg-slate-600 text-white' : 'border-transparent text-slate-300'"
            :href="route('dashboard')"
        >
            <span>Overview</span>
        </Link>

        <Link
            class="block text-sm border-l-4 pl-6 py-2 transition"
            :class="route().current('order.index') ? 'border-c-green-100 bg-slate-600 text-white' : 'border-transparent text-slate-300'"
            :href="route('order.index')"
        >
            <span>My orders</span>
        </Link>

        <Link
            class="block text-sm border-l-4 pl-6 py-2 border-transparent text-slate-300"
            :href="route('shop')"
        >
            <span>Shop</span>
        </Link>

        <span class="block text-xxs uppercase text-slate-400 pl-[30px] pt-8 pb-2">Account</span>

        <div class="relative">
            <div @click="toggleShowSettings()" class="flex items-center justify-between px-7 py-2 text-slate-300 text-sm cursor-pointer">
                <span>Settings</span>
                <svg class="w-[18px] h-[18px] transform transition duration-250" :class="{ 'rotate-180' : showSettings }" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
            </div>

            <div v-if="showSettings">
                <Link
                    class="flex items-center space-x-2 text-sm border-l-4 pl-8 py-2 transition"
                    :class="route().current('settings.profile.edit') ? 'border-c-green-100 bg-slate-600 text-white' : 'border-transparent text-slate-300'"
                    :href="route('settings.profile.edit')"
                >
                    <span>Profile</span>
                </Link>

                <Link
                    class="flex items-center space-x-2 text-sm border-l-4 pl-8 py-2 transition"
                    :class="route().current('settings.password.edit') ? 'border-c-green-100 bg-slate-600 text-white' : 'border-transparent text-slate-300'"
                    :href="route('settings.password.edit')"
                >
                    <span>Edit Password</span>
                </Link>
            </div>
        </div>
    </aside>
</template>