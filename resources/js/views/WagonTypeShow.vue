<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Данни за серия вагон</h4>
      <div v-if="loading" class="pl-2">
        <p>Зареждане...</p>
      </div>
      <div v-else class="pl-2 pt-2">
        <p>
          <b>№:</b>
          {{wagonType.id}}
        </p>
        <p>
          <b>Означение:</b>
          {{wagonType.name}}
        </p>
        <p>
          <b>Климатизиран:</b>
          {{wagonType.conditioned ? "Да" : "Не"}}
        </p>
        <p>
          <b>Тип интериор:</b>
          {{wagonType.interior_type.data.name}}
        </p>
        <p>
          <b>Валидност на ревизия:</b>
          {{wagonType.revision_valid_for}}
        </p>
        <p>
          <b>Последна промяна:</b>
          {{wagonType.last_updated}}
        </p>
        <div class="pt-3 d-flex justify-content-between">
          <a href="#" @click="$router.back()">< Назад</a>
          <div class="justify-content-end position-relative">
            <router-link
              :to="'/wagontypes/' + wagonType.id + '/edit'"
              class="btn btn-outline-success"
              v-if="userHasPermission('wagontype-update')"
            >Промяна</router-link>
            <button
              class="btn btn-outline-danger ml-3 mr-4"
              @click="modal = !modal"
              v-if="userHasPermission('wagontype-delete')"
            >Изтриване</button>
            <div v-if="modal" class="position-absolute bg-dark rounded-lg p-4">
              <p
                class="text-white"
              >Сигурни ли сте, че искате да изтриете тази серия вагони? Това действие е необратимо и всички записи на вагони, свързани с тази серия вагони също ще бъдат изтрити!</p>
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
  name: "WagonTypeShow",
  props: ["permissions"],
  mounted() {
    axios
      .get("/api/wagontypes/" + this.$route.params.id)
      .then(response => {
        this.wagonType = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/wagontypes");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
  },
  data: function() {
    return {
      loading: true,
      modal: false,
      wagonType: null
    };
  },
  methods: {
    destroy() {
      axios
        .delete("/api/wagontypes/" + this.$route.params.id)
        .then(response => {
          this.$router.push("/wagontypes");
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