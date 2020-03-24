<!DOCTYPE html>
<html lang="{{ Session::get('locale') }}">
<head>
    @include('partials.metadata')
</head>
<body class="hold-transition layout-top-nav">
@include('partials.googletag-body')
<div id="template" class="wrapper">
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="{{ route('anonymous.dashboard') }}" class="navbar-brand">
                <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
            </a>
            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('anonymous.dashboard') }}" class="nav-link @if (Route::currentRouteNamed('anonymous.dashboard')) active @endif"><i class="fas fa-home mr-2"></i>{{ trans('global.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('anonymous.contact.index') }}" class="nav-link @if (Route::currentRouteNamed('anonymous.contact.index')) active @endif"><i class="fas fa-envelope mr-2"></i>{{ trans('users.leads.contacts') }}</a>
                    </li>
                </ul>
            </div>
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                @if(Auth::check() && Auth::user()->is_customer)
                    <li class="nav-item">
                        <a href="{{ route('customer.users.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt mr-2"></i>{{ trans('users.dashboard') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link"><i class="fa fa-sign-out-alt mr-2"></i>{{ trans('auth.logout') }}</a>
                    </li>
                @elseif(Auth::check() && Auth::user()->is_administrator)
                    <li class="nav-item">
                        <a href="{{ route('administrator.users.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt mr-2"></i>{{ trans('users.dashboard') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link"><i class="fa fa-sign-out-alt mr-2"></i>{{ trans('auth.logout') }}</a>
                    </li>
                @else
                    @if (Route::currentRouteNamed(Route::currentRouteName()))
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#"><i class="fas fa-language"></i></a>
                        <div class="dropdown-menu dropdown-menu-sm-right dropdown-menu-right">
                        @foreach(\template\Infrastructure\Interfaces\Domain\Locale\LocalesInterface::LOCALES as $locale)
                            @if (Session::get('locale') !== $locale)
                            <a href="{{ route(Route::currentRouteName(), ['locale' => $locale]) }}" class="dropdown-item">
                                <i class="far fa-flag mr-2"></i>{{ trans("users.locale.${locale}") }}
                            </a>
                            @endif
                        @endforeach
                        </div>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link"><i class="fa fa-sign-in-alt mr-2"></i>{{ trans('auth.login') }}</a>
                    </li>
                @endif
                @impersonating
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('impersonate.leave') }}"><i class="fa fa-user-times mr-2"></i>{{ trans('users.stop_impersonation') }}</a>
                </li>
                @endImpersonating
            </ul>
        </div>
    </nav>
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                @include('partials.session-message')
            </div>
        </div>
        @yield('content')
    </div>
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            <div class="d-none d-sm-block mb-2">
                {{ trans('global.social_networks_baseline') }}
                <a href="{{ config('services.github.url') }}" target="_blank" rel="noopener" title="github.com"><i class="fab fa-github"></i></a>
                <a href="{{ config('services.twitter.url') }}" target="_blank" rel="noopener" title="twitter.com"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
        <span class="mr-1">{!! trans('global.copyright', ['date' => date('Y'), 'route' => route('anonymous.dashboard'), 'name' => config('app.name')]) !!}</span><a href="{{ route('anonymous.terms') }}"><i class="fas fa-file-signature mr-1"></i>{{ trans('global.terms') }}</a>
    </footer>
</div>
@if(!Auth::check())
@include('cookieConsent::index')
@endif
@include('partials.scripts')
</body>
</html>
