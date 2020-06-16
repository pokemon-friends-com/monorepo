@extends('administrator.default')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?= asset_cdn($dir . '/css/elfinder.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_cdn($dir . '/css/theme.css') ?>">
@endsection

@section('js')
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous" defer></script>
    <script src="<?= asset_cdn($dir . '/js/elfinder.full.js') ?>" defer></script>
    @if ($locale)
        <script src="<?= asset_cdn($dir . "/js/i18n/elfinder.$locale.js") ?>" defer></script>
    @endif
    <script type="text/javascript">
      (function (W, D, $) {
        $(D).ready(function() {
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          // Documentation for client options: https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
          $('#elfinder').elfinder({
            // Set your elFinder options here.
            <?php if ($locale){ ?>
            lang: '<?= $locale ?>', // locale
            <?php } ?>
            customData: {
              _token: '<?= csrf_token() ?>'
            },
            url: '<?= route("administrator.files.connector") ?>',  // connector URL
            soundPath: '<?= asset_cdn($dir . '/sounds') ?>'
          });
        });
      })(window, document, jQuery);
    </script>
@endsection

@section('content')
<nav class="bg-white border-bottom" aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><i class="fa fa-folder-open mr-2"></i>{{ trans('files.title') }}</li>
        </ol>
    </div>
</nav>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div id="elfinder"></div>
            </div>
        </div>
    </div>
</section>
@endsection
