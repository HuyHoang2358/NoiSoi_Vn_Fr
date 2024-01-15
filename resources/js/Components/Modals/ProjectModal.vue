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
                label="Project Name"
            >
                <a-input
                    v-model:value="formState.name"
                    placeholder="Type project name ... "
                    :allow-clear="true"
                />
            </a-form-item>
            <a-textarea
                v-model:value="formState.description"
                placeholder="Type description of project ..."
                :auto-size="{ minRows: 2, maxRows: 5 }"
            />
            <a-form-item>
                <div class="flex flex-row justify-end gap-x-4 items-center mt-8">
                    <CancelButton @click="$emit('closeModal')"> Cancel </CancelButton>
                    <submit-form-button> {{isEdit ? "Update" : "Create"}}  </submit-form-button>
                </div>
            </a-form-item>
        </a-form>
    </a-modal>


</template>
<script setup>

import {computed, defineProps, reactive, watch} from "vue";
import SubmitFormButton from "@/Components/Buttons/SubmitFormButton.vue";
import CancelButton from "@/Components/Buttons/CancelButton.vue";

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
    currentProject: {
        type: Object,
        default: () => {
            return {
                name: "",
                description: "",
            };
        },
    },
});
const emits = defineEmits(["closeModal", "onSave"])

const getTitle = computed(() => {
    return props.isEdit ? "Edit project" : "Create new project";
});

const formState = reactive({
    name: "",
    description: "",
});


watch(
    () => props.currentProject,
    (currentLabel) => {
        if (currentLabel) {
            formState.name = props.currentProject.name;
            formState.description = props.currentProject.description;
        }
    },
    { immediate: true }
);

const handleFinish = () => {
    const data = {
        name: formState.name,
        description: formState.description,
        id: props.currentProject?.id || null,
    };
    formState.name = "";
    formState.description = "";

    emits("onSave", data);
};
</script>
