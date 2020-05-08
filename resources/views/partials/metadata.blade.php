<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="UTF-8">
@if (Route::currentRouteNamed(Route::currentRouteName()))
@foreach(\template\Infrastructure\Interfaces\Domain\Locale\LocalesInterface::LOCALES as $locale)
    <link rel="alternate" hreflang="{{ $locale }}" href="{{ route(Route::currentRouteName(), ['locale' => $locale]) }}" />
@endforeach
@endif
@include('partials.favicons')
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
<link href="{{ asset_cdn('assets/css/app.css?v=' . config('version.app_tag') ) }}" rel="stylesheet">
<link rel="sitemap" type="application/xml" title="sitemap" href="{{ url('sitemap.xml') }}" />
@yield('css')
@include('partials.googletag-head')
