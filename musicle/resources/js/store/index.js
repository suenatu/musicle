import Vue from "vue";
import Vuex from "vuex";
import util from "./modules/util";
import auth from "./modules/auth";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    util,
    auth,
  },
});