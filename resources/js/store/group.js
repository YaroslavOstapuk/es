export default {
    state: {
        createGroupErrors: null
    },
    mutations: {
        setCreateGroupErrors(state, payload) {
            state.createGroupErrors = payload;
        },
        clearCreateGroupErrors(state) {
            state.createGroupErrors = null;
        }
    },
    getters: {
        getCreateGroupErrors(state) {
            return state.createGroupErrors;
        }
    },
    actions: {
        async storeGroup({commit, dispatch}, payload) {
            try {
                let group = await axios.post(`${process.env.MIX_APP_URL}/api/v1/groups`, payload);
                commit('clearCreateGroupErrors');

                return group.data;

            } catch (error) {
                if (error.response.status == 422) {
                    commit('setCreateGroupErrors', error.response.data.errors)
                }
            }
        },
        async updateGroup({commit, dispatch}, payload) {
            try {
                let group = await axios.post(`${process.env.MIX_APP_URL}/api/v1/groups/${payload.slug}`, payload.data);
                commit('clearCreateGroupErrors');

                return group.data;
            } catch (error) {
                if (error.response.status == 422) {
                    commit('setCreateGroupErrors', error.response.data.errors)
                }
            }
        },
        async getGroup({commit, dispatch}, payload) {
            try {
                let group = await axios.get(`${process.env.MIX_APP_URL}/api/v1/groups/${payload}`);

                return group.data;
            } catch (error) {
                commit('error', error);
            }
        },
        async searchGroup({commit, dispatch}, payload) {
            try {
                let groups = await axios.get(`${process.env.MIX_APP_URL}/api/v1/groups/search?q=${payload}`);

                return groups.data;
            }catch (error) {
                commit('error', error);
            }
        },
        async subscribeToGroup({commit, dispatch}, payload) {
            try {
                let subscribe = await axios.post(`${process.env.MIX_APP_URL}/api/v1/groups/subscribe`, payload);

                return subscribe.data;
            }catch (error) {
                commit('error', error);
            }
        },
        async unsubscribeFromGroup({commit, dispatch}, payload) {
            try {
                let unsubscribe = await axios.post(`${process.env.MIX_APP_URL}/api/v1/groups/unsubscribe`, payload);

                return unsubscribe.data;
            }catch (error) {
                commit('error', error);
            }
        }
    },
}
