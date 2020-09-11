<template>
  <div class="position-relative pb-2">
    <button
      type="button"
      class="btn btn-primary"
      data-toggle="modal"
      data-target="#modal"
    >{{label}}</button>
    <div
      class="modal fade"
      id="modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modalTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">{{name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div v-if="loading">Зареждане</div>
            <div class="form-check" v-for="item in itemsData">
              <input
                class="form-check-input"
                type="checkbox"
                :value="item.data.id"
                :id="item.data.id"
                v-model="selectedArray"
              />
              <label class="form-check-label" :for="item.data.id">{{item.data.name}}</label>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="closeModal()"
            >Приемане</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ChecboxModal",
  props: ["name", "label", "data", "model"],
  data: function() {
    return {
      selectedArray: null,
      loading: true,
      itemsData: null
    };
  },
  mounted() {
    if (this.data !== null) {
      this.selectedArray = this.data;
    }
    axios
      .get("/api/" + this.model)
      .then(response => {
        this.itemsData = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        alert("Грешка при взимането на информация");
      });
  },
  methods: {
    closeModal() {
      this.$emit("closemodal", this.selectedArray);
    }
  },
  watch: {
    data: function(val) {
      this.selectedArray = val;
    }
  }
};
</script>
