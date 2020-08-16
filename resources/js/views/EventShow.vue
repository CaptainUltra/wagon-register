<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Данни за събитие</h4>
      <div v-if="loading" class="pl-2">
        <p>Зареждане...</p>
      </div>
      <div v-else class="pl-2 pt-2">
        <p>
          <b>Вагон №:</b>
          {{event.wagon.number}}
        </p>
        <p>
          <b>Дата:</b>
          {{event.date}}
        </p>
        <p>
          <b>Влак:</b>
          {{event.train ? event.train.data.number : "-"}}
        </p>
        <p>
          <b>Гара:</b>
          {{event.station ? event.station.data.name : "-"}}
        </p>
        <p>
          <b>Коментар:</b>
          {{event.comment ? event.comment : "-"}}
        </p>
        <p>
          <b>Последна промяна:</b>
          {{event.last_updated}}
        </p>
        <div class="pt-3 d-flex justify-content-between">
          <a href="#" @click="$router.back()">< Назад</a>
          <div class="justify-content-end position-relative">
            <router-link
              :to="'/events/' + event.id + '/edit'"
              class="btn btn-outline-success"
              v-if="userHasPermission('event-update')"
            >Промяна</router-link>
            <button
              class="btn btn-outline-danger ml-3 mr-4"
              @click="modal = !modal"
              v-if="userHasPermission('event-delete')"
            >Изтриване</button>
            <div v-if="modal" class="position-absolute bg-dark rounded-lg p-4">
              <p
                class="text-white"
              >Сигурни ли сте, че искате да изтриете това събитие? Това действие е необратимо!</p>
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
  name: "EventShow",
  props: ["permissions"],
  mounted() {
    axios
      .get("/api/events/" + this.$route.params.id + "?show-wagon=1")
      .then(response => {
        this.event = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/events");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
  },
  data: function() {
    return {
      loading: true,
      modal: false,
      event: null
    };
  },
  methods: {
    destroy() {
      axios
        .delete("/api/events/" + this.$route.params.id)
        .then(response => {
          this.$router.push("/events");
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