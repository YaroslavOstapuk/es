export default {
    state: {
        userErrors: null,
    },
    mutations: {
        setUserErrors(state, payload) {
            state.userErrors = payload;
        }
    },
    getters: {
        userErrors(state) {
            return state.userErrors;
        }
    },
    actions: {
        async getUser() {
            try {
                let user = await axios.get(`${process.env.MIX_APP_URL}/api/v1/me`);

                return user.data.data;
            } catch (error) {
                commit('setError', error);
            }
        },
        async updateUser({commit, dispatch}, payload) {
            try {
                let user = await axios.post(`${process.env.MIX_APP_URL}/api/v1/me`, payload);

                return user.data.data;
            } catch (error) {
                if (error.response.status == 422) {
                    commit('setUserErrors', error.response.data.errors);
                } else {
                    commit('setError', error);
                }
            }
        },
        async getUsers({commit, dispatch}, payload) {
            try {
                let users = await axios.get(`${process.env.MIX_APP_URL}/api/v1/groups/${payload}/users`);

                return users.data.data;
            } catch (error) {
                commit('setError', error);
            }
        }
    }
}
