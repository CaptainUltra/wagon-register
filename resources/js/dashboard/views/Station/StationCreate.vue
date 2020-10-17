<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Създаване на гара</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="name"
          label="Име на гара"
          placeholder="Въведете име на гара..."
          :errors="errors"
          @updatefield="form.name = $event"
        />
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/stations')">Отказ</button>
          <button class="btn btn-primary ml-3">Създаване на гара</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../../components/InputField";

export default {
  name: "StationCreate",
  components: {
    InputField
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
    submitForm() {
      axios
        .post("/api/stations", this.form)
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
