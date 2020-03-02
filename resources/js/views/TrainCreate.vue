<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Създаване на влак</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="number"
          label="Номер на влак"
          placeholder="Въведете номер на влак..."
          :errors="errors"
          @updatefield="form.number = $event"
        />
        <InputField
          name="route"
          label="Маршрут на влак"
          placeholder="Въведете маршрут на влак..."
          :errors="errors"
          @updatefield="form.route = $event"
        />
        <InputField
          name="count"
          label="Брой на вагони"
          placeholder="Въведете брой на вагоните във влака..."
          v-model="coachesCount"
          @updatefield="coachesCount = $event"
        />
        <div v-if="coachesCount > 0">
          <SelectField
            v-for="i in Number(coachesCount)"
            name="wagontypes"
            :label="'Серия вагон №' + i"
            model="wagontypes?pagination=0"
            @updatefield="updateWagonTypeArray($event, i)"
          ></SelectField>
        </div>
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/trains')">Отказ</button>
          <button class="btn btn-primary ml-3">Създаване на влак</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../components/InputField";
import SelectField from "../components/SelectField";

export default {
  name: "TrainCreate",
  components: {
    InputField,
    SelectField
  },
  data: function() {
    return {
      form: {
        number: null,
        route: null,
        wagontypes: []
      },
      coachesCount: 0,
      errors: null
    };
  },
  methods: {
    submitForm() {
      this.form.wagontypes = this.form.wagontypes.slice(0, this.coachesCount);
      axios
        .post("/api/trains", this.form)
        .then(response => {
          this.$router.push(response.data.links.self);
        })
        .catch(errors => {
          this.errors = errors.response.data.errors;
        });
    },
    updateWagonTypeArray(event, i){
        this.form.wagontypes[i-1] = event;
    }
  }
};
</script>
