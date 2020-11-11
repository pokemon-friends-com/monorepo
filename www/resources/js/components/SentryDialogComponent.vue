<template>
  <div></div>
</template>
<script>
import { showReportDialog } from '@sentry/browser';
import AppComponent from './AppComponent.vue';

export default {
  extends: AppComponent,
  props: [
    'eventId',
  ],
  watch: {
    user() {
      showReportDialog({
        dsn: process.env.MIX_SENTRY_PUBLIC_DSN,
        eventId: this.eventId,
        user: {
          id: this.user.identifier,
          name: this.user.full_name,
          email: this.user.email,
        },
      });
    },
  },
};
</script>
