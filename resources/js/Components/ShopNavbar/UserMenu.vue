<script setup>
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const props = defineProps({
    user: Object,
});

const showUserMenu = ref(false);

const toggleUserMenu = () => {
    if (!props.user) {
        Inertia.get(route('login'));
    }

    showUserMenu.value = !showUserMenu.value;
};

const logout = () => {
    showUserMenu.value = false;

    Inertia.post(route('logout'))
}
</script>

<template>
    <div>
        <div class="relative">
            <div
                @click="toggleUserMenu()"
                :class="{ 'bg-zinc-200' : showUserMenu }"
                class="hover:bg-zinc-200 p-2 rounded-full transition cursor-pointer">
                    <svg class="w-[19px] h-[19px] text-zinc-600 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
            </div>

            <transition name="fade">
                <div
                    v-if="showUserMenu && user"
                    class="absolute mt-2 right-0 bg-white w-44 max-h-max text-[13px] shadow-md z-30 rounded-xl"
                >
                    <header class="p-4 border-b">
                        <span class="block text-sm">{{ user.name }}</span>
                    </header>
                    <div class="m-2">
                        <Link
                            :href="route('dashboard')"
                            class="flex items-center space-x-2 p-2 hover:bg-zinc-200 rounded transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart flex-none w-[18px] h-[18px] text-zinc-600"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                                <span>Dashboard</span>
                        </Link>

                        <Link
                            :href="route('order.index')"
                            class="flex items-center space-x-2 p-2 hover:bg-zinc-200 rounded transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package flex-none w-[18px] h-[18px] text-zinc-600"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                <span>My orders</span>
                        </Link>

                        <Link
                            :href="route('settings.profile.edit')"
                            class="flex items-center space-x-2 p-2 hover:bg-zinc-200 rounded transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tool flex-none w-[18px] h-[18px] text-zinc-600"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                                <span>Settings</span>
                        </Link>

                        <form @submit.prevent="logout()">
                            <button
                                type="submit"
                                class="w-full flex items-center space-x-2 p-2 hover:bg-zinc-200 rounded transition">
                                    <svg class="w-[18px] h-[18px] flex-none text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>                                
                                    <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </transition>
        </div>

        <div
            v-if="showUserMenu && user"
            class="bg-black fixed inset-0 opacity-10 z-20"
            @click="toggleUserMenu()"
        ></div>
    </div>
</template>
