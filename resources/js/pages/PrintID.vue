<script setup>
import { onMounted } from 'vue';

const props = defineProps({ student: Object });

const handlePrint = () => {
    window.print();
};
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center p-6 print:bg-white print:p-0">
        
        <div class="w-[350px] h-[500px] bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-200 flex flex-col print:shadow-none print:border print:m-0">
            
            <div class="bg-diaz-green p-6 text-center text-white">
                <h1 class="text-xl font-bold uppercase tracking-wider">Diaz College</h1>
                <p class="text-[10px] uppercase opacity-80">Student Identification</p>
            </div>

            <div class="flex-grow flex flex-col items-center p-8 text-center">
                <div class="w-24 h-24 bg-gray-200 rounded-full mb-4 border-4 border-white shadow-sm flex items-center justify-center text-gray-400 text-[10px]">
                    PHOTO
                </div>

                <h2 class="text-2xl font-black text-gray-900 leading-tight uppercase">{{ student.name }}</h2>
                <p class="text-diaz-green font-bold text-sm mb-6">{{ student.course }}</p>

                <div class="p-2 border-2 border-diaz-green rounded-xl bg-white shadow-inner">
                    <img :src="student.qr_code" class="w-40 h-40" alt="QR Code" />
                </div>

                <div class="mt-6">
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest">Student ID</p>
                    <p class="font-mono text-xl font-bold text-gray-800">{{ student.student_id }}</p>
                </div>
            </div>

            <div class="h-3 bg-diaz-dark w-full"></div>
        </div>

        <div class="mt-8 flex gap-4 print:hidden">
            <button @click="handlePrint" class="bg-diaz-green text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-diaz-dark transition">
                Print ID Now
            </button>
            <a href="/dashboard" class="px-8 py-3 text-gray-500 hover:text-gray-800 underline">
                Return to Dashboard
            </a>
        </div>
    </div>
</template>

<style>
@media print {
    /* Hides everything except the ID card container during printing */
    .print\:hidden { display: none !important; }
}
</style>