<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="UTF-8">
@if (Route::currentRouteNamed(Route::currentRouteName()))
@foreach(\template\Infrastructure\Interfaces\Domain\Locale\LocalesInterface::LOCALES as $locale)
    <link rel="alternate" hreflang="{{ $locale }}" href="{{ route(Route::currentRouteName(), ['locale' => $locale]) }}" />
@endforeach
@endif
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset_cdn('/images/apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset_cdn('/images/apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset_cdn('/images/apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset_cdn('/images/apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset_cdn('/images/apple-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset_cdn('/images/apple-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset_cdn('/images/apple-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset_cdn('/images/apple-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset_cdn('/images/apple-icon-180x180.png') }}">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset_cdn('/images/android-icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset_cdn('/images/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset_cdn('/images/favicon-96x96.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset_cdn('/images/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset_cdn('/images/manifest.json') }}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{ asset_cdn('/images/ms-icon-144x144.png') }}">
<meta name="theme-color" content="#ffffff">
<title>@yield('title', config('app.name'))</title>
<base href="{{ config('app.url') }}">
<meta name="environment" content="{{ config('app.env') }}">
<meta name="debug" content="{{ config('app.debug') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="locale" content="{{ Session::get('locale') }}">
<meta name="timezone" content="{{ Session::get('timezone') }}">
<meta name="robots" content="@yield('robots', config('view.robots'))">
<meta name="description" content="@yield('description', config('app.description'))" />
<meta name="keywords" content="@yield('keywords', config('app.keywords'))" />
<meta name="author" content="{{ config('services.twitter.url') }}" />
<meta name="copyright" content="{{ config('app.copyright') }}" />
<meta name="application-name" content="{{ config('app.url') }}" />
<meta property="og:site_name" content="{{ config('app.url') }}"/>
<meta property="og:title" content="@yield('title', config('app.name'))"/>
<meta property="og:image" content="@yield('image', asset_cdn(config('services.facebook.og:image')))" />
<meta property="og:description" content="@yield('description', config('app.description'))" />
@section('type')
<meta property="og:type" content="{{ config('services.facebook.og:type') }}" />
@show
<meta property="og:url" content="{{ URL::current() }}"/>
<meta name="twitter:title" content="@yield('title', config('app.name'))" />
<meta name="twitter:description" content="@yield('description', config('app.description'))" />
<meta name="twitter:image" content="@yield('image', asset_cdn(config('services.twitter.image')))" />
<meta name="twitter:card" content="@yield('card', config('services.twitter.card'))" />
<meta name="twitter:creator" content="{{ config('services.twitter.username') }}" />
<meta name="twitter:site" content="{{ config('services.twitter.username') }}" />
<link href="{{ asset_cdn('css/app.css') }}" rel="stylesheet">
<link rel="sitemap" type="application/xml" title="sitemap" href="{{ url('sitemap.xml') }}" />
@yield('css')
@include('partials.googletag-head')
