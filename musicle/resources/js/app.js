import VueRouter from 'vue-router';
import store from "./store/index";
import Header from "./components/Header";
import Users from "./components/Users";
import Profile from "./components/Profile";
import Home from "./components/Home";
import Login from "./components/Login";
import Dashboard from "./components/Dashboard";
import NotFound from "./components/NotFound";
import Messages from "./components/Messages";

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
        /**
         * 未ログイン時のみ
         */
        // ログイン
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: { guestOnly: true }
        },
        /**
         * ログイン認証が必要なページ
         */
        // ホーム
        {
            path: '/home',
            name: 'home',
            component: Home,
            meta: { authOnly: true }
        },
        // ダイレクトメッセージ一覧
        {
            path: '/message',
            name: 'messages',
            component: Messages,
            meta: { authOnly: true }
        },
        // ダイレクトメッセージ
        {
            path: '/message/:room_no',
            name: 'message',
            component: Messages,
            meta: { authOnly: true }
        },
        /**
         * ログイン認証が不要なページ
         */
        // プロフィール
        {
            path: '/profile/:login_id',
            name: 'profile',
            component: Profile,
        },
        // ダッシュボード（開発用）
        {
            path: '/',
            name: 'dashboard',
            component: Dashboard
        },
        // ユーザー一覧（開発用）
        {
            path: '/userlist',
            name: 'userlist',
            component: Users,
        },
        /**
         * 404 not found
         */
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

Vue.component('header-component', Header);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// セッションストレージ情報を保持
if (sessionStorage.getItem('musicle')) {
    const strageData = JSON.parse(sessionStorage.getItem('musicle'));
    if (strageData.auth.is_login) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + strageData.auth.is_login;
    }
}

function is_login() {
    return store.getters['auth/is_login']
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

// 401でログインページにリダイレクト
axios.interceptors.response.use(function (response) {
    return response
}, function (error) {
    console.log(error.response.data)
    if (error.response.status === 401) {
        store.dispatch('auth/logout')
        router.push('/login')
    }
    return Promise.reject(error)
})

const app = new Vue({
    el: '#app',
    router,
    store
});
