
<template>
    <AppLayout title="Project Detail">
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="border-b border-gray-300 pb-2">
                        <div class="flex justify-between items-center">
                            <div class="flex justify-start items-center gap-2">
                                <div class="bg-orange-100 py-1 px-2 rounded-lg">
                                    <i class="fa-regular fa-folder-open text-orange-400 text-2xl"></i>
                                </div>
                                <div >
                                    <p class="font-bold text-base text-blue-900">{{ project.name }}</p>
                                </div>
                            </div>
                            <div  class="flex justify-end items-center gap-2">
                                <button type="button"
                                        class="py-2 px-4 font-semibold rounded-lg hover:text-white hover:bg-orange-400 border border-orange-400 bg-white text-orange-500"
                                        @click="openLabelModel"
                                >
                                    Make Label
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4 h-full">
                        <div class="col-span-1 border-r border-gray-300 pt-4 pr-4 h-full">
                            <p class="bg-gray-100 rounded-lg py-2 px-4 text-gray-500">{{project.description}}</p>

                            <ImageInProject :confirmed_img="project.confirmed_image" :total_img="project.num_image" />

                            <UploadFile
                                :project_id="project.id"
                                @reloadProject="reloadProject"
                            />
                        </div>
                        <div class="col-span-2 pt-4 h-full">
                            <div class="w-full">
                                <div class="flex justify-between items-center">
                                    <div class="flex justify-start items-center gap-0.5">
                                        <a-pagination
                                            v-model:current="currentPage"
                                            v-model:pageSize="pageSize"
                                            show-size-changer
                                            :total="images.length"
                                            @showSizeChange="onShowSizeChange"
                                        />
                                    </div>

                                    <div class="flex justify-end items-center gap-0.5">
                                        <button
                                            class=" px-2 py-1 text-xl rounded  hover:text-orange-400 hover:bg-white"
                                            :class= "(is_list) ? 'bg-orange-200 text-orange-400' : 'text-gray-500 bg-gray-200'"
                                            @click="is_list = !is_list"
                                        >
                                            <i class="fa-regular fa-rectangle-list"></i>
                                        </button>
                                        <button
                                            class=" px-2 py-1 text-xl rounded  hover:text-orange-400 hover:bg-white"
                                            :class= "(!is_list) ? 'bg-orange-200 text-orange-400' : 'text-gray-500 bg-gray-200'"
                                            @click="is_list = !is_list"
                                        >
                                            <i class="fa-solid fa-grip"></i>
                                        </button>
                                        <button class="bg-gray-200 px-2 py-1 text-xl rounded text-gray-500 hover:text-orange-400 hover:bg-white"
                                                @click="change_sort_order"
                                        >
                                            <i class="fa-solid fa-arrow-up-z-a" v-if="order_by === 'desc'"></i>
                                            <i class="fa-solid fa-arrow-down-z-a" v-else></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full mt-4">
                                <div :class="is_list ? 'grid grid-cols-2 gap-4' : 'grid grid-cols-5 gap-2' ">
                                    <div class="flex flex-col col-span-1"  v-for="image in pagedImages">
                                        <ImageCard :image="image" :is_list="is_list"></ImageCard>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a-modal v-model:open="isOpenProcessingModal" :title="'Uploading images to project'" @ok="processingModalHandleOk" :footer="false">
            <div class="mt-8">
                <a-timeline>
                    <a-timeline-item color="red">
                        <template #dot>
                            <i class="fa-solid fa-filter text-blue-600"></i>
                        </template>
                        Filtering good images with AI model ...
                    </a-timeline-item>
                    <a-timeline-item color="red">
                        <template #dot>
                            <i class="fa-solid fa-table-cells text-blue-600"></i>
                        </template>
                        Detecting gastritis with AI model ...
                    </a-timeline-item>
                </a-timeline>
                <a-progress :percent="defaultPercent" class="mt-[-5px]"/>
            </div>
        </a-modal>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import ImageCard from "@/Components/Cards/ImageCard.vue";
import ImageInProject from "@/Components/Cards/ImageInProject.vue";
import UploadFile from "@/Components/Cards/UploadFile.vue";


import {computed, ref, watch} from "vue";


import {router} from "@inertiajs/vue3";
const props = defineProps({
    project:{
        type:Object,
        required:true,
    },
    images: {
        type:Array,
        required: true
    }
})

const reloadProject = (res) => {
    props.images.push(res["image"]);
    props.project.num_image = res["project"].num_image;
    props.project.confirmed_image = res["project"].confirmed_image;
}

const order_by = ref('desc');
const change_sort_order = () => {
    if (order_by.value === 'desc')
        order_by.value = 'asc';
    else
        order_by.value = 'desc';
}
const is_list = ref(false);
const pageSize = ref(10);
const currentPage = ref(1);
const onShowSizeChange = (current, pageSize) => {
    console.log(current, pageSize);
};

const pagedImages = computed(() => {
    const startIndex = (currentPage.value - 1) * pageSize.value;
    const endIndex = startIndex + pageSize.value;
    const orderImages =  props.images.slice(startIndex, endIndex);
    if (order_by.value === 'desc')
        return orderImages.sort((a,b) => {
            return a.file_name.localeCompare(b.file_name);
        })
    else{
        return orderImages.sort((a,b) => {
            return b.file_name.localeCompare(a.file_name);
        })
    }

});
const openLabelModel = () => {
    router.get(route("user.project.confirm-label", props.project.id));
}

// Processing modal
const defaultPercent = ref(0);
const processingType = ref("quality");
const isOpenProcessingModal = ref(false);
const showProcessingModal = () => {
    isOpenProcessingModal.value = true;
};
const processingModalHandleOk = () => {
    isOpenProcessingModal.value = false;
    defaultPercent.value = 0;
}
const UpdateAIResult = ref(false);
const preprocessing = async () => {
    console.log(props.project.images)
    if (props.project.images.length === 0){
        return;
    }
    showProcessingModal();
    let success_request = 0;
    let num_request = props.project.images.length;
    props.project.images.forEach((image) => {
        axios.get(route("user.image.processing", [image.id, UpdateAIResult.value])).then((res) => {
            success_request++;
            defaultPercent.value = Math.round(success_request/num_request * 100);
            if (success_request === num_request){
                setTimeout(() => {
                    processingModalHandleOk();
                    // reload page
                    router.get(route("user.project.detail", props.project.id));
                }, 2000); //


            }
        })
    });

}
</script>
