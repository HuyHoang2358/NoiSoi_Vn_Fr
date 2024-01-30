
<template>
    <AppLayout title="Project Detail">
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
                                        <span class="bg-green-400 py-1 px-2 rounded text-white ml-4" v-if="currentImage.is_confirmed" > confirmed </span>
                                        <span class="bg-red-400 py-1 px-2 rounded text-white ml-4" v-else> Not confirm </span>
                                    </p>
                                    <div class="flex justify-end items-center gap-2">
                                        <div v-if="currentImage.is_confirmed">
                                            <button
                                                class="py-2 px-4 border border-orange-400 bg-orange-400 rounded-lg text-lg
                                            text-white hover:text-orange-600 hover:bg-white"
                                                @click="confirmLabel"
                                                v-if="labelType !== 'quality'"
                                            >
                                                Update label
                                            </button>
                                        </div>
                                        <div v-else>
                                            <button
                                                class="py-2 px-4 border border-green-500 bg-green-500 rounded-lg text-lg
                                            text-white hover:text-green-600 hover:bg-white"
                                                @click="confirmLabel"
                                                v-if="labelType !== 'quality'"
                                            >
                                                Confirm
                                            </button>
                                        </div>

                                        <button class="py-2 px-4 bg-gray-200 rounded-lg text-sm">
                                            {{indexImage + 1}}  <span class="text-lg ml-1 font-bold">| {{images.length}}</span>
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

                            <div class="grid grid-cols-2 items-center gap-2 mt-8  border-t-2 border-gray-300 pt-2">
                                <div class="col-span-1">
                                    <button type="button" class="
                                        py-2 rounded-xl bg-gray-200 text-lg border font-bold w-full hover:border-orange-400 hover:bg-white hover:text-orange-400"
                                        :class="labelType === 'quality' ? 'border-orange-400 text-orange-400 bg-white' : 'border-gray-200 text-gray-500' "
                                        @click="changeLabelType"
                                    > Quality </button>
                                </div>
                                <div class="col-span-1">
                                    <button type="button" class="
                                            py-2 rounded-xl bg-gray-200 text-lg border font-bold w-full hover:border-orange-400 hover:bg-white hover:text-orange-400"
                                            :class="labelType !== 'quality' ? 'border-orange-400 text-orange-400 bg-white' : 'border-gray-200 text-gray-500'"
                                            @click="changeLabelType"
                                    > Gastritis </button>
                                </div>
                            </div>
                            <div class="mt-4 pl-8 pb-12">
                                <a-radio-group v-model:value="currentImage.quality_label.label_id" v-if="labelType === 'quality'">
                                    <a-radio :style="radioStyle" :value="qualityLabelItem.id" v-for="qualityLabelItem in qualityLabels">{{qualityLabelItem.name}}</a-radio>
                                </a-radio-group>
                                <a-radio-group v-model:value="currentSubImage.gastritis_label.label_id" v-else>
                                    <a-radio :style="radioStyle" :value="gastritisLabelItem.id" v-for="gastritisLabelItem in gastritisLabels">{{gastritisLabelItem.name}}</a-radio>
                                </a-radio-group>
                            </div>
                        </div>
                        <div class="col-span-2 h-full">
                            <div class="w-full pt-4">
                                <div class="grid grid-cols-10 items-center justify-center ">
                                    <div class="col-span-1 h-full">
                                        <button type="button" class="h-full w-full text-4xl text-gray-600 hover:text-blue-700"
                                                @click="prevImage"
                                                v-if="indexImage > 0"
                                        >
                                            <div class="flex items-center justify-center justify-self-center h-full">
                                                <i class="fa-solid fa-angles-left"></i>
                                            </div>
                                        </button>
                                    </div>


                                    <div class="col-span-8 relative">
                                        <img :src="currentImage.file_path" class="w-full" />
                                        <div class="absolute w-full h-full top-0"  v-if="labelType !== 'quality'">
                                            <div class="grid grid-cols-4 grid-rows-4 w-full h-full">
                                                <button type="button"
                                                        class="w-full h-full px-4 text-base border border-yellow-500
                                                         font-bold
                                                        hover:border-blue-600 hover:border-2 hover:text-white hover:bg-blue-700/25"
                                                        v-for="(sub_image,index) in currentImage.sub_images"
                                                        @click="changeIndexSubImage(index)"
                                                        :class="sub_image.gastritis_label.label_id !== sub_image.gastritis_label.label.id ? 'text-white bg-green-700/25' : 'text-yellow-400'"
                                                >
                                                    {{getGastritisLabelName(sub_image.gastritis_label.label_id)}}
<!--                                                    {{sub_image.gastritis_label.label.name}}-->
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-1 h-full">
                                        <button type="button" class="h-full w-full text-4xl text-gray-600 hover:text-blue-700"
                                                @click="nextImage"
                                                v-if="indexImage < images.length - 1"
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
import {computed, reactive, ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
const props = defineProps({
    project:{
        type:Object,
        required:true,
    },
    images: {
        type:Array,
        required: true
    },
    qualityLabels: {
        type:Array,
        required: true
    },
    gastritisLabels: {
        type:Array,
        required: true
    },
})
const openProjectDetail = () => {
    router.get(route("user.project.detail",props.project.id));
}
const getGastritisLabelName = (label_id) => {
    let label = props.gastritisLabels.find(item => item.id === label_id);
    return label.name;
}
const labelType = ref("gastritis");
const changeLabelType = () => {
    if (labelType.value === "quality"){
        labelType.value = "gastritis"
    }else{
        labelType.value = "quality"
    }
}

const radioStyle = reactive({
    display: 'flex',
    height: '40px',
    lineHeight: '40px',
    fontSize:'18px',
    color: "gray"
});

const indexImage = ref(0);
const nextImage = () => {
    if (indexImage.value < props.images.length - 1){
        indexImage.value += 1;
    }
}
const prevImage = () => {
    if (indexImage.value > 0){
        indexImage.value -= 1;
    }
}
const value = ref(1);
const currentImage = computed(() => {
    return props.images[indexImage.value];
})


const indexSubImage = ref(0);
const currentSubImage = computed(() => {
    return currentImage.value.sub_images[indexSubImage.value];
})
const changeIndexSubImage = (index) => {
    indexSubImage.value = index;
}
const confirmLabel = () => {
    console.log(currentImage.value);
    const data = {
        "sub_images": [],
    }
    currentImage.value.sub_images.forEach((item) => {
        data.sub_images.push({
            "id": item.id,
            "label_id": item.gastritis_label.label_id
        })
    })
    console.log(data);
    axios.post(route("user.image.confirm-label"), data).then((res) => {
        console.log(res);
        props.images[indexImage.value] = res.data.current_image;
    }).catch((err) => {
        console.log(err);
    })
}
</script>
