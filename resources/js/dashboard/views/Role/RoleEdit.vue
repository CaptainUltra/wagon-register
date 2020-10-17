<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Промяна на роля</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="name"
          label="Име на роля"
          placeholder="Въведете име на роля..."
          :errors="errors"
          :data="form.name"
          @updatefield="form.name = $event"
        />
        <InputField
          name="slug"
          label="Съкръщение на роля"
          placeholder="Във формат име-role..."
          :errors="errors"
          :data="form.slug"
          @updatefield="form.slug = $event"
        />
        <CheckboxModal
          @closemodal="form.permissions = $event"
          label="Задаване на разрешения на ролята"
          name="Разрешения на ролята"
          model="permissions"
          :data="permissions"
        ></CheckboxModal>
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/roles')">Отказ</button>
          <button class="btn btn-primary ml-3">Промяна на роля</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../../components/InputField";
import CheckboxModal from "../../components/CheckboxModal";

export default {
  name: "RoleEdit",
  components: {
    InputField,
    CheckboxModal
  },
  mounted() {
    axios
      .get("/api/roles/" + this.$route.params.id + "?show-permissions=1")
      .then(response => {
        this.form = response.data.data;
        this.updatePermissions();
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/roles");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
  },
  data: function() {
    return {
      form: {
        name: null,
        slug: null,
        permissions: []
      },
      loading: true,
      permissions: [],
      errors: null
    };
  },
  methods: {
    submitForm() {
      axios
        .patch("/api/roles/" + this.$route.params.id, this.form)
        .then(response => {
          this.$router.push(response.data.links.self);
        })
        .catch(errors => {
          this.errors = errors.response.data.errors;
        });
    },
    updatePermissions() {
      var permissions = [];
      this.form.permissions.forEach(element => {
        permissions.push(element.data.id);
      });
      this.permissions = permissions;
    }
  }
};
</script>
