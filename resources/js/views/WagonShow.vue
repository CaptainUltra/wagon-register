<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Данни за вагон</h4>
      <div v-if="loading" class="pl-2">
        <p>Зареждане...</p>
      </div>
      <div v-else class="row pt-2">
        <div class="col-md-12 col-lg-6">
          <img class="img-fluid" src="https://placehold.it/1920x1080" />
        </div>
        <div class="col-md-12 col-lg-6">
          <h5>
            <b>№:</b>
            <b>{{wagon.stylized_number}}</b>
          </h5>
          <p>
            <b>Серия:</b>
            {{wagon.type.data.name}}
          </p>
          <p>
            <b>Буквено означение:</b>
            {{wagon.letter_index ? wagon.letter_index : "-"}}
          </p>
          <p>
            <b>Максимална скорост:</b>
            {{wagon.v_max ? wagon.v_max : "-"}}
          </p>
          <p>
            <b>Брой на местата:</b>
            {{wagon.seats ? wagon.seats : "-"}}
          </p>
          <p>
            <b>Депо:</b>
            {{wagon.depot ? wagon.depot.data.name : "-"}}
          </p>
          <h6>
            <b>Ревизия (пункт / дата / дата на изтичане):</b>
          </h6>
          <p>
            {{wagon.revisory_point ? wagon.revisory_point.data.name : "-"}} (
            <b>{{wagon.revisory_point ? wagon.revisory_point.data.abbreviation : ""}}</b>
            ) /
            {{wagon.revision_date ? wagon.revision_date : "-"}} /
            <b
              class="text-danger"
            >{{wagon.revision_expiration_date ? wagon.revision_expiration_date : "-"}}</b>
          </p>
          <p>
            <b class="text-body">Статус:</b>
            <b
              class="text-success"
              v-if="wagon.status.data.id == 1 || wagon.status.data.id == 7||wagon.status.data.id == 8||wagon.status.data.id == 9"
            >{{wagon.status.data.name}}</b>
            <b class="text-danger" v-else>{{wagon.status.data.name}}</b>
          </p>
          <p>
            <b>Последна промяна:</b>
            {{wagon.last_updated}}
          </p>
        </div>
        <div class="col-12 pt-2" v-if="userHasPermission('event-viewWagon')">
          <h5>Последно видян:</h5>
          <ul class="list-group">
            <li
              v-for="event in wagon.events"
              class="list-group-item"
            >{{event.data.date}} - видян на {{event.data.train ? event.data.train.data.number : ""}} {{event.data.station ? event.data.station.data.name : ""}}</li>
            <li class="list-group-item">
              <router-link :to="'/wagons/' + wagon.id +'/events'">Всички събития за този вагон</router-link>
            </li>
          </ul>
        </div>
        <div class="pt-3 pl-2 d-flex w-100 justify-content-between">
          <a href="#" @click="$router.back()">< Назад</a>
          <div class="justify-content-end position-relative">
            <router-link
              :to="'/wagons/' + wagon.id + '/events/create'"
              class="btn btn-outline-primary mr-4"
            >Добавяне на събитие</router-link>
            <router-link
              :to="'/wagons/' + wagon.id + '/edit'"
              class="btn btn-outline-success ml-3"
              v-if="userHasPermission('wagon-update')"
            >Промяна</router-link>
            <button
              class="btn btn-outline-danger ml-3 mr-4"
              @click="modal = !modal"
              v-if="userHasPermission('wagon-delete')"
            >Изтриване</button>
            <div v-if="modal" class="position-absolute bg-dark rounded-lg p-4">
              <p
                class="text-white"
              >Сигурни ли сте, че искате да изтриете този вагон? Това действие е необратимо и всички записи свързани с този вагон също ще бъдат изтрити!</p>
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
  name: "WagonShow",
  props: ["permissions"],
  mounted() {
    axios
      .get("/api/wagons/" + this.$route.params.id + "?show-events=1")
      .then(response => {
        this.wagon = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/wagons");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
  },
  data: function() {
    return {
      loading: true,
      modal: false,
      wagon: null
    };
  },
  methods: {
    destroy() {
      axios
        .delete("/api/wagons/" + this.$route.params.id)
        .then(response => {
          this.$router.push("/wagons");
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