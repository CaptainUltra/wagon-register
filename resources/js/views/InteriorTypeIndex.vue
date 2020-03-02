<template>
  <div class="py-4">
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="interiorTypes.length === 0">
        <p>Няма налични типове интериори</p>
      </div>
      <h4>Списък на всички типове интериори</h4>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">№</th>
            <th scope="col">Име</th>
            <th scope="col">Последна промяна</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="interiorType in interiorTypes">
            <th scope="row">{{ interiorType.data.id}}</th>
            <td>
              <router-link
                class="text-body"
                :to="'/interiortypes/' + interiorType.data.id"
                :permissions="permissions"
              >{{interiorType.data.name}}</router-link>
            </td>
            <td>{{interiorType.data.last_updated}}</td>
          </tr>
        </tbody>
      </table>
      <Pagination :pagination="pagination" model="interiortypes" @updatepage="updateData"></Pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "../components/Pagination";

export default {
  name: "InteriorTypeIndex",
  props: ["permissions"],
  components: {
    Pagination
  },
  mounted() {
    axios
      .get("/api/interiortypes")
      .then(response => {
        this.interiorTypes = response.data.data;
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
      interiorTypes: null,
      pagination: {
        total: null,
        currentPage: null,
        lastPage: null
      }
    };
  },
  methods: {
    updateData(value) {
      this.interiorTypes = value.values;
      this.pagination = value.pagination;
      this.loading = value.loading;
    }
  },
  computed: {}
};
</script>
