import { createRouter, createWebHistory } from "vue-router";
import ListDevices from "../Pages/Device/List.vue";
import MonitoringDevice from "../Pages/Device/Monitoring.vue";

const routes = [
    { 
        path: "/devices", 
        component: ListDevices,
        name: "devices.list"
    },
    {
        path: "/devices/monitoring/:id",
        name: "devices.monitoring",
        component: MonitoringDevice
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
