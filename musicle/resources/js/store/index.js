import Vue from "vue";
import Vuex from "vuex";
import util from "./modules/util";
import auth from "./modules/auth";
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        util,
        auth,
    },
    strict: true,
    plugins: [createPersistedState({
        key: 'musicle',
        paths: ['auth.is_login'],
        storage: window.sessionStorage
    })]
});