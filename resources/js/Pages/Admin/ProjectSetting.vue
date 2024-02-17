<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ref} from "vue";
import {router} from "@inertiajs/vue3";


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
    qualityImagesLabels: {
        type: Array,
        required: true,
    },
    blockImagesLabels: {
        type: Array,
        required: true,
    }
})


const columns = [
    {
        title: "No",
    },
    {
        title:"Label name",
        dataIndex:"name"
    },
    {
        title:"AI Class",
        dataIndex: "class_id"
    },
    {
        title:"Filter Image Status",
        dataIndex: "action"
    },
]

const isProcessing = ref(false);
const  changeStatus = (label_id) => {
    isProcessing.value = true;
    router.get(route("admin.label.change-status",label_id),{
        onBefore:()=>{
            isProcessing.value = true
        },
        onSuccess:()=>{
            isProcessing.value = false
        },
        onFinish:() =>{
            isProcessing.value = false
        }
    })
}
</script>
<template>
    <AdminLayout :title="title" :state="state">
        <a-table
            :columns="columns"
            :data-source="qualityImagesLabels"
            size="middle"
            row-class-name="cursor-pointer"
        >
            <template #title>
                <h1 class="text-2xl mb-1 font-semibold">Config Filter Quality Images</h1>
            </template>
            <template #bodyCell="{column, index, record}">
                <template v-if="column.title === 'No'">
                    <span>{{index + 1}}</span>
                </template>
                <template v-if="column.dataIndex === 'action'">
                    <div class="flex flex-row justify-between gap-4">
                        <a-button
                            class="text-green-600 border border-green-600 rounded-lg py-1 px-4 hover:bg-white"
                            v-if="record.status"
                        >
                            Keep Image
                        </a-button>
                        <a-button
                            danger
                            v-else
                        >
                            Remove Image
                        </a-button>
                        <a-button
                            :loading="isProcessing"
                            @click="changeStatus(record.id)"
                        >
                            Change config
                        </a-button>
                    </div>
                </template>
            </template>
        </a-table>
    </AdminLayout>
</template>
