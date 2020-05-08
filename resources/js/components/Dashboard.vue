<template>
  <div>
    <MenuNavbar :permissions="permissions" :roles="roles"></MenuNavbar>
    <div class="row bg-white mr-0">
      <MenuSidebar :permissions="permissions" :roles="roles"></MenuSidebar>
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

export default {
  name: "Dashboard",
  props: ["user", "permissions", "roles"],
  components: {
    MenuSidebar,
    MenuNavbar
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
