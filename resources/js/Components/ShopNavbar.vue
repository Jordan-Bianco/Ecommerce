<script setup>
    import MiniCart from "@/Components/ShopNavbar/MiniCart.vue";
    import UserMenu from "@/Components/ShopNavbar/UserMenu.vue";
    import TheWhishlist from '@/Components/ShopNavbar/TheWhishlist.vue'
</script>

<template>
    <div>
        <nav class="bg-white border-b border-zinc-200">
            <div class="max-w-7xl mx-auto px-6 py-4">
                <div class="flex justify-between">
                    <!-- Left Side -->
                    <div class="flex items-center space-x-2">
                        <h1 class="text-base font-medium uppercase">
                            <Link :href="route('shop')"><span style="color: rgb(90, 132, 78)">Inertia</span>Shop</Link>
                        </h1>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center">
                        <TheWhishlist class="mr-1"></TheWhishlist>
                        <UserMenu class="mr-1" :user="$page.props.auth.user" />
                        <MiniCart :user="$page.props.auth.user" />
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>
