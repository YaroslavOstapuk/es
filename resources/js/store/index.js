import AppInterface from "./interface";
import auth from "./auth";
import group from "./group";
import event from "./event";
import question from "./question";

export default {
    state: {
        error: null
    },
    mutations: {
        setError(state, payload) {
            state.error = payload;
        }
    },
    actions: {
    },
    getters: {
    },
    modules: {
        AppInterface,
        auth,
        group,
        event,
        question,
    }
}
