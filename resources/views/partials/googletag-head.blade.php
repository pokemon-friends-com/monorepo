<script>
  dataLayer = [{
    'env': '{{ config('app.env') }}',
    'release': '{{ config('version.app_tag') }}',
    'debug': '{{ config('app.debug') }}',
    'user': '{{ Auth::check() ? Auth::user()->uniqid : 'anonymous' }}',
    'locale': '{{ Session::get('locale') }}',
    'timezone': '{{ Session::get('timezone') }}',
    'gender': '{{ Auth::check() ? Auth::user()->gender : \template\Infrastructure\Interfaces\Domain\Users\Users\UserGendersInterface::GENDER_UNDEFINED }}',
  }];
  (function(w,d,s,l,i){w[l]=w[l]||[];w[l]
  .push({'gtm.start': new Date().getTime(),event:'gtm.js'});
    var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
    j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl+ '&gtm_auth={{ config('services.google_tag_manager.auth') }}&gtm_preview={{ config('services.google_tag_manager.env') }}&gtm_cookies_win=x';
    f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ config('services.google_tag_manager.id') }}');
</script>
