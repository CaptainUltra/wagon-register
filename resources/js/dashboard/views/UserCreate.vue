<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Създаване на потребител</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="name"
          label="Име на потребител"
          placeholder="Въведете име на потребител..."
          :errors="errors"
          @updatefield="form.name = $event"
        />
        <InputField
          name="email"
          label="E-mail на потребител"
          placeholder="Въведете e-mail на потребител..."
          :errors="errors"
          @updatefield="form.email = $event"
        />
        <InputField
          name="password"
          label="Парола на потребител"
          placeholder="Въведете парола на потребител..."
          :errors="errors"
          @updatefield="form.password = $event"
        />
        <CheckboxModal @closemodal="form.roles = $event" label="Задаване на роли на потребителя" name="Роли на потребителя" model="roles" :data="roles"></CheckboxModal>
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/users')">Отказ</button>
          <button class="btn btn-primary ml-3">Създаване на потребител</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../components/InputField";
import CheckboxModal from "../components/CheckboxModal";

export default {
  name: "UserCreate",
  components: {
    InputField,
    CheckboxModal
  },
  data: function() {
    return {
      form: {
        name: null,
        email: null,
        password: null,
        roles: []
      },
      roles:[],
      loading: true,
      errors: null
    };
  },
  methods: {
    submitForm() {
      axios
        .post("/api/users", this.form)
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
