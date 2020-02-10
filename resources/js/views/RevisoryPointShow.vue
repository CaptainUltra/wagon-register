<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Данни за пункт за ревизия</h4>
      <div v-if="loading" class="pl-2">
        <p>Зареждане...</p>
      </div>
      <div v-else class="pl-2 pt-2">
        <p>
          <b>№:</b>
          {{revisoryPoint.id}}
        </p>
        <p>
          <b>Име:</b>
          {{revisoryPoint.name}}
        </p>
        <p>
          <b>Съкращение:</b>
          {{revisoryPoint.abbreviation}}
        </p>
        <p>
          <b>Последна промяна:</b>
          {{revisoryPoint.last_updated}}
        </p>
        <div class="pt-3 d-flex justify-content-between">
            <a href="#" @click="$router.back()">< Назад</a>
          <div class="justify-content-end position-relative">
            <router-link
              :to="'/revisorypoints/' + revisoryPoint.id + '/edit'"
              class="btn btn-outline-success"
            >Промяна</router-link>
            <button class="btn btn-outline-danger ml-3 mr-4" @click="modal = !modal">Изтриване</button>
            <div v-if="modal" class="position-absolute bg-dark rounded-lg p-4">
              <p
                class="text-white"
              >Сигурни ли сте, че искате да изтриете този пункт за ревизия? Това действие е необратимо и всички записи на вагони, свързани с този пункт за ревизия също ще бъдат изтрити!</p>
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
  name: "RevisoryPointShow",
  mounted() {
    axios
      .get("/api/revisorypoints/" + this.$route.params.id)
      .then(response => {
        this.revisoryPoint = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/revisorypoints");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
  },
  data: function() {
    return {
      loading: true,
      modal: false,
      revisoryPoint: null
    };
  },
  methods: {
    destroy() {
      axios
        .delete("/api/revisorypoints/" + this.$route.params.id)
        .then(response => {
          this.$router.push("/revisorypoints");
        })
        .catch(error => {
          alert("Грешка при изтриването!");
        });
    }
  }
};
</script>