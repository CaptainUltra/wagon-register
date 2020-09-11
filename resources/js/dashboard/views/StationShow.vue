<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Данни за гара</h4>
      <div v-if="loading" class="pl-2">
        <p>Зареждане...</p>
      </div>
      <div v-else class="pl-2 pt-2">
        <p>
          <b>№:</b>
          {{station.id}}
        </p>
        <p>
          <b>Име:</b>
          {{station.name}}
        </p>
        <p>
          <b>Последна промяна:</b>
          {{station.last_updated}}
        </p>
        <div class="pt-3 d-flex justify-content-between">
          <a href="#" @click="$router.back()">< Назад</a>
          <div class="justify-content-end position-relative">
            <router-link
              :to="'/stations/' + station.id + '/edit'"
              class="btn btn-outline-success"
              v-if="userHasPermission('station-update')"
            >Промяна</router-link>
            <button
              class="btn btn-outline-danger ml-3 mr-4"
              @click="modal = !modal"
              v-if="userHasPermission('station-delete')"
            >Изтриване</button>
            <div v-if="modal" class="position-absolute bg-dark rounded-lg p-4">
              <p
                class="text-white"
              >Сигурни ли сте, че искате да изтриете тази гара? Това действие е необратимо и всички записи, свързани с тази гара също ще бъдат изтрити!</p>
              <div class="d-flex justify-content-end">
                <button @click="modal = !modal" class="btn btn-success">Отказ</button>
                <button @click="destroy" class="btn btn-danger ml-3">Изтриване</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "StationShow",
  props: ["permissions"],
  mounted() {
    axios
      .get("/api/stations/" + this.$route.params.id)
      .then(response => {
        this.station = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/stations");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
  },
  data: function() {
    return {
      loading: true,
      modal: false,
      station: null
    };
  },
  methods: {
    destroy() {
      axios
        .delete("/api/stations/" + this.$route.params.id)
        .then(response => {
          this.$router.push("/stations");
        })
        .catch(error => {
          alert("Грешка при изтриването!");
        });
    },
    userHasPermission(permission) {
      var flag = false;
      this.permissions.forEach(element => {
        if (element == permission) {
          flag = true;
          return false;
        }
      });
      return flag;
    }
  }
};
</script>