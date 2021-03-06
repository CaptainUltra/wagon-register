<template>
  <div class="py-2">
    <Search model="stylized_number" route="wagonsearch" placeholder="Търсене на вагон"></Search>
    <WagonFilter @applyFilters="applyFilters($event)"></WagonFilter>
    <h4>Списък на всички вагони {{pageFilter ? "с изтичаща този месец ревизия" : ""}}</h4>
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="wagons.length === 0">
        <p>Няма налични вагони</p>
      </div>
      <div v-else class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">№</th>
              <th scope="col">Серия</th>
              <th scope="col">Означение</th>
              <th scope="col">Места</th>
              <th scope="col">Гара на домуване</th>
              <th scope="col">Статус</th>
              <th scope="col">Изтичане на ревизия</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="wagon in wagons">
              <th scope="row">
                <router-link
                  class="text-body"
                  :to="'/wagons/' + wagon.data.id"
                  :permissions="permissions"
                >{{ wagon.data.stylized_number}}</router-link>
              </th>
              <td>{{wagon.data.type.data.name}}</td>
              <td>{{wagon.data.letter_index ? wagon.data.letter_index : "-" }}</td>
              <td>{{wagon.data.seats ? wagon.data.seats : "-"}}</td>
              <td>{{wagon.data.depot ? wagon.data.depot.data.name : "-"}}</td>
              <td>{{wagon.data.status.data.name}}</td>
              <td>{{wagon.data.revision_expiration_date ? wagon.data.revision_expiration_date : "-"}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <Pagination :pagination="pagination" :model="model" @updatepage="updateData"></Pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "../../components/Pagination";
import Search from "../../components/Search";
import WagonFilter from "../../components/WagonFilter";

export default {
  name: "WagonIndex",
  components: {
    Pagination,
    Search,
    WagonFilter
  },
  props: {
    permissions: Array,
    pageFilter: String
  },
  mounted() {
    if(this.pageFilter !== null)
    {
      this.model += "?" + this.pageFilter;
    }
    this.getData();
  },
  data: function() {
    return {
      loading: true,
      wagons: null,
      pagination: {
        total: null,
        currentPage: null,
        lastPage: null
      },
      model: "wagons"
    };
  },
  methods: {
    updateData(value) {
      this.wagons = value.values;
      this.pagination = value.paginationData;
      this.loading = value.loading;
    },
    getData() {
      axios
        .get("/api/" + this.model)
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
    applyFilters(queryString) {
      this.model = "wagons" + queryString;
      if(this.pageFilter !== null)
      {
      this.model += "&" + this.pageFilter;
      }
      this.loading = true;
      this.getData();
    }
  },
  watch: {
    pageFilter: {
      immediate: true,
      handler(value) {
        this.model = "wagons";
        if(this.pageFilter !== null)
        {
          this.model += "?" + this.pageFilter;
        }
        this.getData();
      }
    }
  }
};
</script>
