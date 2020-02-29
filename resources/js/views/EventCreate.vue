<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Създаване на събитие за вагон</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <InputField
          name="date"
          label="Дата на събитие"
          placeholder="Въведете дата на събитие..."
          :errors="errors"
          @updatefield="form.date = $event"
        />
        <InputField
          name="comment"
          label="Коментар към събитието"
          placeholder="Въведете коментар към събитието..."
          :errors="errors"
          @updatefield="form.comment = $event"
        />
        <label for="station" class="ml-2 pt-2 font-weight-bold text-primary">Гара</label>
        <Search id="station" model="return_station_id" route="stationsearch" placeholder="Въведете име на гара" @updateid="form.station_id = $event"></Search>
        <label for="train" class="ml-2 pt-2 font-weight-bold text-primary">Влак</label>
        <Search id="train" model="return_train_id" route="trainsearch" placeholder="Въведете номер на влак" @updateid="form.train_id = $event"></Search>
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/wagons/' + wagonId)">Отказ</button>
          <button class="btn btn-primary ml-3">Създаване на събитие</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../components/InputField";
import Search from "../components/Search";

export default {
  name: "EventCreate",
  props: ["wagonId"],
  components: {
    InputField,
    Search
  },
  data: function() {
    return {
      form: {
        date: null,
        comment: null,
        wagon_id: this.wagonId,
        station_id: null,
        train_id: null,
      },
      errors: null
    };
  },
  methods: {
    submitForm() {
      axios
        .post("/api/events", this.form)
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
