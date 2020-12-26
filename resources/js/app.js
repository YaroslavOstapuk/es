require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import {routes} from "./routes";
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import Vuex from 'vuex';
import StoreDate from "./store";
import App from  './modules/App';
import DatetimePicker from './components/DatetimePicker';
import {setCommonHeaders} from './store/axiosConfig';

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(Vuetify);

Vue.component('v-datetime-picker', DatetimePicker);

const store = new Vuex.Store(StoreDate);

setCommonHeaders();

const router = new VueRouter({
    routes,
    mode: 'history'
});

const opts = {};

const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify(opts),
    store,
    render: h => h(App)
});

