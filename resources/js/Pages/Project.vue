<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import ProjectCard from "@/Components/Cards/ProjectCard.vue";
import NewProject from "@/Components/Buttons/NewProject.vue";
import ProjectModal from "@/Components/Modals/ProjectModal.vue";
import {router} from "@inertiajs/vue3";
import LabelModals from "@/Components/Modals/LabelModals.vue";
const activeKey = ref('1');
defineProps({
    myProjects:{
        type:Array,
        required:true
    }
})


const isOpenModal = ref(false);
const isEdit = ref(false);
const currentProject = ref(null);

const openModal = () => { isOpenModal.value = true };
const closeModal = () => {
    isOpenModal.value = false
    currentProject.value = null
};

const onAdd = () => {
    isEdit.value = false;
    currentProject.value = null;
    openModal();
}
const onEdit = (project) => {
    isEdit.value = true;
    currentProject.value = project;
    openModal();
}

const onOpen = (project) => {
    console.log("opening");
    router.get(route("user.project.detail",project.id));
}

const onSharing = (project) => {
    console.log("sharing");
}

const onDelete = (project) => {
    router.delete(route("user.project.destroy",project.id));
}

const onSave = (data) => {
    if (isEdit.value){
        // edit
        const project_id = currentProject.value.id;
        router.put(route("user.project.update",project_id),data)
    }else{
        router.post(route("user.project.store"),data)}
    closeModal();
}

</script>

<template>
    <AppLayout title="Projects">
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg  p-6">
                    <a-tabs v-model:activeKey="activeKey">
                        <a-tab-pane key="1">
                            <template #tab>
                                <span>
                                  <i class="fa-regular fa-folder-closed mr-2"></i>
                                  My Projects
                                </span>
                            </template>
                            <div class="grid grid-cols-5 gap-4 my-4">
                                <div class="col-span-1" v-for="item in myProjects" :key="item.id">
                                    <ProjectCard
                                        :project="item"
                                        @onEdit="onEdit"
                                        @onDelete="onDelete"
                                        @onOpen="onOpen"
                                        @onSharing="onSharing"
                                    />
                                </div>
                                <div class="col-span-1">
                                    <NewProject @clickFunc="onAdd"/>
                                </div>
                            </div>
                        </a-tab-pane>
                        <a-tab-pane key="2">
                            <template #tab>
                                <span>
                                    <i class="fa-regular fa-share-from-square mr-2"></i>
                                   Shared Project with me
                                </span>
                            </template>
                            Tab 2
                        </a-tab-pane>
                    </a-tabs>
                </div>
            </div>
        </div>
        <ProjectModal
            :open="isOpenModal"
            :isEdit="isEdit"
            :currentProject="currentProject"
            @closeModal="closeModal"
            @onSave="onSave"/>
    </AppLayout>
</template>
