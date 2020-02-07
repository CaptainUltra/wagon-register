import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from './components/ExampleComponent.vue';
import DepotCreate from "./views/DepotCreate.vue";
import DepotShow from "./views/DepotShow.vue";
import DepotIndex from "./views/DepotIndex.vue";
import DepotEdit from "./views/DepotEdit.vue";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {path: '/', component: ExampleComponent},
        {path: '/dashboard', redirect: '/'},
        {path: '/depots/create', component: DepotCreate},
        {path: '/depots', component: DepotIndex},
        {path: '/depots/:id', component: DepotShow},
        {path: '/depots/:id/edit', component: DepotEdit},
      ],
      mode: 'history'
})