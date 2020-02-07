<template>
  <div class="row bg-white mr-0">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <h3 class="p-4 pb-0">Табло за управление</h3>
        <ul class="nav flex-column pl-3">
          <li class="nav-item">
            <router-link to="/" class="nav-link active">Табло за управление</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/home" class="nav-link">Табло за управление</router-link>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#collapseExample">Депа</a>
            <div class="collapse" id="collapseExample">
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
      class="col-md-9 d-none d-md-block ml-sm-auto col-lg-10 px-4 overflow-hidden"
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
