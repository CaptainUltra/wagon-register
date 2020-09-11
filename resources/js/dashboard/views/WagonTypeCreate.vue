<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Създаване на серия вагони</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="name"
          label="Означение на серия"
          placeholder="Въведете означение на серията..."
          :errors="errors"
          @updatefield="form.name = $event"
        />
        <InputField
          name="revision_valid_for"
          label="Валидност на ревизия"
          placeholder="Валидност на ревизия за вагон от тази серия..."
          :errors="errors"
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
        <SelectField
          name="interiortype"
          label="Тип интериор"
          model="interiortypes"
          @updatefield="form.interior_type_id = $event"
        ></SelectField>
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/wagontypes')">Отказ</button>
          <button class="btn btn-primary ml-3">Създаване на серия</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../components/InputField";
import SelectField from "../components/SelectField";

export default {
  name: "WagonTypeCreate",
  components: {
    InputField,
    SelectField
  },

  data: function() {
    return {
      form: {
        name: "",
        conditioned: null,
        interior_type_id: null,
        revision_valid_for: null
      },
      selectedConditioned: null,
      errors: null
    };
  },
  methods: {
    submitForm() {
      axios
        .post("/api/wagontypes", this.form)
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
