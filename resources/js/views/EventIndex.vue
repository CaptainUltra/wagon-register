<template>
  <div class="py-2">
    <EventFilter @applyFilters="applyFilters($event)"></EventFilter>
    <h4 v-if="pageFilter != null && pageFilter.includes('wagon')">Списък на събития за вагон</h4>
    <h4 v-if="pageFilter != null && pageFilter.includes('date')">Видени вагони днес</h4>
    <h4 v-if="pageFilter != null && pageFilter.includes('train')">Видени вагони на този влак</h4>
    <h4 v-if="pageFilter == null">Списък на всички видени вагони</h4>
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="events.length === 0">
        <p>Няма налични събития</p>
      </div>
      <div v-else class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Дата</th>
              <th scope="col">Вагон</th>
              <th scope="col">Влак</th>
              <th scope="col">Гара</th>
              <th scope="col">Коментар</th>
              <th scope="col">Създаден на</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="event in events">
              <th scope="row">
                <router-link
                  class="text-body"
                  :to="'/events/' + event.data.id"
                  :permissions="permissions"
                >{{ event.data.date}}</router-link>
              </th>
              <th scope="row">
                <router-link
                  class="text-body"
                  :to="'/wagons/' + event.data.wagon.id"
                >{{ event.data.wagon.number}}</router-link>
              </th>
              <td>
                <router-link
                  class="text-body"
                  :to="'/trains/' + (event.data.train ? event.data.train.data.id : '')"
                >{{event.data.train ? event.data.train.data.number : "-"}}</router-link>
              </td>
              <td>
                <router-link
                  class="text-body"
                  :to="'/stations/' + (event.data.station ? event.data.station.data.id : '')"
                >{{event.data.station ? event.data.station.data.name : "-"}}</router-link>
              </td>
              <td>
                <router-link
                  class="text-body"
                  :to="'/events/' + event.data.id"
                >{{event.data.comment ? (event.data.comment.length > 20 ? (event.data.comment.substr(0,20)).concat("...") : event.data.comment) : "-"}}</router-link>
              </td>
              <td>{{event.data.last_updated}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <Pagination :pagination="pagination" :model="model" @updatepage="updateData"></Pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "../components/Pagination";
import EventFilter from "../components/EventFilter";

export default {
  name: "EventIndex",
  props: {
    permissions: Array,
    pageFilter: String,
  },
  components: {
    Pagination,
    EventFilter,
  },
  mounted() {
    this.getData();
  },
  data: function () {
    return {
      loading: true,
      events: null,
      model: "events",
      pagination: {
        total: null,
        currentPage: null,
        lastPage: null,
      },
    };
  },
  methods: {
    updateData(value) {
      this.events = value.values;
      this.pagination = value.paginationData;
      this.loading = value.loading;
    },
    getData() {
      axios
        .get("/api/" + this.model)
        .then((response) => {
          this.events = response.data.data;
          this.pagination.currentPage = response.data.meta["current_page"];
          this.pagination.lastPage = response.data.meta["last_page"];
          this.pagination.total = response.data.meta["total"];
          this.loading = false;
        })
        .catch((error) => {
          alert("Грешка при взимането на информация");
        });
    },
    applyFilters(queryString) {
      this.model = "events" + queryString;
      if (this.pageFilter !== null) {
        this.model += "&" + this.pageFilter;
      }
      this.loading = true;
      this.getData();
    },
  },
  watch: {
    pageFilter: {
      immediate: true,
      handler(value) {
        this.model = "events";
        if (this.pageFilter != null) {
          this.model += "?" + this.pageFilter;
        }
        this.getData();
      },
    },
  },
};
</script>
