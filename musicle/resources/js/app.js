import VueRouter from 'vue-router';
import HeaderComponent from "./components/HeaderComponent";
import UserListComponent from "./components/UserListComponent";
import ProfileComponent from "./components/ProfileComponent";
import HomeComponent from "./components/HomeComponent";
import LoginComponent from "./components/LoginComponent";
import DashboardComponent from "./components/DashboardComponent";
import NotFound from "./components/NotFound";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        // 未ログイン時のみ
        {
            path: '/login',
            name: 'login',
            component: LoginComponent,
            meta: { guestOnly: true }
        },
        // ログイン認証が不要なページ
        {
            path: '/profile/:id',
            name: 'profile',
            component: ProfileComponent,
        },
        // ログイン認証が必要なページ
        {
            path: '/home',
            name: 'home',
            component: HomeComponent,
            meta: { authOnly: true }
        },
        {
            path: '/userlist',
            name: 'userlist',
            component: UserListComponent,
            meta: { authOnly: true }
        },
        // dashboard
        {
            path: '/',
            name: 'dashboard',
            component: DashboardComponent
        },
        // 404 not found
        {
            path: '*',
            name: 'NotFound',
            component: NotFound
        },
    ]
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('header-component', HeaderComponent);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

function is_login() {
    return localStorage.getItem("auth");
}

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.authOnly)) {
        if (!is_login()) {
            next("/login");
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.guestOnly)) {
        if (is_login()) {
            next("/home");
        } else {
            next();
        }
    } else {
        next();
    }
});

const app = new Vue({
    el: '#app',
    router
});
