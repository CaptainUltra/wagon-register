<template>
  <div class="py-4">
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="statuses.length === 0">
        <p>Няма налични сатуси</p>
      </div>
      <h4>Списък на всички статуси</h4>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">№</th>
            <th scope="col">Име</th>
            <th scope="col">Последна промяна</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="status in statuses">
            <th scope="row">{{ status.data.id}}</th>
            <td>
              <router-link
                class="text-body"
                :to="'/statuses/' + status.data.id"
                :permissions="permissions"
              >{{status.data.name}}</router-link>
            </td>
            <td>{{status.data.last_updated}}</td>
          </tr>
        </tbody>
      </table>
      <Pagination :pagination="pagination" model="statuses" @updatepage="updateData"></Pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "../components/Pagination";

export default {
  name: "StatusIndex",
  props: ["permissions"],
  components: {
    Pagination
  },
  mounted() {
    axios
      .get("/api/statuses")
      .then(response => {
        this.statuses = response.data.data;
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
      statuses: null,
      pagination: {
        total: null,
        currentPage: null,
        lastPage: null
      }
    };
  },
  methods: {
    updateData(value) {
      this.statuses = value.values;
      this.pagination = value.paginationData;
      this.loading = value.loading;
    }
  }
};
</script>
