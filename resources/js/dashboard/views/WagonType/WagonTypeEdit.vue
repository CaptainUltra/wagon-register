<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Промяна на депо на депо</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="name"
          label="Означение на серия"
          placeholder="Въведете означение на серията..."
          :errors="errors"
          :data="form.name"
          @updatefield="form.name = $event"
        />
        <InputField
          name="revision_valid_for"
          label="Валидност на ревизия"
          placeholder="Валидност на ревизия за вагон от тази серия..."
          :errors="errors"
          :data="form.revision_valid_for"
          @updatefield="form.revision_valid_for = $event"
        />
        <div class="pb-2">
          <label for="conditioned" class="ml-2 pt-2 font-weight-bold text-primary">Климатизиран</label>
          <select
            class="form-control ml-2 w-100 border-bottom border-top-0 border-left-0 border-right-0 pb-1"
            name="conditioned"
            id="conditioned"
            v-model="selectedConditioned"
            @change="changeConditioned"
          >
            <option value="null" disabled>Изберете...</option>
            <option value="true">Да</option>
            <option value="false">Не</option>
          </select>
        </div>
        <div v-if="loading">
          <p>Зареждане...</p>
        </div>
        <div v-else>
          <SelectField
            name="interiortype"
            label="Тип интериор"
            model="interiortypes"
            :data="form.interior_type.data.id"
            @updatefield="form.interior_type_id = $event"
          ></SelectField>
        </div>
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/wagontypes')">Отказ</button>
          <button class="btn btn-primary ml-3">Промяна на серия</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../../components/InputField";
import SelectField from "../../components/SelectField";

export default {
  name: "WagonTypeEdit",
  components: {
    InputField,
    SelectField
  },
  mounted() {
    axios
      .get("/api/wagontypes/" + this.$route.params.id)
      .then(response => {
        this.form.name = response.data.data.name;
        this.form.interior_type = response.data.data.interior_type;
        this.form.conditioned = response.data.data.conditioned;
        this.form.revision_valid_for = response.data.data.revision_valid_for;
        this.form.interior_type_id = this.form.interior_type.data.id;
        this.selectedConditioned = this.form.conditioned ? "true" : "false";
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/wagontypes");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
  },
  data: function() {
    return {
      form: {
        name: "",
        conditioned: null,
        interior_type: null,
        interior_type_id: null
      },
      selectedConditioned: null,
      errors: null,
      loading: true
    };
  },
  methods: {
    submitForm() {
      axios
        .patch("/api/wagontypes/" + this.$route.params.id, this.form)
        .then(response => {
          this.$router.push(response.data.links.self);
        })
        .catch(errors => {
          this.errors = errors.response.data.errors;
        });
    },
    changeConditioned() {
      if (this.selectedConditioned === "true") {
        this.form.conditioned = true;
      } else {
        this.form.conditioned = false;
      }
    }
  }
};
</script>
