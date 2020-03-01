<template>
  <div class="py-4">
    <div v-if="loading">Зареждане</div>
    <div v-else>
      <div v-if="roles.length === 0">
        <p>Няма налични роли</p>
      </div>
      <h4>Списък на всички роли</h4>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">№</th>
            <th scope="col">Име</th>
            <th scope="col">Последна промяна</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="role in roles">
            <th scope="row">{{ role.data.id}}</th>
            <td><router-link class="text-body" :to="'/roles/' + role.data.id">{{role.data.name}}</router-link></td>
            <td>{{role.data.last_updated}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>

export default {
  name: "RoleIndex",
  mounted() {
    axios
      .get("/api/roles")
      .then(response => {
        this.roles = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        alert("Грешка при взимането на информация");
      });
  },
  data: function() {
    return {
      loading: true,
      roles: null,
    };
  }
};
</script>
