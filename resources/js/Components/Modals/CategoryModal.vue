<template>
    <a-modal
        :open="open"
        :mask-closable ="false"
        :footer="false"
        :title="getTitle"
        @cancel="$emit('closeModal')"
    >
        <a-form
            :model="formState"
            layout="vertical"
            @finish="handleFinish"
        >
            <a-form-item
                name="name"
                label="Category Name"
                :rules="[{ required: true, message: 'Please input category name!' }]"
            >
                <a-input
                    v-model:value="formState.name"
                    placeholder="Label Name"
                    :allow-clear="true"
                />
            </a-form-item>
            <a-form-item
                name="name"
                label="Category Slug"
            >
                <a-input
                    v-model:value="formState.slug"
                    placeholder="Slug for this category..."
                    :allow-clear="true"
                />
            </a-form-item>


            <a-form-item>
                <div class="flex flex-row justify-end gap-x-4 items-center">
                    <a-button @click="$emit('closeModal')"> Cancel </a-button>

                    <a-button
                        type="primary"
                        html-type="submit"
                        danger
                        :loading="isProcessing"
                    >
                       {{isEdit ? "Update" : "Add"}}
                    </a-button>
                </div>
            </a-form-item>
        </a-form>
    </a-modal>
</template>
<script setup>
import {computed, reactive, watch} from "vue";
    const props = defineProps({
        open:{
            type:Boolean,
            required:true
        },
        isEdit: {
            type: Boolean,
            default: false,
            required: true,
        },
        isProcessing: {
            type: Boolean,
            default: false,
            required: true,
        },
        currentCategory: {
            type: Object,
            default: () => {
                return {
                    name: "",
                    slug: "",
                };
            },
        },
    })
    const emits = defineEmits(["closeModal", "onSave"])

    const getTitle = computed(() => {
        return props.isEdit.value ? "Edit Category" : "Add New Category";
    });

    const formState = reactive({
        name: "",
        slug: "",
    });

    watch(
        () => props.currentCategory,
        (currentCategory) => {
            if (currentCategory) {
                formState.name = props.currentCategory.name;
                formState.slug = props.currentCategory.slug;
            }
        },
        { immediate: true }
    );

    const handleFinish = () => {
        let newCategory = {
            name: formState.name,
            slug: formState.slug,
            id: props.currentCategory?.id || null,
        };
        formState.name = "";
        formState.slug = "";
        emits("onSave", newCategory);
    };


</script>
