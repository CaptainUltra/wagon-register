<template>
  <div>
    <div
      v-if="focus"
      @click="focus = false"
    ></div>

    <div>
      <input
        type="text"
        class="form-control"
        :placeholder="placeholder"
        id="searchTerm"
        v-model="searchTerm"
        @input="search"
        @focus="focus = true"
      />

      <div
        v-if="focus && searchTerm != 0"
        class="bg-light rounded-lg p-4"
      >
        <div v-if="results == 0 && searchTerm != 0">Не са намерени резултати за '{{ searchTerm }}'</div>
        <div v-for="result in results" @click="focus = false">
          <router-link  v-if="model === 'stylized_number'" class="text-body" :to="result.links.self">{{ result.data.stylized_number}}</router-link>
          <router-link  v-if="model === 'number'" class="text-body" :to="result.links.self">{{ result.data.number}}</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from "lodash";

export default {
  name: "Search",
  props: ["model", "placeholder", "route"],
  data: function() {
    return {
      searchTerm: "",
      focus: false,
      results: []
    };
  },
  methods: {
    search: _.debounce(function(e) {
      if (this.searchTerm.length < 3) {
        return;
      }
      axios
        .post("/api/" + this.route, { searchTerm: this.searchTerm })
        .then(response => {
          this.results = response.data.data;
        })
        .catch(error => {
          console.log(error.response);
        });
    }, 300)
  }
};
</script>

<style scoped>
</style>