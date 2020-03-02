<template>
  <div class="py-4">
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="stations.length === 0">
        <p>Няма налични гари</p>
      </div>
      <h4>Списък на всички гари</h4>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">№</th>
            <th scope="col">Име</th>
            <th scope="col">Последна промяна</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="station in stations">
            <th scope="row">{{ station.data.id}}</th>
            <td>
              <router-link
                class="text-body"
                :to="'/stations/' + station.data.id"
                :permissions="permissions"
              >{{station.data.name}}</router-link>
            </td>
            <td>{{station.data.last_updated}}</td>
          </tr>
        </tbody>
      </table>
      <Pagination :pagination="pagination" model="stations" @updatepage="updateData"></Pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "../components/Pagination";

export default {
  name: "StationIndex",
  props: ["permissions"],
  components: {
    Pagination
  },
  mounted() {
    axios
      .get("/api/stations")
      .then(response => {
        this.stations = response.data.data;
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
      stations: null,
      pagination: {
        total: null,
        currentPage: null,
        lastPage: null
      }
    };
  },
  methods: {
    updateData(value) {
      this.stations = value.values;
      this.pagination = value.pagination;
      this.loading = value.loading;
    }
  },
  computed: {}
};
</script>
