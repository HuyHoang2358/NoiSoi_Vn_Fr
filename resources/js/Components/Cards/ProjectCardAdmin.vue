<template>

    <div class="rounded-xl border border-gray-300 hover:shadow-xl py-4" >
        <div class="flex justify-between items-center gap-2 px-4">
            <div class="flex justify-start items-center gap-2">
                <div class="bg-orange-100 py-1 px-2 rounded-lg">
                    <i class="fa-regular fa-folder-open text-orange-400 text-2xl"></i>
                </div>
                <div >
                    <a class="font-bold text-base text-blue-900">{{ project.name }}</a>
                    <p class="text-xs text-gray-500">
                        <span class="text-green-600 font-bold">{{project.confirmed_image}}</span>
                        /
                        <span class="text-red-500 font-bold">{{ project.num_image }}</span>
                        images
                    </p>
                </div>
            </div>
        </div>
        <div class="text-sm font-normal text-gray-600 py-4 px-4 h-24 mt-2">
            {{project.description}}
        </div>
        <hr class="border-gray-300">
        <div class="flex justify-between items-center gap-4 pt-2 px-4">
            <div class="text-blue-900 text-sm font-semibold">
                <p>By {{project.user.name}}</p>
            </div>
            <div class="text-gray-600 text-xs">
                <p>{{formatTime(project.updated_at)}}</p>
            </div>
        </div>
    </div>

</template>
<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    project:{
        type: Object,
        required: true,
    }});


const formatTime = (time) => {
    const date = new Date(time);
    return date.toLocaleDateString();
}

</script>
