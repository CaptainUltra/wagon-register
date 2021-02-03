<template>
    <div>
<!--        <p v-if="user == null">test</p>-->
        <router-view :permissions="permissions"></router-view>
    </div>
</template>

<script>
export default {
    name: "Gallery",
    props: ["user", "permissions"],
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
}
</script>

<style scoped>

</style>
