<template>
  <div class="position-relative pb-2">
    <label :for="name" class="ml-2 pt-2 font-weight-bold position-absolute text-primary">{{ label }}</label>
    <input
      type="date"
      :id="name"
      class="pt-5 ml-2 w-100 border-bottom border-top-0 border-left-0 border-right-0 pb-1"
      v-model="value"
      @input="updateField()"
    />
  </div>
</template>

<script>
export default {
  name: "DatePicker",
  props: ["name", "label", "data"],
  data: function() {
    return {
      value: "",
      intialDataSet: false
    };
  },
  mounted() {
    if (this.data != null) {
      this.setValue(this.data);
    }
  },
  methods: {
    updateField() {
      this.$emit("updatefield", this.value);
    },
    setValue(date) {
      let newDate = date.substring(6, 10);
      newDate = newDate.concat("-", date.substring(3, 5));
      newDate = newDate.concat("-", date.substring(0, 2));
      this.value = newDate;
      this.initialDataSet = true;
    }
  },
  watch: {
    data: function(val) {
      if (!this.initialDataSet) {
        this.setValue(val);
      }
    }
  }
};
</script>
