<script setup>
import { onMounted, ref, onUnmounted } from 'vue';
import axios from 'axios';
import MainLayout from '@/layouts/MainLayout.vue';
import { Html5QrcodeScanner } from "html5-qrcode";

const scanResult = ref(null);
const statusMessage = ref('Ready to scan...');
let html5QrcodeScanner = null;

const onScanSuccess = (decodedText) => {
    // 1. Prevent spamming the same scan
    if (statusMessage.value.includes(decodedText) && scanResult.value) return;

    statusMessage.value = "Scanning: " + decodedText;
    
    axios.post('/attendance/scan', { student_id: decodedText })
        .then(res => {
            scanResult.value = res.data.student;
            statusMessage.value = "Success: " + res.data.message;
            // Clear result card after 5 seconds
            setTimeout(() => { scanResult.value = null; }, 5000);
        })
        .catch(err => {
            statusMessage.value = "Error: " + (err.response?.data?.message || "Invalid ID");
        });
};

onMounted(() => {
    // 2. config to disable "Upload Image" (Type 0 = Camera only)
    const config = { 
        fps: 10, 
        qrbox: { width: 250, height: 250 },
        supportedScanTypes: [0] 
    };

    html5QrcodeScanner = new Html5QrcodeScanner("reader", config, false);
    html5QrcodeScanner.render(onScanSuccess);
});

onUnmounted(() => {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear().catch(err => console.error(err));
    }
});
</script>

<template>
    <MainLayout>
        <div class="max-w-md mx-auto py-10 px-4 text-center">
            <h1 class="text-2xl font-bold text-diaz-green mb-6">Attendance Scanner</h1>
            
            <div id="reader" class="rounded-xl overflow-hidden border-2 border-diaz-green shadow-lg bg-black"></div>

            <div v-if="scanResult" class="mt-8 p-6 bg-white rounded-xl shadow-md border-t-4 border-diaz-green">
                <p class="text-gray-500 text-sm italic">{{ statusMessage }}</p>
                <h2 class="text-xl font-black mt-2 text-gray-900">{{ scanResult.name }}</h2>
                <p class="text-diaz-green font-bold">{{ scanResult.course }}</p>
                <p class="text-xs text-gray-400 mt-1">Time: {{ scanResult.time }}</p>
            </div>
            
            <div v-else class="mt-8 p-4 bg-gray-100 rounded-lg text-gray-500 font-medium border border-gray-200">
                {{ statusMessage }}
            </div>
        </div>
    </MainLayout>
</template>