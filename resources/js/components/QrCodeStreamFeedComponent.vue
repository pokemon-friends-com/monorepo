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
  props: [
    'channel',
  ],
  data() {
    return {
      class_name: QrCodeComponent,
      friendsCodes: [],
    };
  },
  mounted() {
    const vm = this;
    window
      .Echo
      .private(`stream.${this.channel}`)
      .listen('.add-qrcode', (data) => {
        vm.friendsCodes.push(data.friendCode);
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
