<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Маркиране на вагони като видени</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <label for="wagon" class="ml-2 pt-2 font-weight-bold text-primary">Номер на вагон</label>
        <Search
          id="wagon"
          model="return_wagon"
          route="wagonsearch"
          placeholder="Въведете номер на вагон..."
          @updateid="updateWagons($event)"
        ></Search>
        <div v-if="wagons.length > 0">
          <h5 class="pl-2 pt-2">Избрани вагони:</h5>
          <ul class="list-group">
            <li v-for="wagon in wagons" class="list-group-item">
              <button type="button" class="btn btn-sm" @click="removeWagon(wagon)">X</button>
              {{wagon}}
            </li>
          </ul>
        </div>
        <label for="station" class="ml-2 pt-2 font-weight-bold text-primary">Гара</label>
        <Search
          id="station"
          model="return_station_id"
          route="stationsearch"
          placeholder="Въведете име на гара"
          @updateid="station_id = $event"
        ></Search>
        <label for="train" class="ml-2 pt-2 font-weight-bold text-primary">Влак</label>
        <Search
          id="train"
          model="return_train_id"
          route="trainsearch"
          placeholder="Въведете номер на влак"
          @updateid="train_id = $event"
        ></Search>
        <InputField
          name="date"
          label="Дата на събитие"
          placeholder="Въведете дата на събитие..."
          :errors="errors"
          @updatefield="date = $event"
        />
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/')">Отказ</button>
          <button class="btn btn-primary ml-3">Отбележи видени</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../components/InputField";
import Search from "../components/Search";

export default {
  name: "MarkWagonsAsSeen",
  props: ["wagonId"],
  components: {
    InputField,
    Search
  },
  data: function() {
    return {
      date: null,
      station_id: null,
      train_id: null,
      wagons: [],
      wagons_id: [],
      errors: null
    };
  },
  methods: {
    submitForm() {
      this.wagons_id.forEach(element => {
        let form = {
          wagon_id: element,
          date: this.date,
          station_id: this.station_id,
          train_id: this.train_id
        };
        axios
          .post("/api/events", form)
          .then(response => {})
          .catch(errors => {
            this.errors = errors.response.data.errors;
          });
      });
      if (this.errors === null) {
        this.$router.push("/events/today");
      }
    },
    updateWagons(event) {
      //If the id is not present in array only then push it
      let id = this.wagons_id.indexOf(event.id);
      if (id === -1) {
        this.wagons_id.push(event.id);
        this.wagons.push(event.stylized_number);
      }
    },
    removeWagon(wagon) {
      let id = this.wagons.indexOf(wagon);
      if (id > -1) {
        this.wagons.splice(id, 1);
        this.wagons_id.splice(id, 1);
      }
    }
  }
};
</script>
