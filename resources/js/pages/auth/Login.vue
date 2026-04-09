<script setup>
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen bg-green-50/50 flex items-center justify-center p-0 md:p-4 font-sans antialiased">
        
        <div class="w-full max-w-7xl bg-white md:rounded-[2rem] shadow-2xl shadow-diaz-green/5 flex flex-col md:flex-row overflow-hidden border border-gray-100">
            
            <div class="w-full md:w-1/2 bg-green-100 flex flex-col items-center justify-center p-8 md:p-16 text-center border-b md:border-b-0 md:border-r border-gray-100">
                <div class="mb-6 md:mb-12">
                    <div class="h-12 w-12 md:h-16 md:w-16 bg-white rounded-full mx-auto flex items-center justify-center shadow-lg mb-4">
                        <span class="text-diaz-green text-2xl md:text-3xl font-black">DC</span>
                    </div>
                    <h1 class="text-diaz-dark text-lg md:text-xl font-bold tracking-widest uppercase">Diaz College</h1>
                </div>

                <div class="w-full flex-grow flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-40 h-40 md:w-80 md:h-80 max-w-full">
                        <g class="illustration-main">
                            <path d="M75 60 H25 V15 H75 V60 Z" class="fill-white stroke-diaz-dark stroke-2" />
                            <path d="M30 20 H70 V55 H30 V20 Z" class="fill-green-100" />
                            <path d="M45 60 H55 L58 75 H42 L45 60 Z" class="fill-gray-100 stroke-gray-300 stroke-1" />
                            <path d="M40 75 H60 V80 H40 V75 Z" class="fill-gray-300" />
                            <circle cx="50" cy="40" r="8" class="fill-gray-100 stroke-gray-300 stroke-1" /> 
                            <path d="M50 48 H40 L35 70 H65 L60 48 H50 Z" class="fill-diaz-green" /> 
                            <path d="M42 55 H58 L62 70 H38 L42 55 Z" class="fill-gray-100/50" /> 
                        </g>
                        <circle cx="50" cy="50" r="48" class="fill-none stroke-diaz-green/10 stroke-1" />
                    </svg>
                </div>

                <p class="mt-8 md:mt-12 text-gray-500 text-xs italic opacity-60 hidden md:block">"Strive, Seek, Learn"</p>
            </div>

            <div class="w-full md:w-1/2 flex flex-col justify-center p-8 md:p-16 bg-white">
                <div class="max-w-md mx-auto w-full">
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight">Admin Portal</h2>
                    <p class="text-gray-500 mt-2 font-medium">Please enter your details to access the system.</p>

                    <form @submit.prevent="submit" class="mt-8 md:mt-10 space-y-6">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <input 
                                v-model="form.email" 
                                type="email" 
                                placeholder="Admin Username/Email"
                                class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-diaz-green/20 focus:border-diaz-green/50 outline-none text-gray-900 font-medium placeholder:text-gray-400 transition" />
                            <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                        </div>

                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <input 
                                v-model="form.password" 
                                type="password" 
                                placeholder="Admin Password"
                                class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-diaz-green/20 focus:border-diaz-green/50 outline-none text-gray-900 font-medium placeholder:text-gray-400 transition" />
                        </div>

                        <div class="text-right">
                            <Link href="/forgot-password" class="text-sm font-semibold text-diaz-green hover:text-diaz-dark transition">
                                Having trouble signing in?
                            </Link>
                        </div>

                        <button type="submit" :disabled="form.processing"
                            class="w-full bg-diaz-green hover:bg-diaz-dark text-white font-bold py-4 rounded-xl transition shadow-lg shadow-diaz-green/20 uppercase tracking-wider text-sm active:scale-95 disabled:opacity-50">
                            {{ form.processing ? 'Verifying...' : 'Sign In' }}
                        </button>
                    </form>
                    
                    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                        <Link href="/" class="text-sm text-gray-500 hover:text-diaz-green transition">
                            Back to Homepage
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>