<template>
  <div class="row bg-white mr-0">
    <nav class="col-md-2 col-sm-3 col-3 d-md-block bg-light sidebar text-break">
      <div class="sidebar-sticky">
        <h3 class="p-4 pb-0">Табло за управление</h3>
        <ul class="nav flex-column pl-3">
          <li class="nav-item">
            <router-link to="/" class="nav-link active">Начало</router-link>
          </li>
          <li class="nav-item" v-if="userHasPermission('event-create')">
            <router-link to="/markseen" class="nav-link">Маркиране на видени</router-link>
          </li>
          <li class="nav-item">
            <router-link
              to="/events"
              class="nav-link"
              v-if="userHasPermission('event-viewAny')"
            >Всички събития</router-link>
          </li>
          <li class="nav-item">
            <router-link
              to="/events/today"
              class="nav-link"
              v-if="userHasPermission('event-viewDate')"
            >Събития от днес</router-link>
          </li>
          <li class="nav-item dropdown" v-if="userHasPermission('wagon-viewAny')">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#wagonCollapse">Вагони</a>
            <div class="collapse" id="wagonCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link
                    to="/wagons/create"
                    class="nav-link"
                    v-if="userHasPermission('wagon-create')"
                  >Създаване на вагон</router-link>
                </li>
                <li class="nav-item">
                  <router-link
                    to="/wagons"
                    class="nav-link"
                    v-if="userHasPermission('wagon-viewAny')"
                  >Всички вагони</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown" v-if="userHasPermission('train-viewAny')">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#trainCollapse">Влакове</a>
            <div class="collapse" id="trainCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link
                    to="/trains/create"
                    class="nav-link"
                    v-if="userHasPermission('train-create')"
                  >Създаване на влак</router-link>
                </li>
                <li class="nav-item">
                  <router-link
                    to="/trains"
                    class="nav-link"
                    v-if="userHasPermission('train-viewAny')"
                  >Всички влакове</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown" v-if="userHasPermission('station-viewAny')">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#stationCollapse">Гари</a>
            <div class="collapse" id="stationCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link
                    to="/stations/create"
                    class="nav-link"
                    v-if="userHasPermission('station-create')"
                  >Създаване на гара</router-link>
                </li>
                <li class="nav-item">
                  <router-link
                    to="/stations"
                    class="nav-link"
                    v-if="userHasPermission('station-viewAny')"
                  >Всички гари</router-link>
                </li>
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
        <ul class="nav flex-column mb-2 pl-3" v-if="userHasRole('moderator-role')">
          <li class="nav-item dropdown" v-if="userHasPermission('depot-viewAny')">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#depotCollapse">Депа</a>
            <div class="collapse" id="depotCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link
                    to="/depots/create"
                    class="nav-link"
                    v-if="userHasPermission('depot-create')"
                  >Създаване на депо</router-link>
                </li>
                <li class="nav-item">
                  <router-link
                    to="/depots"
                    class="nav-link"
                    v-if="userHasPermission('depot-viewAny')"
                  >Всички депа</router-link>
                </li>
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
                <li class="nav-item">
                  <router-link
                    to="/revisorypoints/create"
                    class="nav-link"
                    v-if="userHasPermission('revisorypoint-create')"
                  >Създаване на пункт</router-link>
                </li>
                <li class="nav-item">
                  <router-link
                    to="/revisorypoints"
                    class="nav-link"
                    v-if="userHasPermission('revisorypoint-viewAny')"
                  >Всички пунктове</router-link>
                </li>
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
                <li class="nav-item">
                  <router-link
                    to="/interiortypes/create"
                    class="nav-link"
                    v-if="userHasPermission('interiortype-create')"
                  >Създаване на тип</router-link>
                </li>
                <li class="nav-item">
                  <router-link
                    to="/interiortypes"
                    class="nav-link"
                    v-if="userHasPermission('interiortype-viewAny')"
                  >Всички типове</router-link>
                </li>
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
                <li class="nav-item">
                  <router-link
                    to="/wagontypes/create"
                    class="nav-link"
                    v-if="userHasPermission('wagontype-create')"
                  >Създаване на серия</router-link>
                </li>
                <li class="nav-item">
                  <router-link
                    to="/wagontypes"
                    class="nav-link"
                    v-if="userHasPermission('wagontype-viewAny')"
                  >Всички серии</router-link>
                </li>
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
                <li class="nav-item">
                  <router-link
                    to="/statuses/create"
                    class="nav-link"
                    v-if="userHasPermission('status-create')"
                  >Създаване на статус</router-link>
                </li>
                <li class="nav-item">
                  <router-link
                    to="/statuses"
                    class="nav-link"
                    v-if="userHasPermission('status-viewAny')"
                  >Всички статуси</router-link>
                </li>
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
        <ul class="nav flex-column mb-2 pl-3">
          <li class="nav-item dropdown" v-if="userHasPermission('user-viewAny')">
            <a
              class="nav-link dropdown-toggle"
              data-toggle="collapse"
              href="#userCollapse"
            >Потребители</a>
            <div class="collapse" id="userCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link
                    to="/users/create"
                    class="nav-link"
                    v-if="userHasPermission('user-create')"
                  >Създаване на потребител</router-link>
                </li>
                <li class="nav-item">
                  <router-link
                    to="/users"
                    class="nav-link"
                    v-if="userHasPermission('user-viewAny')"
                  >Всички потребители</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown" v-if="userHasPermission('role-viewAny')">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#roleCollapse">Роли</a>
            <div class="collapse" id="roleCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link
                    to="/roles/create"
                    class="nav-link"
                    v-if="userHasPermission('role-create')"
                  >Създаване на роля</router-link>
                </li>
                <li class="nav-item">
                  <router-link
                    to="/roles"
                    class="nav-link"
                    v-if="userHasPermission('role-viewAny')"
                  >Всички роли</router-link>
                </li>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <main
      class="col-md-10 col-sm-9 col-9 d-md-block ml-auto col-lg-10 px-4 overflow-auto"
      style="height: 94.6vh;"
    >
      <div class="pt-3 pb-2 mb-3">
        <router-view :permissions="permissions"></router-view>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: "Dashboard",
  props: ["user", "permissions", "roles"],
  created() {
    window.axios.interceptors.request.use(config => {
      if (config.method === "get") {
        if (config.url.includes("?")) {
          config.url = config.url + "&api_token=" + this.user.api_token;
        } else {
          config.url = config.url + "?api_token=" + this.user.api_token;
        }
      } else {
        config.data = {
          ...config.data,
          api_token: this.user.api_token
        };
      }
      return config;
    });
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
};
</script>
