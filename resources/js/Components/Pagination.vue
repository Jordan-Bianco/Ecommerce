<script setup>
const props = defineProps({
    links: Array,
    meta: Object
});
</script>

<template>
    <div class="flex items-center justify-center mt-16">
        <span
            v-for="(link, i) in links"
            :key="i">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    v-html="link.label"
                    class="px-3 py-2 text-xs rounded mr-2"
                    :class="link.active ? 'bg-c-green-600 text-white' : 'bg-zinc-200 text-zinc-500'"
                    as="button"
                    :disabled="link.active"
                ></Link>
        </span>
    </div>
</template>
