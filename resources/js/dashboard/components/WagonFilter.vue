<template>
  <div>
    <h6 @click="toggle = !toggle" class="pt-2 ml-2 font-weight-bold text-primary">Филтри</h6>
    <div class="input-group mb-3 bg-light mt-3 p-3" v-if="toggle">
      <div class="col-sm-12 col-md-4">
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
      <div class="col-sm-12 col-md-4">
        <SelectField name="depot" label="Депо" model="depots" @updatefield="filters.depot = $event"></SelectField>
        <SelectField
          name="revisorypoint"
          label="Пункт на ревизия"
          model="revisorypoints"
          @updatefield="filters.revisoryPoint = $event"
        ></SelectField>
      </div>
      <!-- TODO: Add toolptip on how to remove date -->
      <div class="col-sm-12 col-md-4">
        <div class="pb-2">
          <label for="revisoryDate" class="ml-2 pt-2 font-weight-bold text-primary">Дата ревизия</label>
          <input type="date" id="revisoryDate" class="form-control" v-model="filters.revisionDate" />
        </div>
        <label for="sort" class="ml-2 pt-2 font-weight-bold text-primary">Сортиране</label>
        <select class="form-control" id="sort" v-model="filters.sort">
          <option value="null">(без филтър)</option>
          <option value="asc">Възходящо</option>
          <option value="desc">Низходящо</option>
        </select>
      </div>
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
        revisionDate: null,
        sort: null
      },
      queryString: null,
      toggle: false
    };
  },
  methods: {
    filter: _.debounce(function(e) {
      this.queryString = "?";
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
      if (
        this.filters.revisionDate !== null &&
        this.filters.revisionDate !== ""
      ) {
        this.queryString += "&revision_date=" + this.filters.revisionDate;
      }
      if (this.filters.sort !== null && this.filters.sort !== "null") {
        this.queryString += "&sort=" + this.filters.sort;
      }
      this.$emit("applyFilters", this.queryString);
    }, 500)
  },
  watch: {
    filters: {
      deep: true,
      handler() {
        this.filter();
      }
    }
  }
};
</script>
