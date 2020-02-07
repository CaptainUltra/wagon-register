<template>
  <div class="position-relative pb-2">
    <label :for="name" class="ml-2 pt-2 font-weight-bold position-absolute text-primary">{{ label }}</label>
    <input
      type="text"
      :id="name"
      class="pt-5 ml-2 w-100 border-bottom border-top-0 border-left-0 border-right-0 pb-1"
      :placeholder="placeholder"
      v-model="value"
      @input="updateField()"
    />
    <p class="text-danger ml-2 pt-1" v-text="errorMessage()"></p>
  </div>
</template>

<script>
export default {
  name: "InputField",
  props: ["name", "label", "placeholder", "errors", "data"],
  data: function() {
    return {
      value: ""
    };
  },
  computed: {
    hasError: function ()
    {
      return this.errors && this.errors[this.name] && this.errors[this.name].length > 0;
    }
  },
  methods: {
    updateField() {
      this.clearErrors(this.name);
      this.$emit("updatefield", this.value);
    },
    errorMessage() {
      if (this.hasError) {
        return this.errors[this.name][0];
      }
    },
    clearErrors() {
      if (this.hasError) {
        this.errors[this.name] = null;
      }
    }
  },
  watch: {
    data: function(val) {
      this.value = val;
    }
  }
};
</script>
