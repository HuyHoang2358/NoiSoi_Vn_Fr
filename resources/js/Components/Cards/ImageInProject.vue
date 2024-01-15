<template>
    <div class="grid grid-cols-3 items-center gap-2 mt-2">
        <div class="col-span-1 bg-blue-100 rounded-lg pb-1">
            <div class="flex justify-between items-center px-2 py-0">
                <div class="bg-blue-100 py-1 px-2 rounded-lg">
                    <i class="fa-solid fa-images text-blue-400 text-2xl"></i>
                </div>
                <p class="font-bold text-lg text-blue-500 mr-2">{{ total_img }}</p>
            </div>
            <p class="text-center text-blue-500 text-sm">Total images</p>
        </div>
        <div class="col-span-1 bg-green-100 rounded-lg pb-1">
            <div class="flex justify-between items-center px-2 py-0">
                <div class="bg-green-100 py-1 px-2 rounded-lg">
                    <i class="fa-solid fa-images text-green-400 text-2xl"></i>
                </div>
                <p class="font-bold text-lg text-green-500 mr-2">{{ confirmed_img }}</p>
            </div>
            <p class="text-center text-green-500 text-sm">Confirmed</p>
        </div>
        <div class="col-span-1 bg-red-100 rounded-lg pb-1">
            <div class="flex justify-between items-center px-2 py-0">
                <div class="bg-red-100 py-1 px-2 rounded-lg">
                    <i class="fa-solid fa-images text-red-400 text-2xl"></i>
                </div>
                <p class="font-bold text-lg text-red-500 mr-2">{{ total_img - confirmed_img }}</p>
            </div>
            <p class="text-center text-red-500 text-sm">Not confirm</p>
        </div>
    </div>
</template>
<script setup>
defineProps({
    total_img:{
        type:Number,
        required:true
    },
    confirmed_img:{
        type:Number,
        required:true
    }
});
</script>
