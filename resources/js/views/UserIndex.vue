<template>
  <div class="py-4">
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="users.length === 0">
        <p>Няма налични депа</p>
      </div>
      <h4>Списък на всички депа</h4>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">№</th>
            <th scope="col">Име</th>
            <th scope="col">E-mail</th>
            <th scope="col">Регистриран</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users">
            <th scope="row">{{ user.data.id}}</th>
            <td><router-link class="text-body" :to="'/users/' + user.data.id">{{user.data.name}}</router-link></td>
            <td><router-link class="text-body" :to="'/users/' + user.data.id">{{user.data.email}}</router-link></td>
            <td>{{user.data.created_at}}</td>
          </tr>
        </tbody>
      </table>
      <Pagination :pagination="pagination" model="users" @updatepage="updateData"></Pagination>
    </div>
  </div>
</template>

<script>
import Pagination from "../components/Pagination";

export default {
  name: "UserIndex",
  components: {
    Pagination
  },
  mounted() {
    axios
      .get("/api/users")
      .then(response => {
        this.users = response.data.data;
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
      users: null,
      pagination: {
        total: null,
        currentPage: null,
        lastPage: null
      }
    };
  },
  methods: {
    updateData(value) {
      this.users = value.values;
      this.pagination = value.pagination;
      this.loading = value.loading;
    }
  }
};
</script>
