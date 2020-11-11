<template>
    <a
            class="nav-link"
            href="javascript:void(0);"
            data-widget="pushmenu"
            v-if="user"
            @click="onClick"
    >
        <i class="fas fa-bars"></i>
    </a>
</template>

<script>
import { pick } from 'lodash';
import axios from 'axios';
import AppComponent from './AppComponent.vue';

export default {
  extends: AppComponent,
  methods: {
    onClick() {
      this.user.is_sidebar_pined = !this.user.is_sidebar_pined;
      axios.put(`/api/v1/users/profiles/${this.user.identifier}`, pick(this.user, ['is_sidebar_pined']));

      return this;
    },
  },
};
</script>
