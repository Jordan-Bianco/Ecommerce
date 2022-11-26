<script setup>
import Checkbox from "@/Components/Breeze/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/Breeze/InputError.vue";
import InputLabel from "@/Components/Breeze/InputLabel.vue";
import TextInput from "@/Components/Breeze/TextInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <header>
                <h2 class="font-medium uppercase text-3xl text-center py-4">Log in</h2>
                <p class="text-center text-sm text-zinc-500 mb-6">
                    Aren't you registered yet?
                    <Link
                        href="register"
                        class="text-c-green-500"
                        >Register now</Link
                    >
                </p>
            </header>

            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full placeholder-zinc-400"
                    placeholder="Enter your email"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-5">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full placeholder-zinc-400"
                    placeholder="Enter your password"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-5">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-xs text-zinc-500">Remember me</span>
                </label>
            </div>

            <div class="mt-6">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="block max-w-max text-xs text-zinc-500 hover:text-zinc-600 mb-1.5"
                >
                    Forgot your password?
                </Link>

                <button
                    type="submit"
                    :disabled="form.processing"
                    :class="form.processing ? 'bg-c-green-300' : 'bg-c-green-600 hover:bg-c-green-300'"
                    class="text-white text-xxs w-full py-3 rounded transition flex justify-center"
                >
                    <span class="uppercase" v-if="!form.processing">Log in</span>
                    <svg v-else class="animate-spin-fast w-[16px] h-[16px] text-white" fill="currentColor" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                    <g> <path d="M256,512c-34.6,0-68.1-6.8-99.6-20.1C125.9,479,98.5,460.5,75,437s-42-50.9-54.9-81.4C6.8,324.1,0,290.5,0,256
                            c0-9.9,8.1-18,18-18s18,8.1,18,18c0,29.7,5.8,58.5,17.3,85.6c11.1,26.2,26.9,49.8,47.1,70c20.2,20.2,43.8,36.1,69.9,47.1
                            c27.1,11.5,55.9,17.3,85.6,17.3s58.5-5.8,85.6-17.3c26.2-11.1,49.8-27,70-47.2c20.2-20.2,36.1-43.8,47.1-69.9
                            c11.5-27.1,17.3-55.9,17.3-85.6c0-29.7-5.8-58.5-17.3-85.6c-11.1-26.1-27.1-49.9-47.2-70c-20-20.1-43.8-36.1-69.9-47.1
                            C314.5,41.8,285.7,36,256,36c-9.9,0-18-8.1-18-18s8.1-18,18-18c34.6,0,68.1,6.8,99.6,20.1C386.2,33,413.5,51.5,437,75
                            s42,50.9,54.9,81.4c13.4,31.5,20.1,65.1,20.1,99.6c0,34.5-6.8,68.1-20.1,99.6C479,386.1,460.5,413.5,437,437s-50.9,42-81.4,54.9
                            C324.1,505.3,290.6,512,256,512z"/>
                    </g>
                    </svg>
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
