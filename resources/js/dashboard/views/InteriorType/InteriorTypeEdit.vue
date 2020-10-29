<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Промяна на тип интериор</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="name"
          label="Име на тип"
          placeholder="Въведете име на типа интериор..."
          :errors="errors"
          :data="form.name"
          @updatefield="form.name = $event"
        />
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/interiortypes')">Отказ</button>
          <button class="btn btn-primary ml-3">Промяна на тип</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../../components/InputField";

export default {
  name: "InteriorTypeEdit",
  components: {
    InputField
  },
  mounted() {
    axios
      .get("/api/interiortypes/" + this.$route.params.id)
      .then(response => {
        this.form = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/interiortypes");
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
      axios.patch("/api/interiortypes/" + this.$route.params.id, this.form)
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
