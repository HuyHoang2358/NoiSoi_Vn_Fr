<template>
    <div class="p-2 rounded-lg" :class="(image.confirmed) ? 'bg-green-100' :'bg-gray-100' " v-if="!is_list">
        <div class="flex justify-between items-center gap-1 mb-1">
            <div class="flex justify-start items-center gap-2" @click="onPreview">
                <img :src="'/images/pngIcon.png'" alt="png-icon" class="w-4 h-4">
                <p class="text-xs overflow-hidden w-full" >{{truncateText(image.file_name, 12)}}</p>
            </div>
            <a-popover placement="rightTop">
                <template #content>
                    <a @click="onPreview">
                        <div class="flex justify-start items-center gap-2 text-gray-500 hover:text-orange-400 py-1 pr-4">
                            <i class="fa-solid fa-eye"></i>
                            <p>Preview</p>
                        </div>
                    </a>
                    <a @click="">
                        <div class="flex justify-start items-center gap-2 text-gray-500 hover:text-orange-400 py-1 pr-4">
                            <i class="fa-solid fa-tag"></i>
                            <p>Label Image</p>
                        </div>
                    </a>
                    <a @click="false">
                        <div class="flex justify-start items-center gap-2 text-gray-500 hover:text-orange-400 py-1 pr-4">
                            <i class="fa-regular fa-pen-to-square"></i>
                            <p>Rename</p>
                        </div>
                    </a>
                    <a @click="onDelete">
                        <div class="flex justify-start items-center gap-2 text-gray-500 hover:text-orange-400 py-1 pr-4">
                            <i class="fa-solid fa-trash-can"></i>
                            <p>Delete</p>
                        </div>
                    </a>
                </template>
                <button>
                    <i class="fa-solid fa-ellipsis-vertical text-base"></i>
                </button>
            </a-popover>
            <a-modal v-model:open="isOpenPreview" :title="`Image preview - ${image.file_name}`" @ok="handleOk">
                <img :src="image.file_path" alt="image" class="rounded">
            </a-modal>
        </div>
        <img :src="image.file_path" alt="image" class="rounded" @click="onPreview">
    </div>
    <div class="p-2 rounded-lg" :class="(image.confirmed) ? 'bg-green-100' :'bg-gray-100' " v-else>
        <div class="flex justify-between items-center gap-1 mb-1">
            <div class="flex justify-start items-center gap-2" @click="onPreview">
                <img :src="'/images/pngIcon.png'" alt="png-icon" class="w-4 h-4">
                <p class="text-xs overflow-hidden w-full">{{image.file_name}}</p>
            </div>
            <a-popover placement="rightTop">
                <template #content>
                    <a @click="onPreview">
                        <div class="flex justify-start items-center gap-2 text-gray-500 hover:text-orange-400 py-1 pr-4">
                            <i class="fa-solid fa-eye"></i>
                            <p>Preview</p>
                        </div>
                    </a>
                    <a @click="">
                        <div class="flex justify-start items-center gap-2 text-gray-500 hover:text-orange-400 py-1 pr-4">
                            <i class="fa-solid fa-tag"></i>
                            <p>Label Image</p>
                        </div>
                    </a>
                    <a @click="false">
                        <div class="flex justify-start items-center gap-2 text-gray-500 hover:text-orange-400 py-1 pr-4">
                            <i class="fa-regular fa-pen-to-square"></i>
                            <p>Rename</p>
                        </div>
                    </a>
                    <a @click="onDelete">
                        <div class="flex justify-start items-center gap-2 text-gray-500 hover:text-orange-400 py-1 pr-4">
                            <i class="fa-solid fa-trash-can"></i>
                            <p>Delete</p>
                        </div>
                    </a>
                </template>
                <button>
                    <i class="fa-solid fa-ellipsis-vertical text-base"></i>
                </button>
            </a-popover>
            <a-modal v-model:open="isOpenPreview" :title="`Image preview - ${image.file_name}`" @ok="handleOk">
                <img :src="image.file_path" alt="image" class="rounded">
            </a-modal>
        </div>
    </div>
</template>
<script setup>

import {ref} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    image:{
        type:Object,
        required:true
    },
    is_list:{
        type:Boolean,
        required:true
    }
})

const truncateText = (text, maxLength) => {
    if (text.length <= maxLength) {
        return text;
    } else {
        return text.slice(0, maxLength) + '...';
    }
};
const showImageDetail = () => {
    console.log("show image detail");
}
const isOpenPreview = ref(false);
const onPreview = () => {
    isOpenPreview.value = true
}
const handleOk = () => {
    isOpenPreview.value = false;
};
const onDelete = () => {
    router.delete(route("user.image.destroy",props.image.id));
}
</script>
