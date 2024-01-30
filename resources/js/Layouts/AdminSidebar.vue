<template>
    <a-layout-sider class="sider">
        <LogoAdmin />
        <a-divider class="h-px bg-[#373737] m-0 p-0" />
        <a-menu
            v-model:selectedKeys="state.selectedKeys"
            v-model:openKeys="state.openKeys"
            mode="inline"
            theme="dark"
            class="text-white mt-20">
            <a-sub-menu key="user-manager">
                <template #title>
                   <UserIcon /><span class="ml-2"> User manager</span>
                </template>
                <MenuItem title="User List" :path="route('admin.user.index')" :menu-key="'user-list'">
                    <UserIcon />
                </MenuItem>
            </a-sub-menu>

            <a-sub-menu key="label-manager">
                <template #title>
                  <LabelIcon />  <span class="ml-2"> Label manager</span>
                </template>
                <MenuItem title="Quality Label" :path="route('admin.label.index','quality')" :menu-key="'label-manager-quality'"/>
                <MenuItem title="Gastritis Label" :path="route('admin.label.index','gastritis')" :menu-key="'label-manager-gastritis'"/>
            </a-sub-menu>
        </a-menu>
    </a-layout-sider>
</template>
<script setup>
import LogoAdmin from "@/Components/LogoAdmin.vue";
import {reactive} from "vue";
import UserIcon from "@/Components/Icons/UserIcon.vue";
import MenuItem from "@/Components/MenuItem.vue";
import LabelIcon from "@/Components/Icons/LabelIcon.vue";
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
});
</script>
