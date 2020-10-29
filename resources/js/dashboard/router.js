import Vue from "vue";
import VueRouter from "vue-router";
import Welcome from "./components/Welcome.vue";
import DepotCreate from "./views/Depot/DepotCreate.vue";
import DepotShow from "./views/Depot/DepotShow.vue";
import DepotIndex from "./views/Depot/DepotIndex.vue";
import DepotEdit from "./views/Depot/DepotEdit.vue";
import RevisoryPointCreate from "./views/RevisoryPoint/RevisoryPointCreate.vue";
import RevisoryPointShow from "./views/RevisoryPoint/RevisoryPointShow.vue";
import RevisoryPointIndex from "./views/RevisoryPoint/RevisoryPointIndex.vue";
import RevisoryPointEdit from "./views/RevisoryPoint/RevisoryPointEdit.vue";
import InteriorTypeCreate from "./views/InteriorType/InteriorTypeCreate.vue";
import InteriorTypeShow from "./views/InteriorType/InteriorTypeShow.vue";
import InteriorTypeIndex from "./views/InteriorType/InteriorTypeIndex.vue";
import InteriorTypeEdit from "./views/InteriorType/InteriorTypeEdit.vue";
import WagonTypeCreate from "./views/WagonType/WagonTypeCreate.vue";
import WagonTypeShow from "./views/WagonType/WagonTypeShow.vue";
import WagonTypeIndex from "./views/WagonType/WagonTypeIndex.vue";
import WagonTypeEdit from "./views/WagonType/WagonTypeEdit.vue";
import WagonCreate from "./views/Wagon/WagonCreate.vue";
import WagonShow from "./views/Wagon/WagonShow.vue";
import WagonIndex from "./views/Wagon/WagonIndex.vue";
import WagonEdit from "./views/Wagon/WagonEdit.vue";
import TrainCreate from "./views/Train/TrainCreate.vue";
import TrainIndex from "./views/Train/TrainIndex.vue";
import TrainShow from "./views/Train/TrainShow.vue";
import TrainEdit from "./views/Train/TrainEdit.vue";
import StationCreate from "./views/Station/StationCreate.vue";
import StationShow from "./views/Station/StationShow.vue";
import StationIndex from "./views/Station/StationIndex.vue";
import StationEdit from "./views/Station/StationEdit.vue";
import EventCreate from "./views/Event/EventCreate.vue";
import EventShow from "./views/Event/EventShow.vue";
import EventIndex from "./views/Event/EventIndex.vue";
import EventEdit from "./views/Event/EventEdit.vue";
import StatusCreate from "./views/Status/StatusCreate.vue";
import StatusShow from "./views/Status/StatusShow.vue";
import StatusIndex from "./views/Status/StatusIndex.vue";
import StatusEdit from "./views/Status/StatusEdit.vue";
import UserCreate from "./views/User/UserCreate.vue";
import UserShow from "./views/User/UserShow.vue";
import UserIndex from "./views/User/UserIndex.vue";
import RoleCreate from "./views/Role/RoleCreate.vue";
import RoleShow from "./views/Role/RoleShow.vue";
import RoleIndex from "./views/Role/RoleIndex.vue";
import RoleEdit from "./views/Role/RoleEdit.vue";
import MarkWagonsAsSeen from "./views/Wagon/MarkWagonsAsSeen.vue";

Vue.use(VueRouter);

function todayFilter(route) {
    const now = new Date();
    return {
        pageFilter: "date=" + now.getDate() + "." + (now.getMonth() + 1) + "." + now.getFullYear()
    };
}

export default new VueRouter({
    routes: [
        { path: "/", component: Welcome },
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
        {
            path: "/wagons/expiring-revision",
            component: WagonIndex,
            props: {pageFilter: "revision_expiration_this_month=1"}
        },
        { path: "/wagons/:id", component: WagonShow },
        { path: "/wagons/:id/edit", component: WagonEdit },
        { path: "/trains/create", component: TrainCreate },
        { path: "/trains", component: TrainIndex },
        { path: "/trains/:id", component: TrainShow },
        { path: "/trains/:id/edit", component: TrainEdit },
        {
            path: "/trains/:id/events",
            component: EventIndex,
            props: route => ({ pageFilter: "train_id=" + route.params.id})
        },
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
            props: route => ({ pageFilter: "wagon_id=" + route.params.id})
        },
        { path: "/events", component: EventIndex },
        { path: "/events/today", component: EventIndex, props: todayFilter },
        {
            path: "/user/:id/events",
            component: EventIndex,
            props: route => ({ pageFilter: "user" + route.params.id })
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
        { path: "/markseen", component: MarkWagonsAsSeen },
    ],
    mode: "history"
});
