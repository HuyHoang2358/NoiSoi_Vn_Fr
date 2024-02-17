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
    </div>
</template>
<script setup>
import {ref} from "vue";
import {notification} from "ant-design-vue";
const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
const props = defineProps({
    project_id:{
        type:Number,
        required:true
    },
});
const emits = defineEmits(['reloadProject'])
const fileList = ref([]);

const handleChange = (info) => {
    console.log(info);
    if (info.file.status === 'done') {
        // upload image Done
        console.log("done", info.file.response);
        notification['success']({
            message: info.file.response.message,
            duration: 3
        });
        emits('reloadProject', info.file.response);
    }else if(info.file.status === 'error') {
        console.log("error", info.file.response.message);
        notification['error']({
            message:  info.file.response.message,
            duration: 3
        });
    }
};
function handleDrop(e) {
    console.log(e);
}
</script>
