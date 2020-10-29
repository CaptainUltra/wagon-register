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
          <p v-if="model === 'return_train_id'" class="text-body"  v-on:click="$emit('updateid', result.data.id)">{{ result.data.number}}</p>
          <p v-if="model === 'return_station_id'" class="text-body" v-on:click="$emit('updateid', result.data.id)">{{ result.data.name}}</p>
          <p v-if="model === 'return_wagon'" class="text-body" v-on:click="$emit('updateid', {id: result.data.id, stylized_number: result.data.stylized_number})">{{ result.data.stylized_number}}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from "lodash";

export default {
  name: "Search",
  props: ["model", "placeholder", "route", 'data'],
  mounted(){
    if(this.data !== null)
    {
      this.searchTerm = this.data;
    }
  },
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
  },
  watch: {
    data: function(val) {
      this.searchTerm = val;
    }
  }
};
</script>

<style scoped>
</style>