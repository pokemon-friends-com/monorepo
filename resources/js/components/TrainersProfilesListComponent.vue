<template>
  <div>
    <div v-if="profiles"
         class="row"
    >
      <div v-for="profile in profiles.data"
           :key="profile.identifier"
           :id="profile.identifier"
           class="col-lg-2"
      >
        <div
          :class="{
           'card-primary': 'blue' === profile.team_color,
           'card-danger': 'red' === profile.team_color,
           'card-warning': 'yellow' === profile.team_color,
        }"
          class="card card-outline"
        >
          <div class="card-header text-center">{{ profile.friend_code | pkmnFriendCode }}</div>
          <div class="card-boddy text-center" v-html="profile.qr_code"></div>
        </div>
      </div>
    </div>
    <paginator-component :data="profiles" @changed="fetch"></paginator-component>
  </div>
</template>

<script>
import axios from 'axios';
import { forEach, replace, split } from 'lodash';

export default {
  data() {
    return {
      profiles: null,
    };
  },
  mounted() {
    const urlParams = new URLSearchParams(window.location.search);
    // Get `page` query param from url.
    const page = urlParams.get('page') || 1;

    this.fetch(page);
  },
  methods: {
    url(page = 1) {
      if (page && page !== split(window.location.href, '?')[1]) {
        // Set `page` query param in url.
        window.history.pushState({}, '', `?page=${page}`);
      }

      return `/api/v1/users/profiles?page=${page}`;
    },
    fetch(page) {
      axios
        .get(this.url(page))
        .then((response) => {
          this.profiles = response.data;
          forEach(this.profiles.data, (profile, index) => {
            // Do not focus on no-undef rule for `qrcodegen` var.
            // @seealso `resources/views/partials/scripts.blade.php`
            // eslint-disable-next-line no-undef
            const segments = qrcodegen
              .QrSegment
              .makeSegments(replace(profile.friend_code, / /g, ''));
              // eslint-disable-next-line no-undef
            this.profiles.data[index].qr_code = qrcodegen
              .QrCode
              // eslint-disable-next-line no-undef
              .encodeSegments(segments, qrcodegen.QrCode.Ecc.HIGH, 1, 1, -1, true)
              .toSvgString(1);
          });
        });
    },
  },
};
</script>
