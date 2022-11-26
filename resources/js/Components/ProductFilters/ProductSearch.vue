<script setup>
import { ref, watch } from "vue";
import debounce from "lodash/debounce"

const props = defineProps({
    search: String
});

const emits = defineEmits(['setSearch']);

const search = ref(props.search);

watch(() => search.value, debounce(function(value) {
    emits('setSearch', search.value)
}, 700));

</script>

<template>
    <div class="pt-[34px] px-6 pb-0">
        <div class="relative">
            <input
                type="text"
                v-model="search"
                id="search"
                placeholder="Search among 100+ products"
                class="border border-zinc-300 p-2 pl-10 text-xs w-full placeholder-zinc-400 rounded focus:border-transparent focus:ring focus:ring-zinc-300 focus:ring-opacity-80"
            />
            <div class="absolute left-0 top-0 bg-c-green-600 px-2 py-[9px] rounded-l">
                <svg
                    class="w-[16px] h-[16px] text-white flex-none"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                    ></path>
                </svg>
            </div>
        </div>
    </div>
</template>
