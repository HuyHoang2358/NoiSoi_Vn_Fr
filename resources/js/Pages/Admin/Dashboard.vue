<script lang="ts" setup>
import { h } from 'vue';
import Welcome from '@/Components/Welcome.vue';
import AdminLayout from "@/Layouts/AdminLayout.vue";
import SearchIcon from "@/Components/Icons/SearchIcon.vue";
import FilterIcon from "@/Components/Icons/FilterIcon.vue";
import AddCircleIcon from "@/Components/Icons/AddCircleIcon.vue";
import EditButton from "@/Components/Buttons/EditButton.vue";
import EditIcon from "@/Components/Icons/EditIcon.vue";
import UserGroupIcon from "@/Components/Icons/UserGroupIcon.vue";
import TrashIcon from "@/Components/Icons/TrashIcon.vue";

const dataSource = [{
    key: '1',
    name: 'Mike',
    email: 'Mike@gmail.com'
}, {
    key: '2',
    name: 'John',
    email: 'John@gmail.com',
},
    {
        key: '3',
        name: 'John',
        email: 'John@gmail.com',
    },
    {
        key: '4',
        name: 'John',
        email: 'John@gmail.com',
    },
    {
        key: '5',
        name: 'John',
        email: 'John@gmail.com',
    },
    {
        key: '6',
        name: 'John',
        email: 'John@gmail.com',
    }];
const columns = [
    {
        title: '#No',
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
        title: 'Action',
        dataIndex: 'action',
    },
];

</script>



<template>
    <AdminLayout title="Dashboard">
        <a-table
            :columns="columns"
            :data-source="dataSource"
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
                                >
                                    Add new user
                                </a-button>
                            </div>
                        </a-col>
                    </a-row>
                </template>
                <template #bodyCell="{ column, index, record }">
                    <template v-if="column.title === '#No'">
                        <p class="text-center">{{ index + 1 }}</p>
                    </template>
                    <template v-if="column.dataIndex === 'action'">
                        <div class="flex flex-row gap-x-4">
                            <a-button
                                class="bg-[#F1F1F2] p-1.5"
                                @click="onAddRole(record)"
                            >
                                <UserGroupIcon />
                            </a-button>
                            <a-button
                                class="bg-[#F1F1F2] p-1.5"
                                @click="onEdit(record)"
                            >
                                <EditIcon />
                            </a-button>
                            <a-popconfirm
                                title="Xác nhận xóa người dùng?"
                                @confirm="confirm(record.userId)"
                                @cancel="cancel"
                            >
                                <a-button class="bg-[#F1F1F2] p-1.5"><TrashIcon /></a-button>
                            </a-popconfirm>
                        </div>
                    </template>
                </template>
                <template #footer>
                    <a-row class="flex flex-row justify-end">
                        <a-pagination
                            :show-size-changer="true"
                            @change="onChange"
                            :current="currentPage"
                            :total="data?.data?.total"
                            :page-size="pageSize"
                        />
                    </a-row>
                </template>
            </a-table>
    </AdminLayout>
</template>
