<template>
    <AdminLayout title="Label Manager" :state="state">
        <a-table
            :columns="columns"
            :data-source="labels"
            size="middle"
            row-class-name="cursor-pointer"
        >
            <template #title>
                <a-row justify="center">
                    <a-col :span="16">
                        <h1 class="text-2xl mb-1 font-semibold">{{title}}</h1>
                    </a-col>
                    <a-col :span="8">
                        <div class="flex flex-row justify-end gap-x-2.5">
                            <a-button
                                class="flex justify-center items-center space-x-2.5 font-semibold"
                                :icon="h(AddIcon)"
                                @click="onAdd" danger>
                                Add New Label
                            </a-button>
                        </div>
                    </a-col>
                </a-row>
            </template>
            <template #bodyCell="{column, index, record}">
                <template v-if="column.title === 'No'">
                    <span>{{index + 1}}</span>
                </template>
                <template v-if="column.dataIndex === 'action'">
                    <div class="flex flex-row justify-center gap-4">
                        <a-button
                            class="bg-[#F1F1F2] p-1.5 border-none"
                            @click="onEdit(record)"
                            :icon="h(EditIcon)" />
                        <a-popconfirm
                            title="Are you sure to delete this label?"
                            @confirm="onDelete(record.id)">
                            <a-button
                                class="bg-[#F1F1F2] p-1.5 border-none"
                            :icon="h(TrashIcon)">
                            </a-button>
                        </a-popconfirm>
                    </div>
                </template>
            </template>
        </a-table>
        <LabelModals
            :open="isOpenModal"
            :isEdit="isEdit"
            :currentLabel="currentLabel"
            @closeModal="closeModal"
            @onSave="onSave">
        </LabelModals>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {h, ref} from "vue";
import AddIcon from "@/Components/Icons/AddIcon.vue";
import LabelModals from "@/Components/Modals/LabelModals.vue";
import { router } from '@inertiajs/vue3'
import EditIcon from "@/Components/Icons/EditIcon.vue";
import TrashIcon from "@/Components/Icons/TrashIcon.vue";
defineProps({
    labels: {
        type: Array,
        required: true,
    },
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
});

const currentLabel = ref(null);
const isOpenModal = ref(false);
const isEdit = ref(false);


const openModal = () => { isOpenModal.value = true };
const closeModal = () => {
    currentLabel.value = null;
    isOpenModal.value = false;
};

const onAdd= ()=>{
    isEdit.value = false;
    currentLabel.value = null
    openModal();
}
const onEdit = (label)=>{
    isEdit.value = true;
    currentLabel.value = label;
    openModal();
}

const onSave = (newLabel) => {
    if (isEdit.value) {
        // edit
        const label_id = currentLabel.value.id;
        router.put(route("admin.label.update",label_id),newLabel)
    } else {
        router.post(route("admin.label.store"),newLabel)
    }
    closeModal();
}
const onDelete = (label_id) => {
    router.delete(route("admin.label.destroy", label_id))
}


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
        title:"Action",
        dataIndex: "action"
    },
]


</script>
