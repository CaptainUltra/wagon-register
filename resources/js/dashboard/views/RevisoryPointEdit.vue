<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Създаване на депо</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="name"
          label="Име на пукт за ревизия"
          placeholder="Въведете име на пункта за ревизия..."
          :errors="errors"
          :data="form.name"
          @updatefield="form.name = $event"
        />
        <InputField
          name="abbreviation"
          label="Съкращение на пукт за ревизия"
          placeholder="Въведете съкращение на пункта за ревизия..."
          :errors="errors"
          :data="form.abbreviation"
          @updatefield="form.abbreviation = $event"
        />
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/revisorypoints')">Отказ</button>
          <button class="btn btn-primary ml-3">Обновяване на пункт за ревизия</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../components/InputField";

export default {
  name: "RevisoryPointEdit",
  components: {
    InputField
  },
  mounted() {
    axios
      .get("/api/revisorypoints/" + this.$route.params.id)
      .then(response => {
        this.form = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/revisorypoints");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
  },
  data: function() {
    return {
      form: {
        name: "",
        abbreviation: ""
      },
      errors: null
    };
  },
  methods: {
    submitForm()  {
      axios.patch("/api/revisorypoints/" + this.$route.params.id, this.form)
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
