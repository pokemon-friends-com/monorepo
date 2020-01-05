<template>
    <div v-if="user" v-text="user.civility_name"></div>
</template>

<script>
import axios from 'axios';

export default {
  mounted() {
    this.getUser();
  },
  data() {
    return {
      user: null,
    };
  },
  methods: {
    getUser() {
      axios
        .get('/api/v1/users/user')
        .then((response) => {
          this.user = response.data;
        });

      return this;
    },
  },
};
</script>
