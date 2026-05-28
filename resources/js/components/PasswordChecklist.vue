<script setup>
import { computed } from 'vue';

const props = defineProps({
    password: {
        type: String,
        default: '',
    },
});

const rules = computed(() => [
    { label: 'At least 8 characters', valid: props.password.length >= 8 },
    { label: 'One uppercase letter', valid: /[A-Z]/.test(props.password) },
    { label: 'One lowercase letter', valid: /[a-z]/.test(props.password) },
    { label: 'One number or symbol', valid: /[0-9\W_]/.test(props.password) },
]);
</script>

<template>
    <div class="border border-zinc-200 bg-zinc-50 p-3">
        <p class="eyebrow mb-2">Password safety</p>
        <ul class="space-y-1.5">
            <li v-for="rule in rules" :key="rule.label" class="flex items-center gap-2 text-sm">
                <span
                    :class="[
                        'grid size-5 place-items-center text-[10px]',
                        rule.valid ? 'bg-emerald-100 text-emerald-700' : 'bg-zinc-200 text-zinc-500',
                    ]"
                >
                    <FontAwesomeIcon icon="check" />
                </span>
                <span :class="rule.valid ? 'text-zinc-800' : 'text-zinc-500'">{{ rule.label }}</span>
            </li>
        </ul>
    </div>
</template>
