<script setup>
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import { useForm } from '@inertiajs/vue3';

// 1. ADD 'attendance_history' to your props here!
const props = defineProps({
    students: {
        type: Array,
        default: () => []
    },
    attendance_history: {
        type: Array,
        default: () => []
    }
});
const form = useForm({
    student_id: '',
    name: '',
    course: 'BSCS',
});

const submit = () => {
    form.post('/students', {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <DashboardLayout>
        <div class="max-w-6xl mx-auto py-8 px-4">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-diaz-green">Student Administration</h1>
                <p class="text-gray-500">Register students and manage attendance QR codes.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 sticky top-8">
                        <h2 class="text-lg font-bold mb-4 flex items-center text-gray-800">
                            <span class="bg-diaz-green w-2 h-6 rounded mr-2"></span>
                            Register Student
                        </h2>
                        
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Student ID Number</label>
                                <input v-model="form.student_id" type="text" placeholder="e.g., 2026-0001" 
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-900 focus:ring-2 focus:ring-diaz-green outline-none" />
                                <div v-if="form.errors.student_id" class="text-red-500 text-xs mt-1">{{ form.errors.student_id }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input v-model="form.name" type="text" placeholder="Juan Dela Cruz" 
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-900 focus:ring-2 focus:ring-diaz-green outline-none" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                                <select v-model="form.course" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-900 focus:ring-2 focus:ring-diaz-green outline-none">
                                    <option value="BSCS">BS Computer Science</option>
                                    <option value="BSBA">BS Business Administration</option>
                                    <option value="BSED">BS Education</option>
                                    <option value="ACT">ACT (Vocational)</option>
                                </select>
                            </div>

                            <button type="submit" :disabled="form.processing"
                                class="w-full bg-diaz-green hover:bg-diaz-dark text-white font-bold py-3 rounded-lg shadow-lg transition disabled:opacity-50">
                                {{ form.processing ? 'Saving...' : 'Generate Student QR' }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-8">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-bold text-gray-700 uppercase text-xs tracking-wider">Registered Students</h3>
                        </div>
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Student Info</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">QR Code</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="student in students" :key="student.id" class="hover:bg-green-50/30 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ student.name }}</div>
                                        <div class="text-sm text-gray-500 font-mono">{{ student.student_id }} | {{ student.course }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center">
                                            <img :src="student.qr_code" class="w-12 h-12 p-1 bg-white border rounded shadow-sm" />
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a :href="'/students/' + student.id + '/print'" target="_blank" class="text-diaz-green font-bold hover:underline">
                                            Print ID
                                        </a>
                                    </td>
                                </tr>
                                <tr v-if="students.length === 0">
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-400 italic">No students found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-bold text-diaz-green uppercase text-xs tracking-wider">Recent Attendance Logs</h3>
                        </div>
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Student Name</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-right">Time Scanned</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="record in attendance_history" :key="record.id" class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ record.student.name }}</div>
                                        <div class="text-xs text-gray-400 font-mono">{{ record.student.student_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-gray-600 font-mono text-sm">
                                        {{ new Date(record.created_at).toLocaleString() }}
                                    </td>
                                </tr>
                                <tr v-if="attendance_history.length === 0">
                                    <td colspan="2" class="px-6 py-12 text-center text-gray-400 italic">No attendance records yet.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </DashboardLayout>
</template>