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
                label="Label Name"
                :rules="[{ required: true, message: 'Please input label name!' }]"
            >
                <a-input
                    v-model:value="formState.name"
                    placeholder="Label Name"
                    :allow-clear="true"

                />
            </a-form-item>
            <a-form-item
                name="class_id"
                label="AI class"
            >
                <a-input-number
                    class="w-full"
                    v-model:value="formState.class_id"
                    placeholder="AI Class ID"
                    :allow-clear="true"
                />
            </a-form-item>
            <a-form-item
                name="category_id"
                label="Label Type"
            >
               <a-select v-model:value="formState.category_id"
               :options="categoryOptions"
               >
               </a-select>
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
        currentLabel: {
            type: Object,
            default: () => {
                return {
                    name: "",
                    class_id: "",
                    category_id: 1,
                };
            },
        },
        currentCategory: {
            type: Object,
            required: true,
        },
        categories: {
            type: Array,
            required: true,
        }
    })
    const emits = defineEmits(["closeModal", "onSave"])

    const getTitle = computed(() => {
        return props.isEdit.value ? "Edit Label" : "Add New Label";
    });
    const formState = reactive({
        name: "",
        class_id: "",
        category_id: 1,
    });
    watch(
        () => props.currentCategory,
        (currentLabel) => {
            if (currentLabel) {
                formState.category_id = props.currentCategory.id;
            }
        },{ immediate: true }
    );

    watch(
        () => props.currentLabel,
        (currentLabel) => {
            if (currentLabel) {
                formState.name = props.currentLabel.name;
                formState.class_id = props.currentLabel.class_id;
                formState.category_id = props.currentLabel.category_id;
            }
        },
        { immediate: true }
    );

    const categoryOptions = computed(() => {
        return props.categories.map((category) => {
            return {
                label: category.name,
                value: category.id,
            };
        });
    });
    const handleFinish = () => {
        let newLabel = {
            name: formState.name,
            class_id: formState.class_id,
            category_id: formState.category_id,
            id: props.currentLabel?.id || null,
        };
        emits("onSave", newLabel);

        formState.name= "";
        formState.class_id= "";
        formState.type= "quality";
    };


</script>
