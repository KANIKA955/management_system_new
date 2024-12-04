<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <FormSection @submitted="updatePassword">
        <template #title>
            Update Password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <div class="flex flex-col gap-1">
                    <label for="current_password" class="font-semibold text-sm text-dark/80 dark:text-light/80">Current Password</label>
                    <input id="current_password" type="password"  placeholder="Current password..." v-model="form.current_password" class=" px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/50 dark:border-light/50 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                </div>
                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">

                <div class="flex flex-col gap-1">
                    <label for="password" class="font-semibold text-sm text-dark/80 dark:text-light/80">New Password</label>
                    <input id="password" type="password"  placeholder="Current password..." v-model="form.password" class=" px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/50 dark:border-light/50 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                </div>
                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">

                <div class="flex flex-col gap-1">
                    <label for="password_confirmation" class="font-semibold text-sm text-dark/80 dark:text-light/80">Confirm Password</label>
                    <input id="password_confirmation" type="password"  placeholder="Current password..." v-model="form.password_confirmation" class=" px-4 py-1.5 bg-transparent border-[1px] text-dark/80 dark:text-light/80 border-dark/50 dark:border-light/50 hover:border-dark/90 dark:hover:border-light/90 focus:border-dark/90 dark:focus:border-light/90  rounded-[3px] focus:outline-none focus:ring-0 transition ease-in duration-2000">
                </div>
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" class="text-sm px-4 py-1 rounded-sm font-semibold bg-gradient-to-r hover:bg-gradient-to-b from-primary to-primary/70 dark:from-info/50 dark:to-info/80 text-white hover:scale-105 transition ease-in duration-2000" :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
    </FormSection>
</template>
