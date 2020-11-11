<!DOCTYPE html>
<html lang="{{ Session::get('locale') }}">
<head>
    @include('partials.metadata')
</head>
<body class="fixed-navbar">
@include('partials.googletag-body')
<div id="app" class="site">
    <header class="site-header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ya ya-bar"></i></button>
                <a class="navbar-brand" href="{{ route('anonymous.dashboard') }}">{{ config('app.name') }}</a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        @section('header-left')
                        <li class="nav-item">
                            <a href="{{ route('anonymous.dashboard') }}" class="nav-link @if (Route::currentRouteNamed('anonymous.dashboard')) active @endif">
                                @if(Auth::check())
                                    {{ trans('users.dashboard') }}
                                @else
                                    {{ trans('users.home') }}
                                @endif
                            </a>
                        </li>
                        @show
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right flex-row d-flex align-items-center">
                    @section('header-right')
                    @if(Auth::check())
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link">{{ trans('auth.logout') }}</a>
                        </li>
                    @else
                        {{--                        @if (Route::currentRouteNamed(Route::currentRouteName()))--}}
                        {{--                            <li class="nav-item dropdown">--}}
                        {{--                                <a class="nav-link" data-toggle="dropdown" href="#"><i class="fas fa-language"></i></a>--}}
                        {{--                                <div class="dropdown-menu dropdown-menu-sm-right dropdown-menu-right">--}}
                        {{--                                    @foreach(\pkmnfriends\Infrastructure\Interfaces\Domain\Locale\LocalesInterface::LOCALES as $locale)--}}
                        {{--                                        @if (Session::get('locale') !== $locale)--}}
                        {{--                                            <a href="{{ route(Route::currentRouteName(), ['locale' => $locale]) }}" class="dropdown-item">--}}
                        {{--                                                <i class="far fa-flag mr-2"></i>{{ trans("users.locale.${locale}") }}--}}
                        {{--                                            </a>--}}
                        {{--                                        @endif--}}
                        {{--                                    @endforeach--}}
                        {{--                                </div>--}}
                        {{--                            </li>--}}
                        {{--                        @endif--}}
                        <li class="nav-item d-none d-md-inline-block">
                            <a href="{{ route('register') }}" class="nav-link @if (Route::currentRouteNamed('register')) active @endif">{{ trans('auth.register') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (Route::currentRouteNamed('login')) active @endif" href="{{ route('login') }}">
                                <span class="d-none d-md-inline-block">{{ trans('auth.login') }}</span>
                                <span class="d-inline-block d-md-none"><i class="fas fa-user"></i></span>
                            </a>
                        </li>
                    @endif
                    @show
                </ul>
            </div>
        </nav>
    </header>
    <div class="site-content" role="main">
        @impersonating
        <section class="bg-danger py-0">
            <div class="container">
                <div class="promo">
                    <h2 class="promo-title h4">Currently impersonating</h2>
                    <a class="btn btn-outline-light mt-4 mt-lg-0 ml-md-4" href="{{ route('impersonate.leave') }}" role="button"><i class="fa fa-user-times mr-2"></i>{{ trans('users.stop_impersonation') }}</a>
                </div>
            </div>
        </section>
        @endImpersonating
        @yield('content')
    </div>
    <footer class="site-footer bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0 pb-1 pb-md-0">
                    <div class="footer-title">{{ trans('users.welcome') }}</div>
                    <p>Create your own qRcode, with your Pokemon go friend code, and share it on social networks easily with our app. Get new friends by adding available friend code to your Pokemon go account.</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0 pb-1 pb-md-0">
                    <div class="footer-tags">
                        <a href="javascript:void(0);">Pokemon Go</a>
                        <a href="javascript:void(0);">Community</a>
                        <a href="javascript:void(0);">Friends codes</a>
                        <a href="javascript:void(0);">qRcode sharing</a>
                        <a href="javascript:void(0);">Streamers</a>
                        <a href="javascript:void(0);">GoSnapshot</a>
                    </div>
                </div>
                <div class="col-md-4">
                    {!! Form::open(['route' => ['register'], 'method' => 'POST']) !!}
                    @honeypot
                    <div class="form-group">
                        <div class="input-group">
                            <input
                                type="text"
                                name="friend_code"
                                class="form-control {{ $errors && $errors->has('friend_code') ? 'is-invalid' : '' }}"
                                placeholder="{{ trans('users.profiles.friend_code') }}"
                                value="{{ old('friend_code') }}"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-users"></span>
                                </div>
                            </div>
                        </div>
                        @if ($errors && $errors->has('friend_code'))
                            <div class="text-danger text-sm">{{ $errors->first('friend_code') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input
                                type="email"
                                name="email"
                                class="form-control {{ $errors && $errors->has('email') ? 'is-invalid' : '' }}"
                                placeholder="{{ trans('users.email') }}"
                                value="{{ old('email') }}"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        @if ($errors && $errors->has('email'))
                            <div class="text-danger text-sm">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="sm-p-t-10 clearfix"></div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ trans('auth.register') }}
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container d-flex flex-column flex-md-row">
                <div class="order-2 order-md-1">
                    <div class="footer-links d-none d-md-inline-block">
                        <a href="{{ route('anonymous.terms') }}" target="_blank" rel="noopener">{{ trans('users.terms') }}</a>
                        <a href="{{ config('services.github.issues') }}" target="_blank" rel="noopener">Support</a>
                        <a href="{{ config('services.github.changelog') }}" target="_blank" rel="noopener">Changelog</a>
                    </div>
                    <p class="footer-copyright">{!! trans('global.copyright', ['date' => date('Y'), 'route' => route('anonymous.dashboard'), 'name' => config('app.name')]) !!}</p>
                </div>
                <div class="footer-social order-1 order-md-2 ml-md-auto text-center text-md-right">
                    <span class="d-none d-sm-block mb-2">{{ trans('global.social_networks_baseline') }}</span>
                    <a href="{{ config('services.twitter.url') }}" target="_blank" rel="noopener" data-toggle="tooltip" title="twitter.com"><i class="ya ya-twitter"></i></a>
                    <a href="{{ config('services.github.url') }}" target="_blank" rel="noopener" data-toggle="tooltip" title="github.com"><i class="ya ya-github"></i></a>
                </div>
            </div>
        </div>
    </footer>
</div>
@if(!Auth::check())
    @include('cookieConsent::index')
@endif
@include('partials.scripts')
</body>
</html>
