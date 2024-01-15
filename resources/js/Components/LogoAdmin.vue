<script setup>
import {Link} from '@inertiajs/vue3';
</script>
<template>
    <div class="flex items-center justify-between">
        <Link :href="route('admin.homepage')">
            <img src="/images/logoAdmin.png" alt="Logo" class="p-2"/>
        </Link>
    </div>
</template>
