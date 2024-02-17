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
            <MenuItem
                title="Category Manager"
                :path="route('admin.category.index')"
                :menu-key="'category-manager'"
                :icon="h(CategoryIcon)"
            />
            <a-sub-menu key="label-manager">
                <template #title>
                    <LabelIcon />  <span class="ml-2"> Label manager</span>
                </template>
                <MenuItem title="Image Quality Label" :path="route('admin.label.index','image-quality')" :menu-key="'label-manager-image-quality'"/>
                <MenuItem title="Block Quality Label" :path="route('admin.label.index','block-image-quality')" :menu-key="'label-manager-block-image-quality'"/>
                <MenuItem title="Lesions Label" :path="route('admin.label.index','classification')" :menu-key="'label-manager-gastritis'"/>
                <MenuItem title="Zone Label" :path="route('admin.label.index','zone')" :menu-key="'label-manager-zone'"/>
            </a-sub-menu>
            <a-sub-menu key="user-manager">
                <template #title>
                   <UserIcon /><span class="ml-2"> User manager</span>
                </template>
                <MenuItem title="User List" :path="route('admin.user.index')" :menu-key="'user-list'">
                    <UserIcon />
                </MenuItem>
            </a-sub-menu>



            <a-sub-menu key="project-manager">
                <template #title>
                    <ProjectIcon />  <span class="ml-2"> Project manager</span>
                </template>
                <MenuItem title="All Projects" :path="route('admin.project.index')" :menu-key="'project-manager-index'"/>
                <MenuItem title="Setting" :path="route('admin.project.setting')" :menu-key="'project-manager-setting'"/>
            </a-sub-menu>


        </a-menu>
    </a-layout-sider>
</template>
<script setup>
import LogoAdmin from "@/Components/LogoAdmin.vue";
import UserIcon from "@/Components/Icons/UserIcon.vue";
import MenuItem from "@/Components/MenuItem.vue";
import LabelIcon from "@/Components/Icons/LabelIcon.vue";
import ProjectIcon from "@/Components/Icons/ProjectIcon.vue";
import { h } from 'vue';
import CategoryIcon from "@/Components/Icons/CategoryIcon.vue";

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
