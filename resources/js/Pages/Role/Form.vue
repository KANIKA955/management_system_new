<template>
    <Modal v-slot="{ close }" ref="RoleForm">
        <form @submit.prevent="submitForm">
            <div class="w-full flex flex-col items-center py-4">
                <span class="text-2xl font-semibold text-dark/80 dark:text-light/80">
                    {{ isEdit ? 'Edit Role' : 'Add New Role' }}
                </span>
                <span class="text-sm font-semibold text-dark/80 dark:text-light/80">
                    Set Role Permissions
                </span>
            </div>

            <div class="w-full py-4">
                <div class="flex flex-col gap-1">
                    <label for="role" class="font-semibold text-sm text-dark/80 dark:text-light/80">
                        Role
                    </label>
                    <input
                        type="text"
                        v-model="form.name"
                        placeholder="Enter Role Name..."
                        :disabled="loading"
                        class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80
                               border-dark/30 dark:border-light/30 hover:border-dark/90
                               dark:hover:border-light/90 focus:border-dark/90
                               dark:focus:border-light/90 rounded-[3px] focus:outline-none
                               focus:ring-0 transition ease-in duration-200"
                    />
                </div>
            </div>

            <div class="w-full flex flex-col py-4">
                <span class="text-xl font-semibold text-dark/80 dark:text-light/80">
                    Role Permissions
                </span>
            </div>

            <div class="w-full bg-light dark:bg-darkTrans shadow-lg shadow-dark/10 dark:shadow-dark
                        flex flex-col justify-between overflow-x-auto">
                <table class="border-collapse border-[1px] border-dark/30 dark:border-light/30 w-full">
                    <tr>
                        <th colspan="5"
                            class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-md text-dark/80 dark:text-light/80 font-bold">
                            <div class="flex justify-between items-center">
                                <span>
                                     Administrator Access
                                </span>
                                <div class="flex items-center gap-2">
                                    <input
                                        type="checkbox"
                                        @click="toggleAllPermissions"
                                        :checked="areAllPermissionsSelected"
                                        class="rounded-sm text-primary dark:text-info bg-transparent
                                           border-[2px] border-dark/30 dark:border-light/30
                                           focus:ring-0 focus:outline-none"
                                        :disabled="loading"
                                    />
                                    <span>Select All</span>
                                </div>
                            </div>
                        </th>
                    </tr>

                    <tr v-for="group in permissionGroups" :key="group.name">
                        <th class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-sm text-dark/80 dark:text-light/80 font-normal">
                            {{ group.name }}
                        </th>
                        <th v-for="perm in group.permissions" :key="perm.id"
                            class="text-left border-[1px] border-dark/30 dark:border-light/30 px-2 py-1 text-md text-dark/80 dark:text-light/80 font-normal"
                        >
                            <div class="flex items-center gap-2">
                                <input
                                    type="checkbox"
                                    v-model="form.permissions"
                                    :value="perm.id"
                                    class="rounded-sm text-primary dark:text-info bg-transparent
                                           border-[2px] border-dark/30 dark:border-light/30
                                           focus:ring-0 focus:outline-none"
                                    :disabled="loading"
                                />
                                <span>{{ perm.name }}</span>
                            </div>
                        </th>
                    </tr>
                </table>
            </div>

            <div class="w-full flex gap-2 justify-center py-4 mt-4">
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b
                           from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white
                           hover:scale-105 transition ease-in duration-2000"
                >


                    <span v-if="loading"><i class="fa fa-spinner animate-spin"></i> <span class="animate-pulse">Saving..</span></span>
                    <span v-else>{{ isEdit ? 'Update' : 'Submit' }}</span>
                </button>
            </div>
        </form>
    </Modal>
</template>

<script setup>
import { reactive, computed, ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import Toast from "@/Utils/toast.js";

const RoleForm = ref(null);
const props = defineProps(['role', 'permissionGroups']);
const page = usePage();

const form = reactive({
    name: props.role?.name || '',
    permissions: props.role?.permissions?.map(p => p.id) || []
});

const isEdit = computed(() => !!props.role);
const permissionGroups = computed(() => props.permissionGroups);
const loading = ref(false);

const areAllPermissionsSelected = computed(() =>
    permissionGroups.value.every(group =>
        group.permissions.every(perm => form.permissions.includes(perm.id))
    )
);

const toggleAllPermissions = () => {
    if (areAllPermissionsSelected.value) {
        form.permissions = [];
    } else {
        form.permissions = permissionGroups.value.flatMap(group =>
            group.permissions.map(perm => perm.id)
        );
    }
};

const submitForm = () => {
    loading.value = true;
    const requestMethod = isEdit.value ? 'put' : 'post';
    const url = isEdit.value ? `/roles/${props.role.id}` : '/roles';
    router[requestMethod](url, form, {
        onSuccess: () => {
            RoleForm.value.close();
            RoleForm.value.emit('roleCreated')
            Toast.success(page.props.toast.message);
        },
        onError: (errors) => {
            Toast.error(errors.data);
        },
        finally: () => {
            loading.value = false;
        }
    });
};
</script>
