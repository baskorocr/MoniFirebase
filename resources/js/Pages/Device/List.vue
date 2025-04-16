<template>
    <AuthenticatedLayout title="List Devices">
        <template #header>
            <h2 class="text-xl font-semibold">List Devices</h2>
        </template>

        <div class="p-6 bg-white rounded-md shadow-md">
            <Link
                href="/devices/create"
                class="mb-4 px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-all"
            >
                + Add New Device
            </Link>

            <div
                v-for="device in devices"
                :key="device.id"
                class="flex items-center gap-2 mt-5 bg-gray-100 p-3 rounded-lg shadow"
            >
                <button
                    class="flex-1 text-left py-3 px-6 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-all"
                    @click="goToMonitoring(device.serialNumber)"
                >
                    {{ device.nameDevice }} - {{ device.serialNumber }}
                </button>
                <button
                    class="px-3 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition-all"
                    @click="deleteDevice(device.id)"
                >
                    ❌
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3"; // Tambahkan Link dari Inertia
import axios from "axios";

const props = defineProps({
    devices: Array,
});

const goToMonitoring = (deviceId) => {
    window.location.href = `/devices/monitoring/${deviceId}`;
};

const deleteDevice = async (deviceId) => {
    if (!confirm("Are you sure you want to delete this device?")) return;

    try {
        await axios.delete(`/devices/${deviceId}`);
        alert("Device deleted successfully.");
        window.location.reload();
    } catch (error) {
        console.error("Error deleting device:", error);
        alert("Failed to delete device.");
    }
};
</script>
