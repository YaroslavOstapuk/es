export default {
    state: {
        eventErrors: null
    },
    mutations: {
        setEventError(state, payload) {
            state.eventErrors = payload;
        },
        clearEventError(state) {
            state.eventErrors = null
        }
    },
    getters: {
        getEventErrors(state) {
            return state.eventErrors
        }
    },
    actions: {
        async storeEvent({commit, dispatch}, payload) {
            try {
                let event = await axios.post(`${process.env.MIX_APP_URL}/api/v1/groups/${payload.slug}/events`, payload.data);
                commit('clearEventError');

                return event.data;
            } catch (error) {
                if (error.response.status == 422) {
                    commit('setEventError', error.response.data.errors);
                }
            }
        },
        async getEvent({commit, dispatch}, payload) {
            try {
                let event = await axios.get(`${process.env.MIX_APP_URL}/api/v1/events/${payload}`);

                return event.data;
            } catch (error) {
                commit('setError', error);
            }
        },
        async updateEvent({commit, dispatch}, payload) {
            try {
                let event = await axios.post(`${process.env.MIX_APP_URL}/api/v1/events/${payload.id}`, payload.data);

                return event.data;
            } catch (error) {
                if (error.response.status == 422) {
                    commit('setEventError', error.response.data.errors);
                }
            }
        },
        async getEvents({commit, dispatch}, payload) {
            try {
                let events = await axios.get(`${process.env.MIX_APP_URL}/api/v1/groups/${payload}/events`);

                return events.data;
            } catch (error) {
                commit('setError', error);
            }
        },
        async deleteEvent({commit, dispatch}, payload) {
            try {
                await axios.delete(`${process.env.MIX_APP_URL}/api/v1/events/${payload}`);

                return true;
            } catch (error) {
                commit('setError', error);
            }
        }
    }
}
