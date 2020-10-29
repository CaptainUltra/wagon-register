<template>
  <div v-if="this.emitData.paginationData.total > 15">
    <div class="pt-3 d-flex justify-content-start">
      <p>Общо {{this.emitData.paginationData.total}} записа</p>
    </div>
    <div class="pt-3 d-flex justify-content-end">
      <ul class="pagination justify-content-center">
        <li :class="previousClass">
          <a @click="changePagePrev()" class="page-link">Предишна</a>
        </li>
        <li class="page-item">
          <p
            class="page-link disabled text-body"
          >{{emitData.paginationData.currentPage}} от {{this.emitData.paginationData.lastPage}}</p>
        </li>
        <li :class="nextClass">
          <a @click="changePageNext()" class="page-link">Следваща</a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "Pagination",
  props: ["pagination", "model"],
  mounted() {
    this.getDataFromProp();
  },
  data: function() {
    return {
      emitData: {
        values: null,
        paginationData: {
          total: null,
          currentPage: null,
          lastPage: null
        },
        loading: null
      }
    };
  },
  computed: {
    previousClass: function() {
      if (this.emitData.paginationData.currentPage > 1) {
        return "page-item text-primary";
      } else {
        return "page-item disabled";
      }
    },
    nextClass: function() {
      if (
        this.emitData.paginationData.currentPage <
        this.emitData.paginationData.lastPage
      ) {
        return "page-item text-primary";
      } else {
        return "page-item disabled";
      }
    }
  },
  methods: {
    getDataFromProp() {
      this.emitData.paginationData.total = this.pagination.total;
      this.emitData.paginationData.currentPage = this.pagination.currentPage;
      this.emitData.paginationData.lastPage = this.pagination.lastPage;
    },
    loadData(response) {
      this.emitData.values = response.data.data;
      this.emitData.paginationData.currentPage =
        response.data.meta["current_page"];
      this.emitData.paginationData.lastPage = response.data.meta["last_page"];
      this.emitData.paginationData.total = response.data.meta["total"];
      this.emitData.loading = false;
      this.$emit("updatepage", this.emitData);
    },
    changePageNext() {
      let nextPage = this.emitData.paginationData.currentPage + 1;
      let pageQueryString = "?page=" + nextPage.toString();
      if (this.model.includes("?")) {
        pageQueryString = "&page=" + nextPage.toString();
      }
      axios
        .get("/api/" + this.model + pageQueryString)
        .then(response => this.loadData(response))
        .catch(error => {
          alert("Грешка при взимането на информация");
        });
    },
    changePagePrev() {
      let nextPage = this.emitData.paginationData.currentPage - 1;
      let pageQueryString = "?page=" + nextPage.toString();
      if (this.model.includes("?")) {
        pageQueryString = "&page=" + nextPage.toString();
      }
      axios
        .get("/api/" + this.model + pageQueryString)
        .then(response => this.loadData(response))
        .catch(error => {
          alert("Грешка при взимането на информация");
        });
    }
  },
  watch: {
    pagination: {
      //immediate: true,
      deep: true, //FIXME:Causes an error when going to second page as the prop gets set to undefined
      handler(value) {
        this.getDataFromProp();
      }
    }
  }
};
</script>
