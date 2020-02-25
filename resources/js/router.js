import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from './components/ExampleComponent.vue';
import DepotCreate from "./views/DepotCreate.vue";
import DepotShow from "./views/DepotShow.vue";
import DepotIndex from "./views/DepotIndex.vue";
import DepotEdit from "./views/DepotEdit.vue";
import RevisoryPointCreate from "./views/RevisoryPointCreate.vue";
import RevisoryPointShow from "./views/RevisoryPointShow.vue";
import RevisoryPointIndex from "./views/RevisoryPointIndex.vue";
import RevisoryPointEdit from "./views/RevisoryPointEdit.vue";
import InteriorTypeCreate from "./views/InteriorTypeCreate.vue";
import InteriorTypeShow from "./views/InteriorTypeShow.vue";
import InteriorTypeIndex from "./views/InteriorTypeIndex.vue";
import InteriorTypeEdit from "./views/InteriorTypeEdit.vue";
import WagonTypeCreate from "./views/WagonTypeCreate.vue";
import WagonTypeShow from "./views/WagonTypeShow.vue";
import WagonTypeIndex from "./views/WagonTypeIndex.vue";
import WagonTypeEdit from "./views/WagonTypeEdit.vue";
import WagonCreate from "./views/WagonCreate.vue";
import WagonShow from "./views/WagonShow.vue";
import WagonIndex from "./views/WagonIndex.vue";
import WagonEdit from "./views/WagonEdit.vue";
import TrainCreate from "./views/TrainCreate.vue";
import TrainIndex from "./views/TrainIndex.vue";
import TrainShow from "./views/TrainShow.vue";
import TrainEdit from "./views/TrainEdit.vue";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {path: '/', component: ExampleComponent},
        {path: '/dashboard', redirect: '/'},
        {path: '/depots/create', component: DepotCreate},
        {path: '/depots', component: DepotIndex},
        {path: '/depots/:id', component: DepotShow},
        {path: '/depots/:id/edit', component: DepotEdit},
        {path: '/revisorypoints/create', component: RevisoryPointCreate},
        {path: '/revisorypoints', component: RevisoryPointIndex},
        {path: '/revisorypoints/:id', component: RevisoryPointShow},
        {path: '/revisorypoints/:id/edit', component: RevisoryPointEdit},
        {path: '/interiortypes/create', component: InteriorTypeCreate},
        {path: '/interiortypes', component: InteriorTypeIndex},
        {path: '/interiortypes/:id', component: InteriorTypeShow},
        {path: '/interiortypes/:id/edit', component: InteriorTypeEdit},
        {path: '/wagontypes/create', component: WagonTypeCreate},
        {path: '/wagontypes', component: WagonTypeIndex},
        {path: '/wagontypes/:id', component: WagonTypeShow},
        {path: '/wagontypes/:id/edit', component: WagonTypeEdit},
        {path: '/wagons/create', component: WagonCreate},
        {path: '/wagons', component: WagonIndex},
        {path: '/wagons/:id', component: WagonShow},
        {path: '/wagons/:id/edit', component: WagonEdit},
        {path: '/trains/create', component: TrainCreate},
        {path: '/trains', component: TrainIndex},
        {path: '/trains/:id', component: TrainShow},
        {path: '/trains/:id/edit', component: TrainEdit},
      ],
      mode: 'history'
})