<template>
    <button type="button" class="rounded-lg bg-white border border-gray-500 px-4 py-1
    hover:bg-gray-500 text-gray-500 hover:text-white" @click="clickButton">
        <slot></slot>
    </button>
</template>
<script setup>
    const emits = defineEmits(["clickFunc"])

    const clickButton = () => {
    emits("clickFunc");
}

</script>
