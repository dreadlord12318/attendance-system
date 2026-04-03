<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
// Access the logged-in user's name
const user = computed(() => page.props.auth?.user);
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex font-sans">
        
        <aside class="w-64 bg-diaz-dark text-white hidden md:flex flex-col shadow-xl">
            <div class="p-6 border-b border-green-900 flex items-center gap-3">
                <div class="h-8 w-8 bg-white rounded flex items-center justify-center text-diaz-green font-bold">
                    DC
                </div>
                <span class="font-bold tracking-wider uppercase text-sm">Admin Panel</span>
            </div>

            <nav class="flex-grow p-4 space-y-2 mt-4">
                <Link href="/dashboard" 
                    class="flex items-center px-4 py-3 rounded-xl transition hover:bg-diaz-green"
                    :class="{ 'bg-diaz-green shadow-lg': $page.component === 'Dashboard' }">
                    <span class="text-sm font-medium">Students List</span>
                </Link>

                <Link href="/scanner" 
                    class="flex items-center px-4 py-3 rounded-xl transition hover:bg-diaz-green"
                    :class="{ 'bg-diaz-green shadow-lg': $page.component === 'Scanner' }">
                    <span class="text-sm font-medium">QR Scanner</span>
                </Link>
            </nav>

            <div class="p-4 border-t border-green-900">
                <Link href="/logout" method="post" as="button" 
                    class="w-full text-left px-4 py-3 text-red-400 text-sm font-bold hover:bg-red-500/10 rounded-xl transition">
                    Sign Out
                </Link>
            </div>
        </aside>

        <div class="flex-grow flex flex-col h-screen overflow-hidden">
            
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 shadow-sm">
                <div class="md:hidden flex items-center gap-2">
                     <span class="font-bold text-diaz-green">Diaz College</span>
                </div>
                
                <div class="hidden md:block">
                    <h2 class="text-gray-500 text-sm font-medium">Welcome back, <span class="text-gray-900 font-bold">{{ user?.name || 'Admin' }}</span></h2>
                </div>

                <div class="flex items-center gap-4">
                    <Link href="/logout" method="post" as="button" class="md:hidden text-red-500 font-bold text-sm">
                        Logout
                    </Link>
                    <div class="h-8 w-8 bg-diaz-green rounded-full flex items-center justify-center text-white text-xs font-bold">
                        {{ user?.name?.charAt(0) || 'A' }}
                    </div>
                </div>
            </header>

            <main class="flex-grow overflow-y-auto p-4 md:p-8">
                <div class="max-w-6xl mx-auto">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>