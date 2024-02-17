<template>
    <AdminLayout title="Label Manager" :state="state">
        <a-table
            :columns="columns"
            :data-source="categories"
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
                                Add New Category
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
        <CategoryModal
            :open="isOpenModal"
            :isEdit="isEdit"
            :isProcessing="isProcessing"
            :currentCategory="currentCategory"
            @closeModal="closeModal"
            @onSave="onSave">
        </CategoryModal>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {h, ref} from "vue";
import AddIcon from "@/Components/Icons/AddIcon.vue";
import { router } from '@inertiajs/vue3'
import EditIcon from "@/Components/Icons/EditIcon.vue";
import TrashIcon from "@/Components/Icons/TrashIcon.vue";
import CategoryModal from "@/Components/Modals/CategoryModal.vue";
import {notification} from "ant-design-vue";

defineProps({
    categories: {
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

const currentCategory = ref(null);
const isOpenModal = ref(false);
const isEdit = ref(false);
const isProcessing = ref(false);

const openModal = () => { isOpenModal.value = true };
const closeModal = () => {
    currentCategory.value = null;
    isOpenModal.value = false;
};

const onAdd= ()=>{
    isEdit.value = false;
    currentCategory.value = null
    openModal();
}
const onEdit = (category)=>{
    isEdit.value = true;
    currentCategory.value = category;
    openModal();
}

const onSave = (newCategory) => {
    if (isEdit.value) {
        // edit
        const category_id = currentCategory.value.id;
        router.put(route("admin.category.update",category_id),newCategory, {
            onBefore:()=>{
                isProcessing.value = true
            },
            onSuccess:()=>{
                notification['success']({
                    message: 'Update category information successfully',
                    duration: 2
                });
            },
            onFinish:() =>{
                isProcessing.value = false
                closeModal();
            }
        })
    } else {
        router.post(route("admin.category.store"),newCategory,{
            onBefore:()=>{
                isProcessing.value = true
            },
            onSuccess:()=>{
                isProcessing.value = false
                closeModal();
                notification['success']({
                    message: 'Add new category successfully',
                    duration: 2
                });
            },
        })
    }
}
const onDelete = (category_id) => {
    router.delete(route("admin.category.destroy", category_id),{
        onSuccess:()=>{
            notification['success']({
                message: 'Delete category successfully',
                duration: 2
            });
        },
    })
}


const columns = [
    {
        title: "No",
    },
    {
        title:"Category name",
        dataIndex:"name"
    },
    {
        title:"Category slug",
        dataIndex:"slug"
    },
    {
        title:"Action",
        dataIndex: "action"
    },
]


</script>
