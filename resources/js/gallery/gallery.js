import Vue from 'vue';
import router from './router';
import Gallery from './components/Gallery.vue';

require('../bootstrap');

const app = new Vue({
    el: '#app',
    components: {
        Gallery
    },
    router
});
