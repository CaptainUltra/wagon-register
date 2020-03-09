<template>
  <div class="py-4">
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="depots.length === 0">
        <p>Няма налични депа</p>
      </div>
      <h4>Списък на всички депа</h4>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">№</th>
            <th scope="col">Име</th>
            <th scope="col">Последна промяна</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="depot in depots">
            <th scope="row">{{ depot.data.id}}</th>
            <td>
              <router-link
                class="text-body"
                :to="'/depots/' + depot.data.id"
                :permissions="permissions"
              >{{depot.data.name}}</router-link>
            </td>
            <td>{{depot.data.last_updated}}</td>
          </tr>
        </tbody>
      </table>
      <Pagination :pagination="pagination" model="depots" @updatepage="updateData"></Pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "../components/Pagination";

export default {
  name: "DepotIndex",
  props: ["permissions"],
  components: {
    Pagination
  },
  mounted() {
    axios
      .get("/api/depots")
      .then(response => {
        this.depots = response.data.data;
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
      depots: null,
      pagination: {
        total: null,
        currentPage: null,
        lastPage: null
      }
    };
  },
  methods: {
    updateData(value) {
      this.depots = value.values;
      this.pagination = value.paginationData;
      this.loading = value.loading;
    }
  },
  computed: {}
};
</script>
