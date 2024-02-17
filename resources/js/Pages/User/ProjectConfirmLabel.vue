
<template>
    <AppLayout title="Confirm label">
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="border-b border-gray-300 pb-2">
                        <div class="grid grid-cols-3 items-center gap-4">
                            <div class="col-span-1">
                                <div class="flex justify-start items-center gap-2">
                                    <div class="bg-orange-100 py-1 px-2 rounded-lg">
                                        <i class="fa-regular fa-folder-open text-orange-400 text-2xl"></i>
                                    </div>
                                    <div >
                                        <button class="font-bold text-base text-blue-900" @click="openProjectDetail">{{ project.name }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <div class="flex justify-between items-center">
                                    <p class="text-sm text-gray-600">
                                        <i class="fa-solid fa-image mr-1"></i>
                                        {{currentImage.file_name}}
                                        <span class="bg-blue-500 py-1 px-2 rounded text-white ml-4" >Image Quality: {{currentImage.quality_label}} </span>
                                        <span class="bg-green-400 py-1 px-2 rounded text-white ml-4" v-if="currentImage.is_confirmed" > confirmed </span>
                                        <span class="bg-red-400 py-1 px-2 rounded text-white ml-4" v-else> Not confirm </span>
                                    </p>
                                    <div class="flex justify-end items-center gap-2">
                                        <div v-if="currentImage.is_confirmed">
                                            <a-button
                                                class="border border-orange-400 bg-orange-400 rounded-lg text-base
                                            text-white hover:text-orange-600 hover:bg-white"
                                                @click="confirmLabel"
                                                :loading="isProcessing"
                                            >
                                                Update label
                                            </a-button>
                                        </div>
                                        <div v-else>
                                            <a-button
                                                class="border border-green-500 bg-green-500 rounded-lg text-base
                                            text-white hover:text-green-600 hover:bg-white"
                                                @click="confirmLabel"
                                                :loading="isProcessing"
                                            >
                                                Confirm
                                            </a-button>
                                        </div>

                                        <button class="py-2 px-4 bg-gray-200 rounded-lg text-sm">
                                            {{images.current_page}}  <span class="text-lg ml-1 font-bold">| {{images.total}}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4 h-full">
                        <div class="col-span-1 border-r border-gray-300 pt-4 pr-4 h-full">
                            <p class="bg-gray-100 rounded-lg py-2 px-4 text-gray-500">{{project.description}}</p>
                            <ImageInProject :confirmed_img="project.confirmed_image" :total_img="project.num_image" />

                            <!-- Label Confirm selection -->

                            <div class="grid grid-cols-2 items-center gap-2 mt-8  border-t-2 border-gray-300 pt-2">
                                <div class="col-span-1">
                                    <button type="button" class="
                                        py-2 rounded-xl bg-gray-200 text-lg border font-bold w-full hover:border-orange-400 hover:bg-white hover:text-orange-400"
                                            :class="confirmMode === 'zone' ? 'border-orange-400 text-orange-400 bg-white' : 'border-gray-200 text-gray-500' "
                                            @click="changeConfirmMode"
                                    > Zone </button>
                                </div>
                                <div class="col-span-1">
                                    <button type="button" class="
                                            py-2 rounded-xl bg-gray-200 text-lg border font-bold w-full hover:border-orange-400 hover:bg-white hover:text-orange-400"
                                            :class="confirmMode !== 'zone' ? 'border-orange-400 text-orange-400 bg-white' : 'border-gray-200 text-gray-500'"
                                            @click="changeConfirmMode"
                                    > Gastritis </button>
                                </div>
                            </div>

                            <div class="mt-4 pl-8 pb-12">
                                <a-radio-group v-model:value="currentImage.zone_label_id" v-if="confirmMode === 'zone'">
                                    <a-radio :style="radioStyle" :value="imageZoneLabelItem.id" v-for="imageZoneLabelItem in imageZoneLabels">{{imageZoneLabelItem.name}}</a-radio>
                                </a-radio-group>
                                <a-radio-group v-model:value="currentBlock.ai_gastritis_label.label_id" v-else>
                                    <a-radio :style="radioStyle" :value="blockGastritisLabelItem.id" v-for="blockGastritisLabelItem in blockGastritisLabels">{{blockGastritisLabelItem.name}}</a-radio>
                                </a-radio-group>
                            </div>

                        </div>
                        <div class="col-span-2 h-full">
                            <div class="w-full pt-4">
                                <div class="grid grid-cols-10 items-center justify-center ">
                                    <div class="col-span-1 h-full">
                                        <button type="button" class="h-full w-full text-4xl text-gray-600 hover:text-blue-700"
                                                @click="prevImage"
                                                v-if="images.current_page > 1"
                                        >
                                            <div class="flex items-center justify-center justify-self-center h-full">
                                                <i class="fa-solid fa-angles-left"></i>
                                            </div>
                                        </button>
                                    </div>


                                    <div class="col-span-8 relative">
                                        <img :src="currentImage.file_path" class="w-full" alt="current-image" />
                                        <div class="absolute w-full h-full top-0"  v-if="confirmMode !== 'zone'" >
                                            <div class="grid grid-cols-4 grid-rows-4 w-full h-full"  style="padding: 2% 6%;">
                                                <button type="button"
                                                        class="w-full h-full px-4 text-base border font-bold
                                                        hover:border-blue-600 hover:border-2 hover:text-white hover:bg-blue-700/25"
                                                        v-for="(block,index) in currentImage.blocks"
                                                        @click="changeIndexBlock(index)"
                                                        :class="gastritisLabelByBlockIndex(index).label_id !== gastritisLabelByBlockIndex(index).label.id ? 'text-white bg-green-700/25' : 'text-yellow-400'"
                                                >
                                                  {{getGastritisLabelName(gastritisLabelByBlockIndex(index).label_id)}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-1 h-full">
                                        <button type="button" class="h-full w-full text-4xl text-gray-600 hover:text-blue-700"
                                                @click="nextImage"
                                                v-if="images.current_page  < images.last_page"
                                        >
                                            <div class="flex items-center justify-center justify-self-center h-full">
                                                <i class="fa-solid fa-angles-right"></i>
                                            </div>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import ImageInProject from "@/Components/Cards/ImageInProject.vue";
import {computed, reactive, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {notification} from "ant-design-vue";
const props = defineProps({
    project:{
        type:Object,
        required:true,
    },
    images: {
        type:Object,
        required: true
    },
    imageZoneLabels: {
        type:Array,
        required: true
    },
    blockGastritisLabels: {
        type:Array,
        required: true
    },
})


const currentImage = props.images.data[0];
const openProjectDetail = () => {
    router.get(route("user.project.detail",props.project.id));
}
const nextImage = () => {
    if (props.images.next_page_url)
        router.get(props.images.next_page_url);

}
const prevImage = () => {
    if (props.images.prev_page_url)
    router.get(props.images.prev_page_url);
}

const confirmMode = ref("gastritis");
// const confirmMode = ref("zone");
const changeConfirmMode = () => {
    confirmMode.value = confirmMode.value === "zone" ? "gastritis" : "zone";
}

const indexBlock = ref(0);
const currentBlock = computed(() => {
    return currentImage.blocks[indexBlock.value];
})
const changeIndexBlock = (index) => {
    indexBlock.value = index;
}

const radioStyle = reactive({
    display: 'flex',
    height: '40px',
    lineHeight: '40px',
    fontSize:'18px',
    color: "gray"
});

const getGastritisLabelName = (label_id) => {
    let label = props.blockGastritisLabels.find(item => item.id === label_id);
    return label.name;
}

const labelType = ref("byAi"); // byAi or byUser

const gastritisLabelByBlockIndex =(block_index) => {
    return labelType.value === "byAi" ? currentImage.blocks[block_index].ai_gastritis_label : currentImage.blocks[block_index].user_gastritis_label;
}

const isProcessing = ref(false);
const confirmLabel = () => {
    const data = {
        "blocks": [],
        "zone_id" : currentImage.zone_label_id,
        "image_id": currentImage.id
    }
    currentImage.blocks.forEach((item,index) => {
        data.blocks.push({
            "id": item.id,
            "label_id": gastritisLabelByBlockIndex(index).label_id
        })
    })
    //console.log(data);
    if(data["zone_id"]){
        router.post(route("user.image.confirm-label"), data, {
            onBefore:()=>{
                isProcessing.value = true
            },
            onSuccess:()=>{
                isProcessing.value = false
                notification['success']({
                    message: 'confirmed label for image successfully',
                    duration: 2
                });
                //nextImage();
            },
            onFinish:() =>{
                isProcessing.value = false
            }
        })
    }else{
        confirmMode.value = 'zone';
        notification['warning']({
            message: 'Please choose zone label of this image before confirm',
            duration: 2
        });

    }

}

</script>
