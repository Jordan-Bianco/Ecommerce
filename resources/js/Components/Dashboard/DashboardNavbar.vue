<script setup>
import { Inertia } from '@inertiajs/inertia';
import DashboardMobileMenu from './DashboardMobileMenu.vue';

const logout = () => {
    Inertia.post(route('logout'))
}
</script>

<template>
    <div class="md:flex md:flex-shrink-0">
        <div class="bg-slate-700 border-b border-slate-600 md:flex-shrink-0 md:w-56 px-6 py-4 flex items-center justify-between md:justify-center">
            <h2 class="text-base text-white font-medium uppercase">Inertiashop</h2>

            <div class="md:hidden">
                <DashboardMobileMenu></DashboardMobileMenu>
            </div>
        </div>
        <div
            class="bg-white border-b w-full p-4 md:py-0 md:px-12 text-sm md:text-md flex justify-end items-center">
                <div class="flex items-center space-x-2 text-zinc-600">
                    <span class="text-sm">{{ $page.props.auth.user.name }}</span>
                    <form @submit.prevent="logout()" class="flex">
                        <button
                            type="submit"
                            class="">
                                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>                                
                        </button>
                    </form>
                </div>
        </div>
    </div>
</template>
