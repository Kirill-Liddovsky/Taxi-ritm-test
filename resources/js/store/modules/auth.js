import router from "../../routes";
export default {
    namespaced: true,
    state() {
        return {
            loggedIn: false,
            token: null
        }
    },
    mutations: {
        loggedIn(state, token) {
            state.loggedIn = true
            state.token = token
        },
        logout(state) {
            state.loggedIn = false
            state.token = null
        },
    },
    actions: {
        login({commit}, token) {
            commit('loggedIn',token)
            router.push({name:'dashboard'})
        },
        logout({commit}) {
            commit('logout')
            router.push({name:'login'})
        },
    }
}


