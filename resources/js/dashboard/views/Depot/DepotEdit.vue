<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Промяна на депо на депо</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="name"
          label="Име на депо"
          placeholder="Въведете име на депо..."
          :errors="errors"
          :data="form.name"
          @updatefield="form.name = $event"
        />
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/depots')">Отказ</button>
          <button class="btn btn-primary ml-3">Промяна на депо</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../../components/InputField";

export default {
  name: "DepotEdit",
  components: {
    InputField
  },
  mounted() {
    axios
      .get("/api/depots/" + this.$route.params.id)
      .then(response => {
        this.form = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/depots");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
  },
  data: function() {
    return {
      form: {
        name: ""
      },
      errors: null
    };
  },
  methods: {
    submitForm()  {
      axios.patch("/api/depots/" + this.$route.params.id, this.form)
        .then(response => {
            this.$router.push(response.data.links.self);
        })
        .catch(errors => {
          this.errors = errors.response.data.errors;
        });
    }
  }
};
</script>
