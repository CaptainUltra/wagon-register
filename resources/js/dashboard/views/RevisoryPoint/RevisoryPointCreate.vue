<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Създаване на пункт за ревизия</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="name"
          label="Име на пукт за ревизия"
          placeholder="Въведете име на пункта за ревизия..."
          :errors="errors"
          @updatefield="form.name = $event"
        />
        <InputField
          name="abbreviation"
          label="Съкращение на пукт за ревизия"
          placeholder="Въведете съкращение на пункта за ревизия..."
          :errors="errors"
          @updatefield="form.abbreviation = $event"
        />
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/revisorypoints')">Отказ</button>
          <button class="btn btn-primary ml-3">Създаване на пункт за ревизия</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../../components/InputField";

export default {
  name: "RevisoryPointCreate",
  components: {
    InputField
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
    submitForm() {
      axios
        .post("/api/revisorypoints", this.form)
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
