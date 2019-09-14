<!DOCTYPE html>
<html prefix="obsessioncity: {{ route('frontend.home') }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.gameforest.landings.metadata')
</head>
<body class="fixed-navbar">
<div id="obsessioncity" class="site">
    @include('partials.gameforest.landings.header')
    <div class="site-content" role="main">
        @yield('content')
    </div>
</div>
@include('partials.gameforest.landings.footerjs')
</body>
</html>
