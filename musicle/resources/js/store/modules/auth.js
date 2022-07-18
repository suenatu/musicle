const getters = {
    is_login: state => {
        return state.is_login;
    }
};

const state = {
    is_login: false,
};

const mutations = {
    login(state) {
        state.is_login = true;
    },
    logout(state) {
        state.is_login = false;
    }
};

const actions = {
    login(context) {
        context.commit('login');
    },
    logout(context) {
        context.commit('logout');
    }
};

export default {
    namespaced: true,
    getters,
    state,
    mutations,
    actions,
};