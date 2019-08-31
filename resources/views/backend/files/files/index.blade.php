@extends('layouts.pages.default')

@section('css')
    {{--<link rel="stylesheet" href="{{ mix('assets/css/backend/files/files/index.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="<?= asset($dir . '/css/elfinder.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset($dir . '/css/theme.css') ?>">
@endsection

@section('js')
{{--    <script src="{{ mix('assets/js/backend/files/files/index.js') }}"></script>--}}
    <script src="<?= asset($dir . '/js/elfinder.min.js') ?>"></script>

    @if ($locale)
        <script src="<?= asset($dir . "/js/i18n/elfinder.$locale.js") ?>"></script>
    @endif

    <script type="text/javascript" charset="utf-8">
		/**
		 * Overwrite app.js custom AJAX initialisation
		 */
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': abenevaut.token
			},
			beforeSend: function(xhr, options) {
				if (!('<?= route("backend.files.connector") ?>' === options.url.split('?')[0])) {
					options.url = abenevaut.ajax_domain + options.url;
                }
				return true;
			}
		});
        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        $(document).ready(function () {
            $('#elfinder').elfinder({
                // set your elFinder options here
				<?php if($locale){ ?>
                lang: '<?= $locale ?>', // locale
				<?php } ?>
                customData: {
                    _token: '<?= csrf_token() ?>'
                },
                url: '<?= route("backend.files.connector") ?>',  // connector URL
                soundPath: '<?= asset($dir . '/sounds') ?>'
            });
        });
    </script>
@endsection

@section('breadcrumbs')
    @include('partials.pages.default.breadcrumbs', ['breadcrumbs' => [
        route('backend.files.index') => trans('files.title'),
    ]])
@endsection

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="panel panel-transparent">
            <div class="panel-heading ">
                <div class="panel-title"><i class="fa fa-folder-open"></i> {!! trans('files.title') !!}</div>
            </div>
            <div class="panel-body">
                <div id="elfinder"></div>
            </div>
        </div>
    </div>
@endsection
