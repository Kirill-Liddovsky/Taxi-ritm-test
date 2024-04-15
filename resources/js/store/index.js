import Vuex from 'vuex';
import auth from './modules/auth';
import createPersistedState from 'vuex-persistedstate'

export default new Vuex.Store({
    plugins:[
        createPersistedState()
    ],
    modules: {
        auth
    }
})

