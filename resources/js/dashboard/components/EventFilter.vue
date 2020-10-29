<template>
  <div>
    <h6 @click="toggle = !toggle" class="pt-2 ml-2 font-weight-bold text-primary">Филтри</h6>
    <div class="input-group mb-3 bg-light mt-3 p-3" v-if="toggle">
      <div class="col-sm-12 col-md-4">
        <div class="pb-2">
          <label for="date" class="ml-2 pt-2 font-weight-bold text-primary">Дата</label>
          <input type="date" id="date" class="form-control" v-model="filters.date" />
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <SelectField
          name="station"
          label="Гара"
          model="stations?pagination=0"
          @updatefield="filters.station = $event"
        ></SelectField>
      </div>
      <div class="col-sm-12 col-md-4">
        <label for="createdAt" class="ml-2 pt-2 font-weight-bold text-primary">Дата на създаване</label>
        <input type="date" id="createdAt" class="form-control" v-model="filters.createdAt" />
      </div>
    </div>
  </div>
</template>

<script>
import SelectField from "../components/SelectFieldFilter";
import _ from "lodash";

export default {
  name: "EventFilter",
  components: {
    SelectField,
  },
  data: function () {
    return {
      filters: {
        station: null,
        date: null,
        createdAt: null,
      },
      queryString: null,
      toggle: false,
    };
  },
  methods: {
    filter: _.debounce(function (e) {
      this.queryString = "?";
      if (this.filters.station !== null) {
        this.queryString += "&station_id=" + this.filters.station;
      }
      if (this.filters.date !== null && this.filters.date !== "") {
        this.queryString += "&date=" + this.filters.date;
      }
      if (this.filters.createdAt !== null && this.filters.createdAt !== "") {
        this.queryString += "&created_at=" + this.filters.createdAt;
      }
      this.$emit("applyFilters", this.queryString);
    }, 500),
  },
  watch: {
    filters: {
      deep: true,
      handler() {
        this.filter();
      },
    },
  },
};
</script>
