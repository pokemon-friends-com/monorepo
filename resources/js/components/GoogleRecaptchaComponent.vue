<template>
    <div :data-sitekey="googleRecaptchaSiteKey" class="g-recaptcha"></div>
</template>
<script>
export default {
  data() {
    return {
      googleRecaptchaSiteKey: process.env.MIX_GOOGLE_RECAPTCHA_SITEKEY,
    };
  },
  mounted() {
    const recaptchaScript = document.createElement('script');
    recaptchaScript.setAttribute('src', 'https://www.google.com/recaptcha/api.js');
    document.head.appendChild(recaptchaScript);
  },
};
</script>
