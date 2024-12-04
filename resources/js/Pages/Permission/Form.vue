<template>
    <Modal v-slot="{ close }" ref="PermissionForm">
        <form @submit.prevent="submitForm">
            <div class="w-full flex flex-col items-center py-4">
                <span class="text-2xl font-semibold text-dark/80 dark:text-light/80">
                    {{ isEditing ? 'Edit Permission' : 'Add New Permission' }}
                </span>
                <span class="text-sm font-semibold text-dark/80 dark:text-light/80">
                    Add permission as per your requirements.
                </span>
            </div>
            <div class="w-full py-4 ">
                <div class="flex flex-col gap-1">
                    <label for="permission"
                           class="font-semibold text-sm text-dark/80 dark:text-light/80">Permission</label>
                    <input
                        type="text"
                        v-model="form.name"
                        placeholder="Enter Permission Name..."
                        :disabled="isLoading"
                        class="px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/30 dark:border-light/30 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90 rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000"
                    >
                </div>
            </div>

            <button
                type="submit"
                :disabled="isLoading"
                class="w-full text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000"
            >
                {{ isLoading ? 'Loading...' : (isEditing ? 'Update' : 'Submit') }}
            </button>
        </form>
    </Modal>
</template>

<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import Toast from "@/Utils/toast.js";
const PermissionForm = ref(null);

const form = ref({
    name: ''
});
const isLoading = ref(false);
const isEditing = ref(false); // Track if we're editing
const page = usePage();
const submitForm = () => {
    isLoading.value = true;

    const url = isEditing.value ? `/permissions/${form.value.id}` : '/permissions';

    router.post(url, form.value, {
        onSuccess: () => {
            Toast.success(page.props.toast.message);
            resetForm();
            PermissionForm.value.close();

        },
        onError: (errors) => {
            Object.values(errors).forEach((error) => {
                Toast.error(error);
            });
            isLoading.value = false;
        },
        finally: () => {
            isLoading.value = false;
        }
    });
};

const resetForm = () => {
    form.value = { name: '' }; // Reset form fields
    isEditing.value = false; // Reset editing state
};

// This function should be called when editing a permission
const editPermission = (permission) => {
    form.value = { ...permission }; // Populate form with existing permission data
    isEditing.value = true; // Set editing state to true
};

</script>
