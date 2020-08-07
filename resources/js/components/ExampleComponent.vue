<template>
    <div class="card" v-if="user">
        <div class="card-header" v-text="user.civility_name"></div>
        <div class="card-body" v-text="user.role.trans"></div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import AppComponent from './AppComponent.vue';

export default {
  extends: AppComponent,
  data() {
    return {
      toast: null,
    };
  },
  mounted() {
    this.toast = Swal
      .mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
      });

    window
      .Echo
      .channel('my-channel')
      .listen('.my-event', (data) => {
        this.toast.fire({ type: 'success', title: data.message });
      });
  },
};
</script>
