import { getLocalUser } from '../helpers/auth'

const user = getLocalUser();

export default {
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loginError: null,
        registerError: null,
        nonExistentUser: false,
    },
    mutations: {
        setLoginError(state, payload) {
            state.loginError = payload;
        },
        setRegisterError(state, payload) {
            state.registerError = payload;
        },
        loginSuccess(state, payload) {
            state.isLoggedIn = true
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token})

            localStorage.setItem("user", JSON.stringify(state.currentUser))
        },
        logout(state) {
            localStorage.removeItem("user");
            state.isLoggedIn = false
            state.currentUser = null
        },
        setExistentUser(state, payload) {
            state.nonExistentUser = true;
        },
        clearLoginErrors(state) {
            state.loginError = null;
            state.nonExistentUser = false;
        },
        clearRegisterErrors(state) {
            state.registerError = null;
        }
    },
    getters: {
        isLoggedIn(state) {
            return state.isLoggedIn
        },
        currentUser(state) {
            return state.currentUser
        },
        getLoginError(state) {
            return state.loginError;
        },
        getRegisterError(state) {
            return state.registerError;
        },
        getNonExistentUser(state) {
            return state.nonExistentUser;
        },
    },
    actions: {
        async login({commit, dispatch}, payload) {
            try {
                let user = await axios.post(`${process.env.MIX_APP_URL}/api/v1/auth/login`, payload);
                commit('clearLoginErrors');
                commit('loginSuccess', user.data);

                return true;
            } catch (error) {
                if (error.response.status == 422) {
                    commit('setLoginError', error.response.data.errors);
                }
                if (error.response.status == 401) {
                    commit('setExistentUser');
                }
            }
        },
        async register({commit, dispatch}, payload) {
            try {
                let user = await axios.post(`${process.env.MIX_APP_URL}/api/v1/auth/register`, payload);
                commit('clearRegisterErrors');
                commit('loginSuccess', user.data);

                return true;
            }catch (error) {
                if (error.response.status == 422) {
                    commit('setRegisterError', error.response.data.errors);
                }
            }
        }
    }
}
