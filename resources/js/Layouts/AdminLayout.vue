<template>
    <Head :title="title" />
    <a-layout has-sider class="min-h-screen">
        <AdminSidebar :state="state"/>
        <a-layout>
            <AdminHeader />
            <a-layout-content class="bg-white rounded-xl m-4 shadow-xl p-8">
                <div class="min-h-full">
                    <slot />
                </div>
            </a-layout-content>
        </a-layout>
    </a-layout>
</template>
<script setup>
import AdminSidebar from "@/Layouts/AdminSidebar.vue";
import AdminHeader from "@/Layouts/AdminHeader.vue";
import {Head} from "@inertiajs/vue3";
defineProps({
    state: {
        selectedKeys: {
            type: Array,
            required: true,
        },
        openKeys: {
            type: Array,
            required: true,
        },
        required: true,
    },
    title: String
});
</script>
