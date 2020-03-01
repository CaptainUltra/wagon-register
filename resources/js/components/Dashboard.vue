<template>
  <div class="row bg-white mr-0">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <h3 class="p-4 pb-0">Табло за управление</h3>
        <ul class="nav flex-column pl-3">
          <li class="nav-item">
            <router-link to="/" class="nav-link active">Табло за управление</router-link>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#depotCollapse">Депа</a>
            <div class="collapse" id="depotCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link to="/depots/create" class="nav-link">Създаване на депо</router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/depots" class="nav-link">Всички депа</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#revPointCollapse">Пунктове за ревизия</a>
            <div class="collapse" id="revPointCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link to="/revisorypoints/create" class="nav-link">Създаване на пункт</router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/revisorypoints" class="nav-link">Всички пунктове</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#interiorTypeCollapse">Типове интериори</a>
            <div class="collapse" id="interiorTypeCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link to="/interiortypes/create" class="nav-link">Създаване на тип</router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/interiortypes" class="nav-link">Всички типове</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#wagonTypeCollapse">Серии вагони</a>
            <div class="collapse" id="wagonTypeCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link to="/wagontypes/create" class="nav-link">Създаване на серия</router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/wagontypes" class="nav-link">Всички серии</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#wagonCollapse">Вагони</a>
            <div class="collapse" id="wagonCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link to="/wagons/create" class="nav-link">Създаване на вагон</router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/wagons" class="nav-link">Всички вагони</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#trainCollapse">Влакове</a>
            <div class="collapse" id="trainCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link to="/trains/create" class="nav-link">Създаване на влак</router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/trains" class="nav-link">Всички влакове</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#stationCollapse">Гари</a>
            <div class="collapse" id="stationCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link to="/stations/create" class="nav-link">Създаване на гара</router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/stations" class="nav-link">Всички гари</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#statusCollapse">Статуси на вагони</a>
            <div class="collapse" id="statusCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link to="/statuses/create" class="nav-link">Създаване на статус</router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/statuses" class="nav-link">Всички статуси</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#userCollapse">Потребители</a>
            <div class="collapse" id="userCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link to="/users/create" class="nav-link">Създаване на потребител</router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/users" class="nav-link">Всички потребители</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#roleCollapse">Роли</a>
            <div class="collapse" id="roleCollapse">
              <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link to="/roles/create" class="nav-link">Създаване на роля</router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/roles" class="nav-link">Всички роли</router-link>
                </li>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <router-link to="/events" class="nav-link">Всички събития</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/events/today" class="nav-link">Събития от днес</router-link>
          </li>
        </ul>

        <h6
          class="sidebar-heading d-flex justify-content-between align-items-center px-3 pl-4 mt-4 mb-1 text-muted"
        >
          <span>Някакво разделение</span>
          <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2 pl-3">
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">Табло за управление</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">Табло за управление</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">Табло за управление</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">Табло за управление</router-link>
          </li>
        </ul>
      </div>
    </nav>
    <main
      class="col-md-9 d-none d-md-block ml-sm-auto col-lg-10 px-4 overflow-x-hidden"
      style="height: 94.6vh;"
    >
      <div class="pt-3 pb-2 mb-3">
        <router-view></router-view>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: "Dashboard",
  props: ["user"],
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
  }
};
</script>
