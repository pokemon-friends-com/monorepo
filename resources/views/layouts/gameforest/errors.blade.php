<!DOCTYPE html>
<html prefix="obsessioncity: {{ route('frontend.home') }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Obsession.city'))</title>
    <!-- Scripts -->
    <script src="{{ asset('js/theme.min.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}
<!-- Styles -->
    <link href="{{ asset('css/theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="fixed-navbar">
<div class="site">
    @include('partials.gameforest.frontend.header')
    <div class="site-content" role="main">
        @yield('content')
    </div>
    <!-- end .site-content -->
    @include('partials.gameforest.frontend.footer')
</div>
<!-- end .site -->
<!-- js: vendor -->
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/theme.min.js') }}"></script>
<!-- theme settings -->
<script>
	var gameforest = {
		disqus: 'gameforestyakuzieu',
		facebook: {
			lang: 'en_US',
			version: 'v3.2',
			id: '',
		}
	}
</script>
</body>
</html>
