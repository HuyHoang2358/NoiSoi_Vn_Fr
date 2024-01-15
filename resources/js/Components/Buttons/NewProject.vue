<template>
    <button class="h-full w-full rounded-lg border-2 border-dashed border-gray-500 font-bold
    hover:border-orange-400 hover:text-orange-400 min-h-32" @click="clickButton">
        <i class="fa-solid fa-plus text-3xl"></i>
        <p class="text-lg"> New Project</p>
    </button>
</template>
<script setup>
const emits = defineEmits(["clickFunc"])

const clickButton = () => {
    emits("clickFunc");
}
</script>
