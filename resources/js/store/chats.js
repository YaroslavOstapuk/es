export default {
    state: {
        primaryChat: null,
        otherChatErrors: null,
        inviteErrors: null,
    },
    mutations: {
        setPrimaryChat(state, payload) {
            state.primaryChat = payload;
        },
        setOtherChatError(state, payload) {
            state.otherChatErrors = payload;
        },
        setInviteErrors(state, payload) {
            state.inviteErrors = payload;
        }
    },
    getters: {
        getPrimaryChat(state) {
            return state.primaryChat;
        },
        getOtherChatError(state) {
            return state.otherChatErrors;
        },
        getInviteErrors(state) {
            return state.inviteErrors;
        }
},
    actions: {
        async primaryChat({commit, dispatch}, payload) {
            try {
                let chat = await axios.get(`${process.env.MIX_APP_URL}/api/v1/groups/${payload}/primary-chat`);
                commit('setPrimaryChat', chat.data.data);

                return chat.data.data;
            } catch (error) {
                commit('setError', error);
            }
        },
        async getOtherChat({commit, dispatch}, payload) {
            try {
                let chats = await axios.get(`${process.env.MIX_APP_URL}/api/v1/groups/${payload}/chats`);

                return chats.data.data;
            } catch (error) {
                commit('setError', error);
            }
        },
        async getMessages({commit, dispatch}, payload) {
            try {
                let messages = await axios.get(`${process.env.MIX_APP_URL}/api/v1/chats/${payload}/messages`);

                return messages.data.data;
            } catch (error) {
                commit('setError', error);
            }
        },
        async getChat({commit, dispatch}, payload) {
            try {
                let chat = await axios.get(`${process.env.MIX_APP_URL}/api/v1/chats/${payload}`);

                return chat.data.data;
            } catch (error) {
                commit('setError', error);
            }
        },
        async sendMessageToChat({commit, dispatch}, payload) {
            try {
                let message = await axios.post(`${process.env.MIX_APP_URL}/api/v1/chats/${payload.id}/messages`, payload.data);

                return message.data.data;
            } catch (error) {
                commit('setError', error);
            }
        },
        async deleteChat({commit, dispatch}, payload) {
            try {
                let status = await axios.delete(`${process.env.MIX_APP_URL}/api/v1/chats/${payload}`);

                return status.data.data;
            } catch (error) {
                commit('setError', error);
            }
        },
        async storeOtherChat({commit, dispatch}, payload) {
            try {
                let otherChat = await axios.post(`${process.env.MIX_APP_URL}/api/v1/groups/${payload.slug}/chats`, payload.data);

                return otherChat.data.data;
            } catch (error) {
                if (error.response.status == 422) {
                    commit('setOtherChatError', error.response.data.errors);
                }
            }
        },
        async invite({commit, dispatch}, payload) {
            try {
                let invite = await axios.post(`${process.env.MIX_APP_URL}/api/v1/invitation`, payload);

                return invite.data;
            } catch (error) {
                if (error.response.status == 422) {
                    commit('setInviteErrors', error.response.data.errors);
                }
            }
        }
    }
}
