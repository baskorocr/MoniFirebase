import { createRouter, createWebHistory } from "vue-router";
import { resolvePageComponent } from '@inertiajs/vue3';

const routes = [
    { 
        path: "/devices", 
        component: () => resolvePageComponent('./Pages/Device/List.vue', import.meta.glob('./Pages/Device/List.vue'))
    },
    {
        path: "/devices/monitoring/:id",
        name: "monitoring",
        component: () => resolvePageComponent('./Pages/Device/Monitoring.vue', import.meta.glob('./Pages/Device/Monitoring.vue'))
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
