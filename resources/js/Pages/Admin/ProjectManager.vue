<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import ProjectCardAdmin from "@/Components/Cards/ProjectCardAdmin.vue";

const props = defineProps({
    state: {
        type: Object,
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
    title: {
        type: String,
    },
    projects: {
        type: Array,
        required: true,
    }
})


</script>
<template>
    <AdminLayout title="User Manager" :state="state">
        <div class="w-full">
            <h3 class="text-2xl font-semibold text-blue-600"> All Projects</h3>
            <div class="grid grid-cols-5 gap-4 my-4">
                <div class="col-span-1" v-for="item in projects" :key="item.id">
                    <ProjectCardAdmin
                        :project="item"
                    />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
