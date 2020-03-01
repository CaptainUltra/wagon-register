import Vue from "vue";
import VueRouter from "vue-router";
import ExampleComponent from "./components/ExampleComponent.vue";
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
import StationCreate from "./views/StationCreate.vue";
import StationShow from "./views/StationShow.vue";
import StationIndex from "./views/StationIndex.vue";
import StationEdit from "./views/StationEdit.vue";
import EventCreate from "./views/EventCreate.vue";
import EventShow from "./views/EventShow.vue";
import EventIndex from "./views/EventIndex.vue";
import EventEdit from "./views/EventEdit.vue";
import StatusCreate from "./views/StatusCreate.vue";
import StatusShow from "./views/StatusShow.vue";
import StatusIndex from "./views/StatusIndex.vue";
import StatusEdit from "./views/StatusEdit.vue";
import UserCreate from "./views/UserCreate.vue";
import UserShow from "./views/UserShow.vue";
import UserIndex from "./views/UserIndex.vue";
import RoleCreate from "./views/RoleCreate.vue";
import RoleShow from "./views/RoleShow.vue";
import RoleIndex from "./views/RoleIndex.vue";
import RoleEdit from "./views/RoleEdit.vue";

Vue.use(VueRouter);

function todayFilter(route) {
    const now = new Date();
    return {
        filter: "date",
        value: now.getDate + "." + now.getMonth + "." + now.getFullYear
    };
}

export default new VueRouter({
    routes: [
        { path: "/", component: ExampleComponent },
        { path: "/dashboard", redirect: "/" },
        { path: "/depots/create", component: DepotCreate },
        { path: "/depots", component: DepotIndex },
        { path: "/depots/:id", component: DepotShow },
        { path: "/depots/:id/edit", component: DepotEdit },
        { path: "/revisorypoints/create", component: RevisoryPointCreate },
        { path: "/revisorypoints", component: RevisoryPointIndex },
        { path: "/revisorypoints/:id", component: RevisoryPointShow },
        { path: "/revisorypoints/:id/edit", component: RevisoryPointEdit },
        { path: "/interiortypes/create", component: InteriorTypeCreate },
        { path: "/interiortypes", component: InteriorTypeIndex },
        { path: "/interiortypes/:id", component: InteriorTypeShow },
        { path: "/interiortypes/:id/edit", component: InteriorTypeEdit },
        { path: "/wagontypes/create", component: WagonTypeCreate },
        { path: "/wagontypes", component: WagonTypeIndex },
        { path: "/wagontypes/:id", component: WagonTypeShow },
        { path: "/wagontypes/:id/edit", component: WagonTypeEdit },
        { path: "/wagons/create", component: WagonCreate },
        { path: "/wagons", component: WagonIndex },
        { path: "/wagons/:id", component: WagonShow },
        { path: "/wagons/:id/edit", component: WagonEdit },
        { path: "/trains/create", component: TrainCreate },
        { path: "/trains", component: TrainIndex },
        { path: "/trains/:id", component: TrainShow },
        { path: "/trains/:id/edit", component: TrainEdit },
        { path: "/stations/create", component: StationCreate },
        { path: "/stations", component: StationIndex },
        { path: "/stations/:id", component: StationShow },
        { path: "/stations/:id/edit", component: StationEdit },
        {
            path: "/wagons/:id/events/create",
            component: EventCreate,
            props: route => ({ wagonId: route.params.id })
        },
        {
            path: "/wagons/:id/events",
            component: EventIndex,
            props: route => ({ filter: "wagon", value: route.params.id })
        },
        { path: "/events", component: EventIndex },
        { path: "/events/today", component: EventIndex, props: todayFilter },
        {
            path: "/user/:id/events",
            component: EventIndex,
            props: route => ({ filter: "user", value: route.params.id })
        },
        { path: "/events/:id", component: EventShow },
        { path: "/events/:id/edit", component: EventEdit },
        { path: "/statuses/create", component: StatusCreate },
        { path: "/statuses", component: StatusIndex },
        { path: "/statuses/:id", component: StatusShow },
        { path: "/statuses/:id/edit", component: StatusEdit },
        { path: "/users/create", component: UserCreate },
        { path: "/users", component: UserIndex },
        { path: "/users/:id", component: UserShow },
        { path: "/roles/create", component: RoleCreate },
        { path: "/roles", component: RoleIndex },
        { path: "/roles/:id", component: RoleShow },
        { path: "/roles/:id/edit", component: RoleEdit },
    ],
    mode: "history"
});
