<template>
  <div class="input-group mb-3 bg-light mt-3 p-3">
    <div class="col-4">
      <SelectField
        name="wagontype"
        label="Серия"
        model="wagontypes?pagination=0"
        @updatefield="filters.wagonType = $event"
      ></SelectField>
      <SelectField
        name="status"
        label="Статус"
        model="statuses"
        @updatefield="filters.status = $event"
      ></SelectField>
    </div>
    <div class="col-4">
      <SelectField name="depot" label="Депо" model="depots" @updatefield="filters.depot = $event"></SelectField>
      <SelectField
        name="revisorypoint"
        label="Пункт на ревизия"
        model="revisorypoints"
        @updatefield="filters.revisoryPoint = $event"
      ></SelectField>
    </div>
    <!-- TODO: Add toolptip on how to remove date -->
    <div class="col-4">
      <div class="pb-2">
        <label for="revisoryDate" class="ml-2 pt-2 font-weight-bold text-primary">Дата ревизия</label>
        <input type="date" id="revisoryDate" class="form-control" v-model="filters.date" />
      </div>
      <label for="sort" class="ml-2 pt-2 font-weight-bold text-primary">Сортиране</label>
      <select class="form-control" id="sort" v-model="filters.sort">
        <option value="null">(без филтър)</option>
        <option value="asc">Възходящо</option>
        <option value="asc">Низходящо</option>
      </select>
    </div>
  </div>
</template>

<script>
import SelectField from "../components/SelectFieldFilter";
import _ from "lodash";

export default {
  name: "WagonFilter",
  components: {
    SelectField
  },
  data: function() {
    return {
      filters: {
        wagonType: null,
        status: null,
        depot: null,
        revisoryPoint: null,
        date: null,
        sort: null,
      },
      queryString: null
    };
  },
  methods: {
    filter: _.debounce(function(e) {
      //this.queryString = "?";
      this.queryString = "";
      if (this.filters.wagonType !== null) {
        this.queryString += "&wagon_type=" + this.filters.wagonType;
      }
      if (this.filters.status !== null) {
        this.queryString += "&status=" + this.filters.status;
      }
      if (this.filters.depot !== null) {
        this.queryString += "&depot=" + this.filters.depot;
      }
      if (this.filters.revisoryPoint !== null) {
        this.queryString += "&revisory_point=" + this.filters.revisoryPoint;
      }
      if (this.filters.date !== null) {
        this.queryString += "&date=" + this.filters.date;
      }
      if (this.filters.sort !== null) {
        this.queryString += "&sort=" + this.filters.sort;
      }
      console.log(this.queryString);
    }, 1000)
  },
  watch: {
    // wagonType: function() {this.filter()},
    // status: function() {this.filter()},
    // depot: function() {this.filter()},
    // revisoryPoint: function() {this.filter()},
    // date: function() {this.filter()},
    // sort: function() {this.filter()},
    // queryString: function() {this.filter()},
    filters: {
      deep: true,
      handler() {
        this.filter();
      }
    }
  }
};
</script>
