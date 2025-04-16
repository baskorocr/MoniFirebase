import { createRouter, createWebHistory } from "vue-router";
import ListDevices from "@/Pages/Device/List.vue";
import MonitoringDevice from "@/Pages/Device/Monitoring.vue";

const routes = [
    { path: "/devices", component: ListDevices },
    {
        path: "/devices/monitoring/:id",
        name: "monitoring",
        component: MonitoringDevice,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
