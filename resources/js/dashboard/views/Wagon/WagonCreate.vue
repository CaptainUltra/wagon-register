<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Създаване на вагон</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="number"
          label="Номер на вагон*"
          placeholder="Въведете цифрите на номера на вагона слято..."
          :errors="errors"
          @updatefield="form.number = $event"
        />
        <InputField
          name="letter_index"
          label="Означение"
          placeholder="Въведете означението на вагона..."
          :errors="errors"
          @updatefield="form.letter_index = $event"
        />
        <InputField
          name="v_max"
          label="Максимална скорост"
          placeholder="Въведете максималната скорост на вагона..."
          :errors="errors"
          @updatefield="form.v_max = $event"
        />
        <InputField
          name="seats"
          label="Брой на местата"
          placeholder="Въведете броя на местата във вагона..."
          :errors="errors"
          @updatefield="form.seats = $event"
        />
        <SelectField
          name="depot"
          label="Депо"
          model="depots"
          @updatefield="form.depot_id = $event"
        ></SelectField>
        <SelectField
          name="status"
          label="Статус"
          model="statuses"
          @updatefield="form.status_id = $event"
        ></SelectField>
        <SelectField
          name="revisorypoint"
          label="Пункт на ревизия"
          model="revisorypoints"
          @updatefield="form.revisory_point_id = $event"
        ></SelectField>
        <DatePicker
          name="revision_date"
          label="Дата на ревизията"
          @updatefield="form.revision_date = $event"
        />
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/wagons')">Отказ</button>
          <button class="btn btn-primary ml-3">Създаване на вагон</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../../components/InputField";
import SelectField from "../../components/SelectField";
import DatePicker from "../../components/DatePicker";

export default {
  name: "WagonCreate",
  components: {
    InputField,
    SelectField,
    DatePicker
  },
  data: function() {
    return {
      form: {
        number: null,
        letter_index: "",
        v_max: null,
        seats: null,
        depot_id: null,
        status_id: null,
        revisory_point_id: null,
        revision_date:null,
      },
      errors: null
    };
  },
  methods: {
    submitForm() {
      axios
        .post("/api/wagons", this.form)
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
