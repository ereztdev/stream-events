<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
const loginWithTwitch = () => {
    window.location.href = '/auth/twitch';
}
</script>

<template>
    <GuestLayout>
        <Head title="Register"/>

        <h2 class="flex justify-center mb-8 text-2xl font-extrabold leading-none tracking-tight text-gray-900
    dark:text-white underline underline-offset-3 decoration-8 decoration-blue-400 dark:decoration-blue-600"
        >
            Quick Social Register
        </h2>
        <button @click="loginWithTwitch" class="w-full bg-twitch mb-8 flex justify-center rounded px-6 py-2.5 text-xs font-medium uppercase
     leading-normal shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none
     focus:ring-0 active:shadow-lg"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 inline-block items-center"
                fill="currentColor"
                viewBox="0 0 24 24">
                <path
                    d="M2.149 0l-1.612 4.119v16.836h5.731v3.045h3.224l3.045-3.045h4.657l6.269-6.269v-14.686h-21.314zm19.164 13.612l-3.582 3.582h-5.731l-3.045 3.045v-3.045h-4.836v-15.045h17.194v11.463zm-3.582-7.343v6.262h-2.149v-6.262h2.149zm-5.731 0v6.262h-2.149v-6.262h2.149z"
                    fill-rule="evenodd"
                    clip-rule="evenodd"/>
            </svg>
            &nbsp; &nbsp; Twitch Login
        </button>
        <h2 class="flex justify-center mb-8 text-2xl font-extrabold leading-none tracking-tight text-gray-900
    dark:text-white underline underline-offset-3 decoration-8 decoration-blue-400 dark:decoration-blue-600"
        >
            Email Register
        </h2>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email"/>

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password"/>

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password"/>

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
