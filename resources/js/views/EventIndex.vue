<template>
  <div class="py-4">
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="events.length === 0">
        <p>Няма налични събития</p>
      </div>
      <h4 v-if="filter === 'wagon'">Списък на събития за вагон</h4>
      <h4 v-if="filter === 'date'">Списък на събития от днес</h4>
      <h4 v-if="filter == null">Списък на всички събития</h4>
      <table class="table">
        <thead>
          <tr>
            <th scope="col" v-if="filter === 'wagon'">Дата</th>
            <th scope="col" v-if="filter === 'date'">Вагон</th>
            <th scope="col" v-if="filter == null">Дата</th>
            <th scope="col" v-if="filter == null">Вагон</th>
            <th scope="col">Влак</th>
            <th scope="col">Гара</th>
            <th scope="col">Коментар</th>
            <th scope="col">Последна промяна</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="event in events">
            <th scope="row" v-if="filter === 'wagon'">
              <router-link
                class="text-body"
                :to="'/events/' + event.data.id"
                :permissions="permissions"
              >{{ event.data.date}}</router-link>
            </th>
            <th scope="row" v-if="filter === 'date'">
              <router-link
                class="text-body"
                :to="'/events/' + event.data.id"
              >{{ event.data.wagon.data.stylized_number}}</router-link>
            </th>
            <th scope="row" v-if="filter ==  null">
              <router-link
                class="text-body"
                :to="'/events/' + event.data.id"
                :permissions="permissions"
              >{{ event.data.date}}</router-link>
            </th>
            <th scope="row" v-if="filter == null">
              <router-link
                class="text-body"
                :to="'/events/' + event.data.id"
              >{{ event.data.wagon.data.stylized_number}}</router-link>
            </th>
            <td>
              <router-link
                class="text-body"
                :to="'/events/' + event.data.id"
              >{{event.data.train ? event.data.train.data.number : "-"}}</router-link>
            </td>
            <td>
              <router-link
                class="text-body"
                :to="'/events/' + event.data.id"
              >{{event.data.station ? event.data.station.data.name : "-"}}</router-link>
            </td>
            <td>
              <router-link
                class="text-body"
                :to="'/events/' + event.data.id"
              >{{event.data.comment ? event.data.comment : "-"}}</router-link>
            </td>
            <td>{{event.data.last_updated}}</td>
          </tr>
        </tbody>
      </table>
      <Pagination :pagination="pagination" model="events?show-wagon=1" @updatepage="updateData"></Pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "../components/Pagination";

export default {
  name: "EventIndex",
  props: ["filter", "value", "permissions"],
  components: {
    Pagination
  },
  mounted() {
    this.getData();
  },
  data: function() {
    return {
      loading: true,
      events: null,
      pagination: {
        total: null,
        currentPage: null,
        lastPage: null
      }
    };
  },
  methods: {
    updateData(value) {
      this.events = value.values;
      this.pagination = value.paginationData;
      this.loading = value.loading;
    },
    getData() {
      var url = "/api/events/?show-wagon=1";
      if (this.filter === "wagon") {
        url = url + "&wagon_id=" + this.value;
      }
      if (this.filter === "date") {
        url = url + "&date=" + this.value;
      }
      if (this.filter === "user") {
        url = url + "&user_id=" + this.value;
      }
      axios
        .get(url)
        .then(response => {
          this.events = response.data.data;
          this.pagination.currentPage = response.data.meta["current_page"];
          this.pagination.lastPage = response.data.meta["last_page"];
          this.pagination.total = response.data.meta["total"];
          this.loading = false;
        })
        .catch(error => {
          alert("Грешка при взимането на информация");
        });
    }
  },
  watch: {
    filter: {
      immediate: true,
      handler(value) {
        this.getData();
      }
    }
  }
};
</script>
