<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Създаване на статус</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="name"
          label="Име на статус"
          placeholder="Въведете име на статус..."
          :errors="errors"
          @updatefield="form.name = $event"
        />
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/statuses')">Отказ</button>
          <button class="btn btn-primary ml-3">Създаване на статус</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../components/InputField";

export default {
  name: "StatusCreate",
  components: {
    InputField
  },
  data: function() {
    return {
      form: {
        name: null,
      },
      errors: null
    };
  },
  methods: {
    submitForm() {
      axios
        .post("/api/statuses", this.form)
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
