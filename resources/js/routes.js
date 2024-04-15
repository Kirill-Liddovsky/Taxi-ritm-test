import { createWebHistory, createRouter } from "vue-router";

import Login from "./pages/Login.vue";
import Dashboard from "./pages/Dashboard.vue";
import store from "./store";

const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
        meta: {
            middleware: 'guest'
        }

    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard,
        meta: {
            middleware: 'auth'
        }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if(to.meta.middleware=="guest"){
        if(store.state.auth.loggedIn){
            next({name:"dashboard"})
        }
        next()
    }else{
        if(store.state.auth.loggedIn){
            next()
        }else{
            next({name:"login"})
        }
    }
})

export default router;
