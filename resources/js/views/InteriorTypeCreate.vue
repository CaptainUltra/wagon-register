<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Създаване на тип интериор</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="name"
          label="Име на тип"
          placeholder="Въведете име на типа интериор..."
          :errors="errors"
          @updatefield="form.name = $event"
        />
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/interiortypes')">Отказ</button>
          <button class="btn btn-primary ml-3">Създаване на тип</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../components/InputField";

export default {
  name: "InteriorTypeCreate",
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
        .post("/api/interiortypes", this.form)
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
