<template>
  <div class="pb-2">
    <label :for="name" class="ml-2 pt-2 font-weight-bold text-primary">{{label}}</label>
    <select
      class="form-control ml-2 w-100 border-bottom border-top-0 border-left-0 border-right-0 pb-1"
      :id="name"
      v-model="selectedOption"
      @change="changeOption"
    >
      <option value="null" disabled>Изберете...</option>
      <option v-for="modelInstance in modelData">{{modelInstance.data.name}}</option>
    </select>
  </div>
</template>

<script>
export default {
  name: "SelectField",
  props: ["name", "label", "data", "model"],
  data: function() {
    return {
      value: null,
      selectedOption: null,
      modelData: null,
      loading: true
    };
  },
  mounted() {
    axios
      .get("/api/" + this.model)
      .then(response => {
        this.modelData = response.data.data;
        this.loading = false;
        this.updateWhenLoaded();
      })
      .catch(error => {
      });
  },
  methods: {
    changeOption() {
      this.modelData.forEach(element => {
        if (element.data.name === this.selectedOption)
          this.value = element.data.id;
      });
      this.$emit("updatefield", this.value);
    },
    updateWhenLoaded() {
      if (this.data !== null && !this.loading) {
        this.value = this.data;
        this.selectedOption = this.modelData[this.data - 1].data.name;
      }
    }
  }
};
</script>
