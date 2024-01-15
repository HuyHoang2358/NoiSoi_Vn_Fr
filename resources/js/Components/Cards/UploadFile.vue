<template>
    <div class="mt-4">
        <div class="h-64 overflow-y-auto">
            <div>
                <a-upload-dragger
                    v-model:fileList="fileList"
                    name="file"
                    :multiple="true"
                    :action="`/image/add/${project_id}`"
                    :data="{ _token: csrfToken }"
                    @change="handleChange"
                    @drop="handleDrop"
                >
                    <p>
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-blue-700"></i>
                    </p>
                    <p class="ant-upload-text text-base">Click or drag file to this area to upload</p>
                    <p class="ant-upload-hint text-sm px-2 text-left">
                        Support for a single or bulk upload. Strictly prohibit from uploading company data or other
                        band files
                    </p>
                </a-upload-dragger>
            </div>

        </div>
        <div class="flex justify-end items-center mt-2">
            <button class="bg-blue-500 text-white py-2 px-6 rounded-lg"
                @click="router.get(route('user.project.detail', props.project_id))"
            >Upload</button>
        </div>

    </div>
</template>
<script lang="ts" setup>
import {ref} from "vue";
const current = ref(1);

const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

const props = defineProps({
    project_id:{
        type:Number,
        required:true
    },
});
import type { UploadChangeParam } from 'ant-design-vue';
import {router} from "@inertiajs/vue3";

const fileList = ref([]);
const handleChange = (info) => {
    const items = info.fileList?.map((item)=> {return {...item, status:'done', percent: 100}});

};
function handleDrop(e: DragEvent) {
    console.log(e);
}


</script>
