<script setup>
import { Inertia } from "@inertiajs/inertia";
import { ref, watch } from "vue";
import pickBy from 'lodash/pickBy'

import ShopLayout from "@/Layouts/ShopLayout.vue";
import ProductCard from "@/Components/ProductCard.vue";
import ProductCategoryFilter from "@/Components/ProductFilters/ProductCategoryFilter.vue";
import ProductPriceFilter from "@/Components/ProductFilters/ProductPriceFilter.vue";
import ProductSearch from "@/Components/ProductFilters/ProductSearch.vue";
import AppliedFilters from "@/Components/ProductFilters/AppliedFilters.vue";
import SortProducts from "@/Components/ProductFilters/SortProducts.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    products: Object,
    categories: Array,
    category: String,
    search: String,
    min_price: String,
    max_price: String,
    sortBy: String,
});

const filters = ref({
    category: props.category,
    search: props.search,
    min_price: props.min_price,
    max_price: props.max_price,
    sortBy: props.sortBy,
});

const setCategory = (value) => {
    filters.value.category = value
}

const setPrice = (value) => {
    filters.value.min_price = value.selectedMin;
    filters.value.max_price = value.selectedMax;
}

const setSearch = (value) => {
    filters.value.search = value
}

const setSortBy = (value) => {
    filters.value.sortBy = value
}

watch(filters.value, value => {
    Inertia.get(route("shop"), pickBy(value), {
        preserveState: true,
        replace: true,
    });
});
</script>

<template>
    <ShopLayout>
        <Head title="Shop" />

        <div class="sm:flex">
            <div class="sm:w-64 sm:border-r">
                <ProductSearch
                    :search="props.search"
                    @setSearch="setSearch"
                ></ProductSearch>

                <ProductCategoryFilter
                    :category="props.category"
                    :categories="props.categories"
                    @setCategory="setCategory"
                ></ProductCategoryFilter>

                <ProductPriceFilter
                    :min_price="props.min_price"
                    :max_price="props.max_price"
                    @setPrice="setPrice"
                ></ProductPriceFilter>
            </div>

            <div class="flex-1 relative pt-8 sm:px-10">

                <header class="flex items-center justify-between mb-10">
                    <h2 class="text-4xl uppercase font-medium">Shop</h2>
                    
                    <SortProducts
                        :sortBy="props.sortBy"
                        @setSortBy="setSortBy"
                    ></SortProducts>
                </header>

                <section class="mb-10">
                    <AppliedFilters :filters="filters"></AppliedFilters>
                </section>

                <div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <ProductCard
                            v-for="product in products.data"
                            :key="product.id"
                            :product="product"
                        ></ProductCard>
                    </div>

                    <Pagination
                        v-if="products.links.next || products.links.prev"
                        :links="products.meta.links"
                        :meta="products.links"
                    ></Pagination>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>
