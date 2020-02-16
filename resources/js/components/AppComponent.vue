<template>
    <div v-if="user" v-text="user.civility_name"></div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      user: null,
    };
  },
  mounted() {
    axios
      .get('/api/v1/users/user')
      .then((response) => {
        this.user = response.data;
      });
  },
};
</script>
