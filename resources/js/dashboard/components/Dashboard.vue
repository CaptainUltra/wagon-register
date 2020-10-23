<template>
    <div>
<!--        <MenuNavbar :permissions="permissions" :roles="roles"></MenuNavbar>-->
        <Menu :permissions="permissions" :roles="roles"
              nav-style="navbar navbar-expand-md navbar-light bg-white shadow-sm collapse d-md-none"
              nav-id="navbarResponsive"
              div-style="mt-2"
              ul-style="navbar-nav ml-auto"
              ul-second-style="navbar-nav ml-auto"
        ></Menu>
        <div class="row bg-white mr-0">
<!--            <MenuSidebar :permissions="permissions" :roles="roles"></MenuSidebar>-->
            <Menu :permissions="permissions" :roles="roles"
                  nav-style="col-md-2 d-none d-md-block bg-light sidebar text-break"
                  div-style="sidebar-sticky"
                  ul-style="nav flex-column pl-3 mt-4"
                  ul-second-style="nav flex-column mb-2 pl-3"
            ></Menu>
            <main class="col-md-10 col-12 d-md-block ml-auto px-4 overflow-auto" style="height: 94.6vh;">
                <div class="pt-3 pb-2 mb-3">
                    <router-view :permissions="permissions"></router-view>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import MenuNavbar from "./MenuNavbar.vue";
import MenuSidebar from "./MenuSidebar.vue";
import Menu from "./Menu.vue";

export default {
    name: "Dashboard",
    props: ["user", "permissions", "roles"],
    components: {
        MenuSidebar,
        MenuNavbar,
        Menu
    },
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
