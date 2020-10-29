<template>
    <nav :class="navStyle" :id="navId">
        <div :class="divClass">
            <ul :class="ulStyle">
                <li class="nav-item" v-if="userHasPermission('event-create')">
                    <router-link to="/markseen" class="nav-link" data-toggle="collapse" :data-target="'#' + navId">
                        Маркиране на видени
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link
                        to="/events"
                        class="nav-link"
                        v-if="userHasPermission('event-viewAny')"
                        data-toggle="collapse" :data-target="'#' + navId"
                    >Всички видени
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link
                        to="/events/today"
                        class="nav-link"
                        data-toggle="collapse" :data-target="'#' + navId"
                    >Видени днес
                    </router-link>
                </li>
                <li class="nav-item dropdown" v-if="userHasPermission('wagon-viewAny')">
                    <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#wagonCollapse">Вагони</a>
                    <div class="collapse" id="wagonCollapse">
                        <div class="card card-body mr-3">
                            <ul>
                                <li class="nav-item">
                                    <router-link
                                        to="/wagons/create"
                                        class="nav-link"
                                        v-if="userHasPermission('wagon-create')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Регистриране на вагон
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/wagons"
                                        class="nav-link"
                                        v-if="userHasPermission('wagon-viewAny')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Всички вагони
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/wagons/expiring-revision"
                                        class="nav-link"
                                        v-if="userHasPermission('wagon-viewAny')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Изтичащи този месец ревизии
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown" v-if="userHasPermission('train-viewAny')">
                    <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#trainCollapse">Влакове</a>
                    <div class="collapse" id="trainCollapse">
                        <div class="card card-body mr-3">
                            <ul>
                                <li class="nav-item">
                                    <router-link
                                        to="/trains/create"
                                        class="nav-link"
                                        v-if="userHasPermission('train-create')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Създаване на влак
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/trains"
                                        class="nav-link"
                                        v-if="userHasPermission('train-viewAny')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Всички влакове
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown" v-if="userHasPermission('station-viewAny')">
                    <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#stationCollapse">Гари</a>
                    <div class="collapse" id="stationCollapse">
                        <div class="card card-body mr-3">
                            <ul>
                                <li class="nav-item">
                                    <router-link
                                        to="/stations/create"
                                        class="nav-link"
                                        v-if="userHasPermission('station-create')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Създаване на гара
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/stations"
                                        class="nav-link"
                                        v-if="userHasPermission('station-viewAny')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Всички гари
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>

            <h6
                class="sidebar-heading d-flex justify-content-between align-items-center px-3 pl-4 mt-4 mb-1 text-muted"
                v-if="userHasRole('moderator-role')"
            >
                <span>Модератор</span>
            </h6>
            <ul :class="ulSecondStyle" v-if="userHasRole('moderator-role')">
                <li class="nav-item dropdown" v-if="userHasPermission('depot-viewAny')">
                    <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#depotCollapse">Депа</a>
                    <div class="collapse" id="depotCollapse">
                        <div class="card card-body mr-3">
                            <ul>
                                <li class="nav-item">
                                    <router-link
                                        to="/depots/create"
                                        class="nav-link"
                                        v-if="userHasPermission('depot-create')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Създаване на депо
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/depots"
                                        class="nav-link"
                                        v-if="userHasPermission('depot-viewAny')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Всички депа
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown" v-if="userHasPermission('revisorypoint-viewAny')">
                    <a
                        class="nav-link dropdown-toggle"
                        data-toggle="collapse"
                        href="#revPointCollapse"
                    >Пунктове за ревизия</a>
                    <div class="collapse" id="revPointCollapse">
                        <div class="card card-body mr-3">
                            <ul>
                                <li class="nav-item">
                                    <router-link
                                        to="/revisorypoints/create"
                                        class="nav-link"
                                        v-if="userHasPermission('revisorypoint-create')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Създаване на пункт
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/revisorypoints"
                                        class="nav-link"
                                        v-if="userHasPermission('revisorypoint-viewAny')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Всички пунктове
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown" v-if="userHasPermission('interiortype-viewAny')">
                    <a
                        class="nav-link dropdown-toggle"
                        data-toggle="collapse"
                        href="#interiorTypeCollapse"
                    >Типове интериори</a>
                    <div class="collapse" id="interiorTypeCollapse">
                        <div class="card card-body mr-3">
                            <ul>
                                <li class="nav-item">
                                    <router-link
                                        to="/interiortypes/create"
                                        class="nav-link"
                                        v-if="userHasPermission('interiortype-create')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Създаване на тип
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/interiortypes"
                                        class="nav-link"
                                        v-if="userHasPermission('interiortype-viewAny')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Всички типове
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown" v-if="userHasPermission('wagontype-viewAny')">
                    <a
                        class="nav-link dropdown-toggle"
                        data-toggle="collapse"
                        href="#wagonTypeCollapse"
                    >Серии вагони</a>
                    <div class="collapse" id="wagonTypeCollapse">
                        <div class="card card-body mr-3">
                            <ul>
                                <li class="nav-item">
                                    <router-link
                                        to="/wagontypes/create"
                                        class="nav-link"
                                        v-if="userHasPermission('wagontype-create')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Създаване на серия
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/wagontypes"
                                        class="nav-link"
                                        v-if="userHasPermission('wagontype-viewAny')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Всички серии
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown" v-if="userHasPermission('status-viewAny')">
                    <a
                        class="nav-link dropdown-toggle"
                        data-toggle="collapse"
                        href="#statusCollapse"
                    >Статуси на вагони</a>
                    <div class="collapse" id="statusCollapse">
                        <div class="card card-body mr-3">
                            <ul>
                                <li class="nav-item">
                                    <router-link
                                        to="/statuses/create"
                                        class="nav-link"
                                        v-if="userHasPermission('status-create')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Създаване на статус
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/statuses"
                                        class="nav-link"
                                        v-if="userHasPermission('status-viewAny')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Всички статуси
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
            <h6
                class="sidebar-heading d-flex justify-content-between align-items-center px-3 pl-4 mt-4 mb-1 text-muted"
                v-if="userHasRole('administrator-role')"
            >
                <span>Администратор</span>
            </h6>
            <ul :class="ulSecondStyle">
                <li class="nav-item dropdown" v-if="userHasPermission('user-viewAny')">
                    <a
                        class="nav-link dropdown-toggle"
                        data-toggle="collapse"
                        href="#userCollapse"
                    >Потребители</a>
                    <div class="collapse" id="userCollapse">
                        <div class="card card-body mr-3">
                            <ul>
                                <li class="nav-item">
                                    <router-link
                                        to="/users/create"
                                        class="nav-link"
                                        v-if="userHasPermission('user-create')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Създаване на потребител
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/users"
                                        class="nav-link"
                                        v-if="userHasPermission('user-viewAny')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Всички потребители
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown" v-if="userHasPermission('role-viewAny')">
                    <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#roleCollapse">Роли</a>
                    <div class="collapse" id="roleCollapse">
                        <div class="card card-body mr-3">
                            <ul>
                                <li class="nav-item">
                                    <router-link
                                        to="/roles/create"
                                        class="nav-link"
                                        v-if="userHasPermission('role-create')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Създаване на роля
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/roles"
                                        class="nav-link"
                                        v-if="userHasPermission('role-viewAny')"
                                        data-toggle="collapse" :data-target="'#' + navId"
                                    >Всички роли
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Menu",
    props: {
        navStyle: {
            type: String,
            required: true
        },
        navId: {
            type: String
        },
        divStyle: {
            type: String,
            required: true
        },
        ulStyle: {
            type: String,
            required: true
        },
        ulSecondStyle: {
            type: String,
            required: true
        },
        permissions: {
            type: Array,
            required: true
        },
        roles: {
            type: Array,
            required: true
        }
    },
    methods: {
        userHasPermission(permission) {
            var flag = false;
            this.permissions.forEach(element => {
                if (element == permission) {
                    flag = true;
                    return false;
                }
            });
            return flag;
        },
        userHasRole(role) {
            var flag = false;
            this.roles.forEach(element => {
                if (element == role) {
                    flag = true;
                    return false;
                }
            });
            return flag;
        }
    }
}
</script>
