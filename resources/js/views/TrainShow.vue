<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Данни за влак</h4>
      <div v-if="loading" class="pl-2">
        <p>Зареждане...</p>
      </div>
      <div v-else class="pl-2 pt-2">
        <p>
          <b>№:</b>
          {{train.number}}
        </p>
        <p>
          <b>Маршрут:</b>
          {{train.route}}
        </p>
        <p>
          <b>Последна промяна:</b>
          {{train.last_updated}}
        </p>
        <h6>Състав на влака:</h6>
        <div>
          <ul class="list-group">
            <li v-for="wagontype in train.wagontypes" class="list-group-item">
              <img
                class="img-fluid pr-2"
                src="https://placehold.it/1920x1080"
                style="max-width: 35%;
	                    max-height: 100%;"
              />
              <b>{{wagontype.data.name}}</b>
              - {{wagontype.data.conditioned ? "Климатизиран" : "Неклиматизиран"}} - {{wagontype.data.interior_type.data.name}}
            </li>
          </ul>
        </div>
        <div class="pt-3 d-flex justify-content-between">
          <a href="#" @click="$router.back()">< Назад</a>
          <div class="justify-content-end position-relative">
            <router-link
              :to="'/trains/' + train.id + '/edit'"
              class="btn btn-outline-success"
            >Промяна</router-link>
            <button class="btn btn-outline-danger ml-3 mr-4" @click="modal = !modal">Изтриване</button>
            <div v-if="modal" class="position-absolute bg-dark rounded-lg p-4">
              <p
                class="text-white"
              >Сигурни ли сте, че искате да изтриете този влак? Това действие е необратимо и всички записи, свързани с този влак също ще бъдат изтрити!</p>
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
  name: "TrainShow",
  mounted() {
    axios
      .get("/api/trains/" + this.$route.params.id)
      .then(response => {
        this.train = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/trains");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
  },
  data: function() {
    return {
      loading: true,
      modal: false,
      train: null
    };
  },
  methods: {
    destroy() {
      axios
        .delete("/api/trains/" + this.$route.params.id)
        .then(response => {
          this.$router.push("/trains");
        })
        .catch(error => {
          alert("Грешка при изтриването!");
        });
    }
  }
};
</script>