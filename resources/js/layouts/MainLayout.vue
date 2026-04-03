<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex flex-col font-sans">
        <nav class="bg-diaz-green text-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-white rounded-full flex items-center justify-center text-diaz-green font-bold shadow-sm">
                            DC
                        </div>
                        <span class="text-xl font-bold tracking-tight uppercase">Diaz College</span>
                    </div>
                    
                    <div class="flex gap-6 items-center">
                        <Link href="/" class="text-sm font-medium hover:text-green-200">Home</Link>
                        <Link href="/login" class="bg-white text-diaz-green px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-gray-100 transition">
                            Log In
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-grow container mx-auto px-4 py-8">
            <slot />
        </main>

        <footer class="bg-diaz-dark text-white border-t border-green-900">
            <div class="max-w-7xl mx-auto py-8 px-4 text-center">
                <p class="font-bold">DIAZ COLLEGE</p>
                <p class="text-xs text-green-400 mt-1 italic leading-relaxed">"Strive, Seek, Learn"</p>
                <div class="mt-6 pt-6 border-t border-green-800/50 text-[10px] uppercase tracking-widest opacity-40">
                    &copy; {{ new Date().getFullYear() }} Attendance System
                </div>
            </div>
        </footer>
    </div>
</template>