<template>
  <div>
    <a :data-remote="img"
       data-type="image"
       data-toggle="lightbox"
       :data-title="friend_code"
       data-gallery="trainers"
       @click="ekkoLightbox"></a>
  </div>
</template>

<script>
import QRCode from 'qrcode';

export default {
  props: [
    'friend_code',
    'color',
  ],
  computed: {
    img() {
      let urlImg = null;
      const opts = {
        errorCorrectionLevel: 'L',
        type: 'image/webp',
        quality: 0.3,
        margin: 0,
        width: 300,
        height: 300,
        color: {
          dark: '#000',
          light: '#FFF',
        },
      };

      QRCode.toDataURL(this.friend_code, opts, (err, url) => {
        urlImg = url;
      });

      return urlImg;
    },
  },
  methods: {
    ekkoLightbox: (e) => {
      jQuery(e.target).ekkoLightbox({
        alwaysShowClose: true,
      });
    },
  },
};
</script>
