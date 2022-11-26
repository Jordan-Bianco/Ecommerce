<script setup>

</script>
    
<template>
    <div class="relative">
        <Link
            :href="route('whishlist.index')"
            :class="{ 'bg-zinc-200' : route().current('whishlist.index') }"
            class="hover:bg-zinc-200 p-2 rounded-full transition block">
                <svg class="flex-none text-zinc-600 w-[19px] h-[19px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
        </Link>

        <div
            v-if="$page.props.auth.user && $page.props.whishlist.length > 0"
            class="absolute top-0 -right-0.5 w-4 h-4 bg-red-600 text-white flex items-center justify-center text-xxs z-10 rounded-full">
                {{ $page.props.whishlist.length }}
        </div>
    </div>
</template>