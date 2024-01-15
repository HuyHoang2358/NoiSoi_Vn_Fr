<template>
    <a-menu-item :key="menuKey">
        <div class="flex flex-row items-center">
            <slot />
            <Link :href="path" class="ml-2">
                {{ title }}
            </Link>
        </div>
    </a-menu-item>
</template>
<script setup>
import {Link} from '@inertiajs/vue3';
defineProps({
    menuKey: {
        type: String,
        required: true,
    },
    path: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
});
</script>
