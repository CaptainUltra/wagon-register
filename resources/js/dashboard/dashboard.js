import Vue from 'vue';
import router from './router';
import Dashboard from './components/Dashboard.vue';

require('../bootstrap');

const app = new Vue({
    el: '#app',
    components: {
        Dashboard
    },
    router
});
