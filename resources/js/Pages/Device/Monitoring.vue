<script setup>
import { onMounted, ref } from "vue";
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { getLocationData } from "@/firebase/get";
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const serialNumber = ref(page.props.params.serialNumber);
const locationData = ref({});
const map = ref(null);
const marker = ref(null);

onMounted(() => {
    setTimeout(() => {
        initMap();
    }, 100);
    fetchData();
});

const fetchData = () => {
    if (!serialNumber.value) {
        console.error("❌ Serial number tidak ditemukan!");
        return;
    }

    getLocationData(serialNumber.value, (data) => {
        if (data) {
            console.log("✅ Data ditemukan untuk", serialNumber.value, data);
            locationData.value = data;
            updateMap();
        } else {
            console.error("❌ Data tidak ditemukan.");
        }
    });
};

const initMap = () => {
    map.value = L.map("map").setView([0, 0], 13);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "&copy; OpenStreetMap contributors",
    }).addTo(map.value);
};

const updateMap = () => {
    if (map.value && locationData.value?.Gps) {
        const lat = parseFloat(locationData.value.Gps.lat) || 0;
        const long = parseFloat(locationData.value.Gps.long) || 0;

        // Get location name
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${long}`)
            .then(response => response.json())
            .then(data => {
                locationData.value.locationName = data.display_name;
            })
            .catch(error => {
                console.error('Error fetching location name:', error);
                locationData.value.locationName = 'Location name not available';
            });

        map.value.setView([lat, long], 15);

        if (marker.value) {
            map.value.removeLayer(marker.value);
        }

        marker.value = L.marker([lat, long])
            .addTo(map.value)
            .bindPopup(
                `<b>Temperature:</b> ${
                    locationData.value.Sensors?.Temperature ? `${locationData.value.Sensors.Temperature}°C` : "N/A"
                }`
            )
            .openPopup();
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                Device Monitoring
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">
                            Device: {{ serialNumber }}
                        </h3>

                        <!-- Map container -->
                        <div id="map" style="height: 400px; width: 100%;" class="mb-4"></div>

                        <!-- Device Data -->
                        <div v-if="locationData.Sensors" class="mt-4">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded">
                                    <p class="font-medium text-gray-900 dark:text-white">Temperature</p>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        {{ locationData.Sensors.Temperature ? `${locationData.Sensors.Temperature}°C` : 'N/A' }}
                                    </p>
                                </div>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded">
                                    <p class="font-medium text-gray-900 dark:text-white">Battery Capacity</p>
                                    <p class="text-gray-700 dark:text-gray-300">{{ locationData.Sensors.BatteryCapacity || 'N/A' }}</p>
                                </div>
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded">
                                    <p class="font-medium text-gray-900 dark:text-white">Push Button</p>
                                    <p class="text-gray-700 dark:text-gray-300">{{ locationData.Sensors.PushButton || 'N/A' }}</p>
                                </div>
                                <div v-if="locationData.Gps" class="p-3 bg-gray-50 dark:bg-gray-700 rounded col-span-3">
                                    <p class="font-medium text-gray-900 dark:text-white">Location</p>
                                    <p class="text-gray-700 dark:text-gray-300">Latitude: {{ locationData.Gps.lat }}, Longitude: {{ locationData.Gps.long }}</p>
                                    <p v-if="locationData.locationName" class="text-gray-700 dark:text-gray-300 mt-1">{{ locationData.locationName }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.leaflet-container {
    z-index: 0;
    position: relative;
}

.leaflet-control-container {
    z-index: 0;
}

.leaflet-popup {
    z-index: 0;
}

.leaflet-control-zoom {
    z-index: 0 !important;
}

.leaflet-control-attribution {
    z-index: 0 !important;
}
</style>
