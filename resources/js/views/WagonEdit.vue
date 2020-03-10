<template>
  <div class="py-4">
    <div>
      <h4 class="pl-2">Промяна на данните за вагон</h4>
      <div v-if="loading">
        <p>Зареждане...</p>
      </div>
      <div v-else>
        <form class="pt-4" @submit.prevent="submitForm()">
          <InputField
            name="number"
            label="Номер на вагон*"
            placeholder="Въведете цифрите на номера на вагона слято..."
            :errors="errors"
            :data="form.number"
            @updatefield="form.number = $event"
          />
          <InputField
            name="letter_index"
            label="Означение"
            placeholder="Въведете означението на вагона..."
            :errors="errors"
            :data="form.letter_index"
            @updatefield="form.letter_index = $event"
          />
          <InputField
            name="v_max"
            label="Максимална скорост"
            placeholder="Въведете максималната скорост на вагона..."
            :errors="errors"
            :data="form.v_max"
            @updatefield="form.v_max = $event"
          />
          <InputField
            name="seats"
            label="Брой на местата"
            placeholder="Въведете броя на местата във вагона..."
            :errors="errors"
            :data="form.seats"
            @updatefield="form.seats = $event"
          />
          <div v-if="loading">
            <p>Зареждане...</p>
          </div>
          <div v-else>
            <SelectField
              name="depot"
              label="Депо"
              model="depots"
              :data="form.depot_id"
              @updatefield="form.depot_id = $event"
            ></SelectField>
            <SelectField
              name="status"
              label="Статус"
              model="statuses"
              :data="form.status_id"
              @updatefield="form.status_id = $event"
            ></SelectField>
            <SelectField
              name="revisorypoint"
              label="Пункт на ревизия"
              model="revisorypoints"
              :data="form.revisory_point_id"
              @updatefield="form.revisory_point_id = $event"
            ></SelectField>
          </div>
          <InputField
            name="revision_date"
            label="Дата на ревизията"
            placeholder="Въведете датата на ревизия на вагона..."
            :errors="errors"
            :data="form.revision_date"
            @updatefield="form.revision_date = $event"
          />
          <div class="pt-3 d-flex justify-content-end">
            <button class="btn btn-outline-danger" @click="$router.push('/wagons')">Отказ</button>
            <button class="btn btn-primary ml-3">Промяна на вагон</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import InputField from "../components/InputField";
import SelectField from "../components/SelectField";

export default {
  name: "WagonEdit",
  components: {
    InputField,
    SelectField
  },
  mounted() {
    axios
      .get("/api/wagons/" + this.$route.params.id)
      .then(response => {
        this.form.number = response.data.data.number;
        this.form.letter_index = response.data.data.letter_index;
        this.form.v_max = response.data.data.v_max;
        this.form.seats = response.data.data.seats;
        this.depot = response.data.data.depot;
        this.updateDepot();
        this.status = response.data.data.status;
        this.updateSatatus();
        this.revisory_point = response.data.data.revisory_point;
        this.updateRevisoryPoint();
        this.form.revision_date = response.data.data.revision_date;
        this.loading = false;
      })
      .catch(error => {
        if (error.response.status === 404) {
          this.$router.push("/wagons");
        } else {
          alert("Грешка при взимането на информация");
        }
      });
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
        revision_date: null
      },
      depot: null,
      status: null,
      revisory_point: null,
      errors: null,
      loading: true
    };
  },
  methods: {
    submitForm() {
      axios
        .patch("/api/wagons/" + this.$route.params.id, this.form)
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
    },
    updateDepot() {
      if (this.depot != null) {
        this.form.depot_id = this.depot.data.id;
      }
    },
    updateRevisoryPoint() {
      if (this.revisory_point != null) {
        this.form.revisory_point_id = this.revisory_point.data.id;
      }
    },
    updateSatatus() {
      if (this.status != null) {
        this.form.status_id = this.status.data.id;
      }
    }
  }
};
</script>
