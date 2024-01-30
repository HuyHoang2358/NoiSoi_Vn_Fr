<script setup>
import {h, ref} from 'vue';
import AdminLayout from "@/Layouts/AdminLayout.vue";
import SearchIcon from "@/Components/Icons/SearchIcon.vue";
import FilterIcon from "@/Components/Icons/FilterIcon.vue";
import AddCircleIcon from "@/Components/Icons/AddCircleIcon.vue";
import EditIcon from "@/Components/Icons/EditIcon.vue";
import TrashIcon from "@/Components/Icons/TrashIcon.vue";
import UserModal from "@/Components/Modals/UserModal.vue";

import {router} from "@inertiajs/vue3";
import {notification} from "ant-design-vue";
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
    users: {
        type: Array,
        required: true,
    },
    roles: {
        type: Array,
        required: true,
    }
})
const columns = [
    {
        title: 'No',
    },
    {
        title: 'Full Name',
        dataIndex: 'name',
    },
    {
        title: 'Email',
        dataIndex: 'email',
    },
    {
        title: 'Phone',
        dataIndex: 'phone',
    },
    {
        title: 'Address',
        dataIndex: 'address',
    },
    {
        title: 'Account Type',
        dataIndex: 'role',
    },
    {
        title: 'Action',
        dataIndex: 'action',
    },
];

const isOpenModal = ref(false);
const isEdit = ref(false);
const isProcessing = ref(false);
const currentUser = ref(null);

const openModal = () => { isOpenModal.value = true };
const closeModal = () => { isOpenModal.value = false; currentUser.value = null };

const onAdd = () => {
    isEdit.value = false;
    currentUser.value = null;
    openModal();
}
const onEdit = (user) => {
    isEdit.value = true;
    currentUser.value = user;
    openModal();
}

const confirmDelete = (id) => {
    router.delete(route("admin.user.destroy",id),{
        onSuccess:()=>{
            notification['success']({
                message: 'Delete user successfully',
            });
        }
    })
}

const onSave = (data) => {
    if (isEdit.value){
        const user_id = currentUser.value.id;
        router.put(route("admin.user.update",user_id),data,{
            onBefore:()=>{
                isProcessing.value= true;
            },
            onSuccess:()=>{
                isProcessing.value=false;
                closeModal();
                notification['success']({
                    message: 'Update user successfully',
                });
            },
        })
    }else{
        router.post(route("admin.user.store"),data,{
            onBefore:()=>{
                isProcessing.value= true;
            },
            onSuccess:()=>{
                isProcessing.value=false;
                closeModal();
                notification['success']({
                    message: 'Add new user successfully',
                });
            },
        })

    }

}

</script>
<template>
    <AdminLayout title="User Manager" :state="state">
        <a-table
            :columns="columns"
            :data-source="users"
            size="middle"
            :pagination="false"
            row-class-name="cursor-pointer"
        >
                <template #title>
                    <a-row jutify="center">
                        <a-col :span="12">
                            <h1 class="text-xl mb-1 font-bold">User List</h1>
                        </a-col>
                        <a-col :span="12">
                            <div class="flex flex-row gap-x-2.5">
                                <a-input
                                    placeholder="Searching ... ">
                                    <template #prefix>
                                        <SearchIcon />
                                    </template>
                                </a-input>
                                <a-button class="flex justify-center items-center space-x-4">
                                    Filter
                                    <FilterIcon />
                                </a-button>
                                <a-button
                                    type="primary"
                                    class="flex justify-center items-center space-x-2.5 bg-blue-600 hover:bg-white hover:text-blue-600"
                                    :icon="h(AddCircleIcon)"
                                    @click="onAdd"
                                >
                                    Add new user
                                </a-button>
                            </div>
                        </a-col>
                    </a-row>
                </template>
                <template #bodyCell="{ column, index, record }">
                    <template v-if="column.title === 'No'">
                        <p class="text-center">{{ index + 1 }}</p>
                    </template>
                    <template v-if="column.dataIndex === 'phone'">
                        <p class="text-left">{{ record.profile.phone }}</p>
                    </template>
                    <template v-if="column.dataIndex === 'address'">
                        <p class="text-left">{{ record.profile.address }}</p>
                    </template>
                    <template v-if="column.dataIndex === 'role'">
                        <p class="text-center py-1 px-2  rounded"
                            :class="record.role_name === 'admin' ? 'bg-red-100' : 'bg-green-100'"
                        >{{ record.role_name}}</p>
                    </template>
                    <template v-if="column.dataIndex === 'action'">
                        <div class="flex flex-row gap-x-4">
                            <a-button
                                class="bg-[#F1F1F2] p-1.5"
                                @click="onEdit(record)"
                            >
                                <EditIcon />
                            </a-button>
                            <a-popconfirm
                                title="Are you sure to delete this user?"
                                @confirm="confirmDelete(record.id)"
                            >
                                <a-button class="bg-[#F1F1F2] p-1.5"><TrashIcon /></a-button>
                            </a-popconfirm>
                        </div>
                    </template>
                </template>
<!--                <template #footer>
                    <a-row class="flex flex-row justify-end">
                        <a-pagination
                            :show-size-changer="true"
                            @change="onChange"
                            :current="currentPage"
                            :total="data?.data?.total"
                            :page-size="pageSize"
                        />
                    </a-row>
                </template>-->
            </a-table>
        <UserModal
            :open="isOpenModal"
            :isEdit="isEdit"
            :currentUser="currentUser"
            :roles="roles"
            :isProcessing="isProcessing"
            @closeModal="closeModal"
            @onSave="onSave"/>
    </AdminLayout>
</template>
