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
            >
                <a-input
                    v-model:value="formState.name"
                    placeholder="Label Name"
                    :allow-clear="true"
                />
            </a-form-item>
            <a-form-item
                name="class"
                label="Label class"
            >
                <a-input
                    v-model:value="formState.class_id"
                    placeholder="AI Class ID"
                    :allow-clear="true"
                />
            </a-form-item>
            <a-form-item
                name="type"
                label="Label Type"
            >
               <a-select v-model:value="formState.type">
                   <a-select-option value="quality">Quality</a-select-option>
                   <a-select-option value="gastritis">Gastritis</a-select-option>
               </a-select>
            </a-form-item>
            <a-form-item>
                <div class="flex flex-row justify-end gap-x-4 items-center">
                    <a-button @click="$emit('closeModal')"> Cancel </a-button>

                    <a-button
                        type="primary"
                        html-type="submit"
                        danger
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
        currentLabel: {
            type: Object,
            default: () => {
                return {
                    name: "",
                    class_id: "",
                    type: "quality",
                };
            },
        },
    })
    const emits = defineEmits(["closeModal", "onSave"])

    const getTitle = computed(() => {
        return props.isEdit.value ? "Edit Label" : "Add New Label";
    });
    const formState = reactive({
        name: "",
        class_id: "",
        type: "quality",
    });

    watch(
        () => props.currentLabel,
        (currentLabel) => {
            if (currentLabel) {
                formState.name = props.currentLabel.name;
                formState.class_id = props.currentLabel.class_id;
                formState.type = props.currentLabel.type;
            }
        },
        { immediate: true }
    );

    const handleFinish = () => {
        let newLabel = {
            name: formState.name,
            class_id: formState.class_id,
            type: formState.type,
            id: props.currentLabel?.id || null,
        };

        formState.name= "";
        formState.class_id= "";
        formState.type= "quality";

        emits("onSave", newLabel);
    };


</script>
