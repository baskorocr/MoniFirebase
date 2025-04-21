<script setup>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();
const nameDevice = ref("");
const serialNumber = ref("");
const isSubmitting = ref(false);

const addDevice = async () => {
    isSubmitting.value = true;

    try {
        await axios.post("/devices", {
            nameDevice: nameDevice.value,
            serialNumber: serialNumber.value,
        });

        alert("Device added successfully!");
        window.location.href = "/devices";
    } catch (error) {
        console.error("Error adding device:", error);
        alert("Failed to add device.");
    } finally {
        isSubmitting.value = false;
    }
};
</script>

<template>
    <AuthenticatedLayout title="Add New Device">
        <div class="p-6 bg-white rounded-md shadow-md">
            <h3 class="text-lg font-semibold mb-4 text-gray-900">Add New Device</h3>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-900">Device Name</label>
                <input
                    v-model="nameDevice"
                    type="text"
                    class="w-full border rounded-md p-2 text-gray-900"
                    required
                />
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-900">Serial Number</label>
                <input
                    v-model="serialNumber"
                    type="text"
                    class="w-full border rounded-md p-2 text-gray-900"
                    required
                />
            </div>

            <button
                @click="addDevice"
                :disabled="isSubmitting"
                class="py-2 px-4 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition-all"
            >
                {{ isSubmitting ? "Adding..." : "Add Device" }}
            </button>
        </div>
    </AuthenticatedLayout>
</template>
