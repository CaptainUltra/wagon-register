<template>
  <div class="py-2">
    <h4>Списък на всички серии вагони</h4>
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="wagonTypes.length === 0">
        <p>Няма налични серии вагони</p>
      </div>
      <div v-else class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">№</th>
              <th scope="col">Означение</th>
              <th scope="col">Тип интериор</th>
              <th scope="col">Климатирзиран</th>
              <th scope="col">Последна промяна</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="wagonType in wagonTypes">
              <th scope="row">{{ wagonType.data.id}}</th>
              <td>
                <router-link
                  class="text-body"
                  :to="'/wagontypes/' + wagonType.data.id"
                  :permissions="permissions"
                >{{wagonType.data.name}}</router-link>
              </td>
              <td>{{wagonType.data.interior_type.data.name}}</td>
              <td>{{wagonType.data.conditioned ? "Да" : "Не"}}</td>
              <td>{{wagonType.data.last_updated}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <Pagination :pagination="pagination" model="wagontypes" @updatepage="updateData"></Pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "../components/Pagination";

export default {
  name: "WagonTypeIndex",
  props: ["permissions"],
  components: {
    Pagination
  },
  mounted() {
    axios
      .get("/api/wagontypes")
      .then(response => {
        this.wagonTypes = response.data.data;
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
      wagonTypes: null,
      pagination: {
        total: null,
        currentPage: null,
        lastPage: null
      }
    };
  },
  methods: {
    updateData(value) {
      this.wagonTypes = value.values;
      this.pagination = value.paginationData;
      this.loading = value.loading;
    }
  },
  computed: {}
};
</script>
