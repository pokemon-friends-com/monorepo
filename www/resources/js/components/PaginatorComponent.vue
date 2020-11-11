<template>
  <div class="row" v-if="shouldPaginate">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-footer">
          <button type="button"
                  v-show="prevUrl"
                  @click.prevent="page--"
                  class="sub btn btn-default btn-sm"
          >
            {{ $t('pagination.previous') }}
          </button>
          <button type="button"
                  v-show="nextUrl"
                  @click.prevent="page++"
                  class="add btn btn-default btn-sm float-right"
          >
            {{ $t('pagination.next') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    'data',
  ],
  data() {
    return {
      page: 1,
      prevUrl: false,
      nextUrl: false,
    };
  },
  computed: {
    shouldPaginate() {
      return !!this.prevUrl || !!this.nextUrl;
    },
  },
  watch: {
    data() {
      this.page = this.data.current_page;
      this.prevUrl = this.data.prev_page_url;
      this.nextUrl = this.data.next_page_url;
    },
    page() {
      this.broadcast();
    },
  },
  methods: {
    broadcast() {
      return this.$emit('changed', this.page);
    },
  },
};
</script>
