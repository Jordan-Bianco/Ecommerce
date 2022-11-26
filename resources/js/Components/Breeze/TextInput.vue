<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>

<template>
    <input
        class="text-xs p-3 border-none bg-zinc-200 rounded-lg focus:ring-2 focus:ring-zinc-300 focus:ring-opacity-90 transition"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input">
</template>
