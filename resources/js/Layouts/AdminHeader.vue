<template>
    <a-layout-header
        :style="{background: '#fff', padding: '0 20px'}"
        class="flex flex-row justify-end items-center">
        <div class="flex flex-row justify-end items-center gap-2">
            <a-popover
                title="Nofications"
                trigger="click"
                placement="bottomRight"
            >
                <template #content>
                    <a-list
                        itemLayout="horizontal"
                        :data-source="data"
                        style="width: 350px; max-height: 450px"
                        class="overflow-auto"
                        >
                    </a-list>
                </template>
                <a-button
                    type="ghost"
                    class="w-10 h-10 m-0 p-0"
                    title="Notifications"
                >
                    <i class="fa-solid fa-bell text-red-500 text-lg group-hover:text-main"></i>
                </a-button>
            </a-popover>

            <a-dropdown
                placement="bottomRight"
                :arrow="{pointAtCenter:true}"
                trigger="click"
            >
                <a-button
                    type="ghost"
                    class="w-10 h-10 m-0 p-0"
                    title="Profile">
                    <i class="fa-solid fa-user text-red-500 text-lg group-hover:text-main"></i>
                </a-button>
                <template #overlay>
                    <a-menu>

                        <div class=" text-center py-2">
                           <p class="text-sm font-semibold text-black">{{ $page.props.auth.user.name }}</p>
                           <p class="text-sm font-light text-gray-400">{{ $page.props.auth.user.email }}</p>
                        </div>
                        <a-divider class="h-px bg-[#373737] m-0 p-0" style="margin: 0" />

                        <Link :href="route('profile.show')"  class="block py-2 px-4 text-xs text-gray-500 text-left">
                            Profile Information
                        </Link>
                        <Link :href="route('profile.show')"  class="block py-2 px-4 text-xs text-gray-500 text-left">
                            Setting
                        </Link>

                        <a-divider class="h-px bg-[#373737] m-0 p-0" style="margin: 0" />
                        <form @submit.prevent="logout">
                           <button type="submit" class="block py-2 px-4 text-xs text-gray-500 text-lef">
                               <div class="flex justify-center items-center gap-2">
                                   <i class="fa-solid fa-right-from-bracket mr-2"></i>
                                   <p> Log out</p>
                               </div>
                           </button>
                        </form>
                    </a-menu>
                </template>
            </a-dropdown>
        </div>
    </a-layout-header>
</template>
<script setup>
import {Link, router} from "@inertiajs/vue3";
const logout = () => {
    router.post(route('logout'));
};
const data = []
</script>
