<template>
  <div>
    <component
      v-for="(friend_code, index) in friendsCodes"
      :key="index"
      :is="class_name"
      friend_code="friend_code">
    </component>
    <div class="scroll-to-me"></div>
  </div>
</template>

<script>
import QrCodeComponent from './QrCodeComponent.vue';

export default {
  components: {
    QrCodeComponent,
  },
  data() {
    return {
      class_name: QrCodeComponent,
      friendsCodes: [],
    };
  },
  mounted() {
    window
      .Echo
      .private('stream.blazed_css')
      .listen('.add-qrcode', (data) => {
        this.friendsCodes.push(data.friendCode);
      });
    this.scrollToElement();
  },
  methods: {
    scrollToElement() {
      setTimeout(() => {
        const el = this.$el.getElementsByClassName('scroll-to-me')[0];

        if (el) {
          el.scrollIntoView({
            behavior: 'smooth',
            block: 'end',
            inline: 'nearest',
          });
        }

        this.scrollToElement();
      }, 50);
    },
  },
};
</script>
