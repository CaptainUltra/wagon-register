<template>
  <div class="py-2">
    <Search model="number" placeholder="Търсене на влак" route="trainsearch"></Search>
    <h4>Списък на всички влакове</h4>
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="trains.length === 0">
        <p>Няма налични влакове</p>
      </div>
      <div v-else class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">№</th>
              <th scope="col">Маршрут</th>
              <th scope="col">Последна промяна</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="train in trains">
              <th scope="row">
                <router-link
                  class="text-body"
                  :to="'/trains/' + train.data.id"
                  :permissions="permissions"
                >{{train.data.number}}</router-link>
              </th>
              <td>
                <router-link
                  class="text-body"
                  :to="'/trains/' + train.data.id"
                  :permissions="permissions"
                >{{train.data.route}}</router-link>
              </td>
              <td>{{train.data.last_updated}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <Pagination :pagination="pagination" model="trains" @updatepage="updateData"></Pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "../../components/Pagination";
import Search from "../../components/Search";

export default {
  name: "TrainIndex",
  props: ["permissions"],
  components: {
    Pagination,
    Search
  },
  mounted() {
    axios
      .get("/api/trains")
      .then(response => {
        this.trains = response.data.data;
        this.pagination.currentPage = response.data.meta["current_page"];
        this.pagination.lastPage = response.data.meta["last_page"];
        this.pagination.total = response.data.meta["total"];
        this.loading = false;
      })
      .catch(error => {
        alert("Грешка при взимането на информация");
      });
  },
  data: function() {
    return {
      loading: true,
      trains: null,
      pagination: {
        total: null,
        currentPage: null,
        lastPage: null
      }
    };
  },
  methods: {
    updateData(value) {
      this.trains = value.values;
      this.pagination = value.paginationData;
      this.loading = value.loading;
    }
  },
  computed: {}
};
</script>
