export default {
    state: {
        questionErrors: null
    },
    mutations: {
        setQuestionErrors(state, payload) {
            state.questionErrors = payload;
        },
        clearQuestionErrors(state) {
            state.questionErrors = null;
        }
    },
    getters: {
        getQuestionErrors(state) {
            return state.questionErrors;
        }
    },
    actions: {
        async storeQuestion({commit, dispatch}, payload) {
            try {
                let question = await axios.post(`${process.env.MIX_APP_URL}/api/v1/groups/${payload.slug}/questions`, payload.data);
                commit('clearQuestionErrors');

                return question.data;
            } catch (error) {
                if (error.response.status == 422) {
                    commit('setQuestionErrors', error.response.data.errors);
                }
            }
        },
        async getQuestions({commit, dispatch}, payload) {
            try {
                let questions = await axios.get(`${process.env.MIX_APP_URL}/api/v1/groups/${payload}/questions`);

                return questions.data;
            } catch (error) {
                commit('setError', error);
            }
        },
        async getQuestion({commit, dispatch}, payload) {
            try {
                let question = await axios.get(`${process.env.MIX_APP_URL}/api/v1/questions/${payload}`);

                return question.data.data;
            } catch (error) {
                commit('setError', error);
            }
        },
        async getAnswers({commit, dispatch}, payload) {
            try {
                let questions = await axios.get(`${process.env.MIX_APP_URL}/api/v1/questions/${payload}/answers`);

                return questions.data;
            } catch (error) {
                commit('setError', error);
            }
        },
        async sendAnswers({commit, dispatch}, payload) {
            try {
                let message = await axios.post(`${process.env.MIX_APP_URL}/api/v1/questions/${payload.id}/answers/`, payload.data);

                return message.data.data;
            } catch (error) {
                commit('setError', error);
            }
        }
    }
}
