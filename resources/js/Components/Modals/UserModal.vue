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
                label="Full Name"
            >
                <a-input
                    v-model:value="formState.name"
                    placeholder="Full Name"
                    :allow-clear="true"
                />
            </a-form-item>
            <a-form-item
                name="email"
                label="Email Address"
            >
                <a-input
                    v-model:value="formState.email"
                    placeholder="Email Address"
                    :allow-clear="true"
                />
            </a-form-item>
            <a-form-item
                name="phone"
                label="Phone Number"
            >
                <a-input
                    v-model:value="formState.phone"
                    placeholder="Phone Number"
                    :allow-clear="true"
                />
            </a-form-item>
            <a-form-item
                name="address"
                label="Address"
            >
                <a-textarea
                    v-model:value="formState.address"
                    placeholder="Address"
                    :allow-clear="true"
                />
            </a-form-item>
            <a-form-item
                name="role_id"
                label="Account Type"
            >
               <a-select v-model:value="formState.role_id">
                   <a-select-option :value="role.id" v-for="(role) in roles" >{{role.name}}</a-select-option>
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
                        {{isEdit ? "Update information" : "Add new user"}}
                    </a-button>
                </div>
            </a-form-item>
        </a-form>
    </a-modal>
</template>
<script setup>
import {computed, reactive, watch} from "vue";
    const props = defineProps({
        roles:{
            type:Array,
            required:true
        },
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
        currentUser: {
            type: Object,
            default: () => {
                return {
                    name: "",
                    email: "",
                    phone: "",
                    address: "",
                    role_id: 2,
                };
            },
        },
    })
    const emits = defineEmits(["closeModal", "onSave"])

    const getTitle = computed(() => {
        return props.isEdit.value ? "Edit User Information" : "Add New User";
    });
    const formState = reactive({
        name: "",
        email: "",
        phone: "",
        address: "",
        role_id: 2,
    });

    watch(
        () => props.currentUser,
        (currentUser) => {
            if (currentUser) {
                formState.name = props.currentUser.name;
                formState.email = props.currentUser.email;
                formState.phone = props.currentUser.phone;
                formState.address = props.currentUser.address;
                formState.role_id = props.currentUser.role_id;
            }
        },
        { immediate: true }
    );

    const handleFinish = () => {
        let newUser = {
            name: formState.name,
            email: formState.email,
            phone: formState.phone,
            address: formState.address,
            role_id: formState.role_id,
            id: props.currentUser?.id || null,
        };

        formState.name= "";
        formState.email= "";
        formState.phone= "";
        formState.address= "";
        formState.role_id= 2;
        emits("onSave", newUser);
    };


</script>
