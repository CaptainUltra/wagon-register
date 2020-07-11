<template>
  <div class="py-2">
    <h4>Списък на всички пунктове за ревизия</h4>
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="revisoryPoints.length === 0">
        <p>Няма налични пунктове за ревизия</p>
      </div>
      <div v-else class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">№</th>
              <th scope="col">Име</th>
              <th scope="col">Съкращение</th>
              <th scope="col">Последна промяна</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="revisoryPoint in revisoryPoints">
              <th scope="row">{{ revisoryPoint.data.id}}</th>
              <td>
                <router-link
                  class="text-body"
                  :to="'/revisorypoints/' + revisoryPoint.data.id"
                  :permissions="permissions"
                >{{revisoryPoint.data.name}}</router-link>
              </td>
              <td>
                <router-link
                  class="text-body"
                  :to="'/revisorypoints/' + revisoryPoint.data.id"
                  :permissions="permissions"
                >{{revisoryPoint.data.abbreviation}}</router-link>
              </td>
              <td>{{revisoryPoint.data.last_updated}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <Pagination :pagination="pagination" model="revisorypoints" @updatepage="updateData"></Pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "../components/Pagination";

export default {
  name: "RevisoryPointIndex",
  props: ["permissions"],
  components: {
    Pagination
  },
  mounted() {
    axios
      .get("/api/revisorypoints")
      .then(response => {
        this.revisoryPoints = response.data.data;
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
      revisoryPoints: null,
      pagination: {
        total: null,
        currentPage: null,
        lastPage: null
      }
    };
  },
  methods: {
    updateData(value) {
      this.revisoryPoints = value.values;
      this.pagination = value.paginationData;
      this.loading = value.loading;
    }
  },
  computed: {}
};
</script>
