<template>
  <div class="py-4">
    <Search></Search>
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="wagons.length === 0">
        <p>Няма налични вагони</p>
      </div>
      <h4>Списък на всички вагони</h4>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">№</th>
            <th scope="col">Серия</th>
            <th scope="col">Буквено означение</th>
            <th scope="col">Места</th>
            <th scope="col">Гара на домуване</th>
            <th scope="col">Последна промяна</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="wagon in wagons">
            <th scope="row"><router-link class="text-body" :to="'/wagons/' + wagon.data.id">{{ wagon.data.stylized_number}}</router-link></th>
            <td>{{wagon.data.type.data.name}}</td>
            <td>{{wagon.data.letter_index }}</td>
            <td>{{wagon.data.seats}}</td>
            <td>{{wagon.data.depot ? wagon.data.depot.data.name : "-"}}</td>
            <td>{{wagon.data.last_updated}}</td>
          </tr>
        </tbody>
      </table>
      <Pagination :pagination="pagination" model="wagons" @updatepage="updateData"></Pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "../components/Pagination";
import Search from "../components/Search";

export default {
  name: "WagonIndex",
  components: {
    Pagination,
    Search
  },
  mounted() {
    axios
      .get("/api/wagons")
      .then(response => {
        this.wagons = response.data.data;
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
      wagons: null,
      pagination: {
        total: null,
        currentPage: null,
        lastPage: null
      }
    };
  },
  methods: {
    updateData(value) {
      this.wagons = value.values;
      this.pagination = value.pagination;
      this.loading = value.loading;
    }
  },
  computed: {
    
  }
};
</script>
