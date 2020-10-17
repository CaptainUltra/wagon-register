<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Промяна на събитие</h4>
      <form class="pt-4" @submit.prevent="submitForm()">
        <DatePicker
          name="date"
          label="Дата на събитие"
          :data="form.date"
          @updatefield="form.date = $event"
        />
        <InputField
          name="comment"
          label="Коментар към събитието"
          placeholder="Въведете коментар към събитието..."
          :errors="errors"
          :data="form.comment"
          @updatefield="form.comment = $event"
        />
        <label for="station" class="ml-2 pt-2 font-weight-bold text-primary">Гара</label>
        <Search id="station" model="return_station_id" route="stationsearch" placeholder="Въведете име на гара" @updateid="form.station_id = $event" :data="station"></Search>
        <label for="train" class="ml-2 pt-2 font-weight-bold text-primary">Влак</label>
        <Search id="train" model="return_train_id" route="trainsearch" placeholder="Въведете номер на влак" @updateid="form.train_id = $event" :data="train"></Search>
        <label for="wagon" class="ml-2 pt-2 font-weight-bold text-primary">Вагон</label>
        <Search id="wahon" model="return_wagon" route="wagonsearch" placeholder="Въведете номер на вагон" @updateid="form.wagon_id = $event.id" :data="wagon"></Search>
        <div class="pt-3 d-flex justify-content-end">
          <button class="btn btn-outline-danger" @click="$router.push('/events')">Отказ</button>
          <button class="btn btn-primary ml-3">Промяна на събитие</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputField from "../../components/InputField";
import Search from "../../components/Search";
import DatePicker from "../../components/DatePicker";

export default {
  name: "EventEdit",
  components: {
    InputField,
    Search,
    DatePicker
  },
  mounted() {
    axios
      .get("/api/events/" + this.$route.params.id + '?show-wagon=1')
      .then(response => {
        this.form.date = response.data.data.date;
        this.form.comment = response.data.data.comment;
        this.form.wagon_id = response.data.data.wagon ? response.data.data.wagon.id : null;
        this.wagon = response.data.data.wagon ? response.data.data.wagon.number : null;
        this.form.station_id = response.data.data.station ? response.data.data.station.data.id : null;
        this.station = response.data.data.station ? response.data.data.station.data.name : null;
        this.form.train_id = response.data.data.train ? response.data.data.train.data.id : null;
        this.train = response.data.data.train ? response.data.data.train.data.number : null;
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/events");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
  },
  data: function() {
    return {
      form: {
        date: null,
        comment: null,
        wagon_id: null,
        station_id: null,
        train_id: null,
      },
      train: null,
      station: null,
      wagon: null,
      errors: null
    };
  },
  methods: {
    submitForm()  {
      axios.patch("/api/events/" + this.$route.params.id, this.form)
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
