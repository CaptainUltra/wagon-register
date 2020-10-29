<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Данни за потребител</h4>
      <div v-if="loading" class="pl-2">
        <p>Зареждане...</p>
      </div>
      <div v-else class="pl-2 pt-2">
        <p>
          <b>№:</b>
          {{user.id}}
        </p>
        <p>
          <b>Име:</b>
          {{user.name}}
        </p>
        <p>
          <b>E-mail:</b>
          {{user.email}}
        </p>
        <p>
          <b>Регистриран на:</b>
          {{user.created_at}}
        </p>
        <div class="pt-3 d-flex justify-content-between">
          <a href="#" @click="$router.back()">< Назад</a>
          <div class="justify-content-end position-relative">
            <CheckboxModal
              v-on:closemodal="updateRoles($event)"
              label="Промяна на роли на потребителя"
              name="Роли на потребителя"
              model="roles"
              :data="roles"
              v-if="userHasPermission('user-update')"
            ></CheckboxModal>
            <button
              class="btn btn-outline-danger ml-3 mr-4"
              @click="modal = !modal"
              v-if="userHasPermission('event-delete')"
            >Изтриване</button>
            <div v-if="modal" class="position-absolute bg-dark rounded-lg p-4">
              <p
                class="text-white"
              >Сигурни ли сте, че искате да изтриете този потребител? Това действие е необратимо и всички записи свързани с този потребител също ще бъдат изтрити!</p>
              <div class="d-flex justify-content-end">
                <button @click="modal = !modal" class="btn btn-success">Отказ</button>
                <button @click="destroy" class="btn btn-danger ml-3">Изтриване</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CheckboxModal from "../../components/CheckboxModal";

export default {
  name: "UserShow",
  props: ["permissions"],
  components: {
    CheckboxModal
  },
  mounted() {
    axios
      .get("/api/users/" + this.$route.params.id + "?show-roles=1")
      .then(response => {
        this.user = response.data.data;
        this.loadRoles();
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/users");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
  },
  data: function() {
    return {
      loading: true,
      modal: false,
      user: null,
      roles: null,
      form: {
        roles: null
      }
    };
  },
  methods: {
    destroy() {
      axios
        .delete("/api/users/" + this.$route.params.id)
        .then(response => {
          this.$router.push("/users");
        })
        .catch(error => {
          alert("Грешка при изтриването!");
        });
    },
    loadRoles() {
      var roles = [];
      this.user.roles.forEach(element => {
        roles.push(element.data.id);
      });
      this.roles = roles;
    },
    updateRoles(event) {
      this.form.roles = event;
      axios
        .patch("/api/users/" + this.$route.params.id, this.form)
        .then(response => {
          this.$router.push("/users");
        })
        .catch(errors => {
          this.errors = errors.response.data.errors;
        });
    },
    userHasPermission(permission) {
      var flag = false;
      this.permissions.forEach(element => {
        if (element == permission) {
          flag = true;
          return false;
        }
      });
      return flag;
    }
  }
};
</script>
