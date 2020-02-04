<template>
  <div class="row bg-white">
    <!--<div class="col-md-2 col-sm-6 col-xs-6 h-100 bg-light border-right border-dark">
             <nav class="pl-4 pt-4">
              <h3>Табло за управление</h3>
                <div class="shadow-sm mb-5 mt-3 bg-white rounded align-content-center">
                <p class="text-center mb-0 pt-1 pl-1 font-weight-bold">Вагони</p>
                <router-link to="dashboard/seen" class="d-block p-1">Маркирай видян</router-link>
                <router-link to="dashboard/my-seen" class="d-block p-1">Моите видени</router-link>
                <router-link to="dashboard/wagons" class="d-block p-1">Всички вагони</router-link>
                </div>
          </nav> 
    </div>-->
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <h3 class="p-4 pb-0">Табло за управление</h3>
        <ul class="nav flex-column pl-3">
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link active">Табло за управление</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">Табло за управление</router-link>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#collapseExample">Dropdown</a>
            <div class="collapse" id="collapseExample">
               <div class="card card-body mr-3">
                <li class="nav-item">
                  <router-link to="/dashboard" class="nav-link">Табло за управление</router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/dashboard" class="nav-link">Табло за управление</router-link>
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
    <main class="col-md-9 d-none d-md-block ml-sm-auto col-lg-10 px-4">
      <div class="pt-3 pb-2 mb-3">
        <router-view></router-view>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
