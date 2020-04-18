<!DOCTYPE html>
<html lang="{{ Session::get('locale') }}">
<head>
    @include('partials.metadata')
</head>
<body class="hold-transition sidebar-mini @if (Auth::user()->profile->is_sidebar_pined) sidebar-collapse @else layout-fixed @endif">
@include('partials.googletag-body')
<div id="template" class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <collapse-sidebar-component></collapse-sidebar-component>
            </li>
            <li class="nav-item">
                <a href="{{ route('anonymous.contact.index') }}" class="nav-link @if (Route::currentRouteNamed('anonymous.contact.index')) active @endif"><i class="fas fa-envelope mr-2"></i>{{ trans('users.leads.contact') }}</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link"><i class="fa fa-sign-out-alt mr-2"></i>{{ trans('auth.logout') }}</a>
            </li>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('anonymous.dashboard') }}" class="brand-link">
            <img src="{{ asset_cdn('images/pokeball.jpg') }}" alt="{{ config('app.name') }}" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset_cdn('images/avatar.jpg') }}" class="img-circle elevation-2" alt="{{ Auth::user()->full_name }}">
                </div>
                <div class="info">
                    <a href="{{ route('customer.users.edit', ['id' => Auth::user()->uniqid]) }}" class="d-block">{{ Auth::user()->full_name }}</a>
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('customer.users.dashboard') }}" class="nav-link @if (Route::currentRouteNamed('customer.users.dashboard')) active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>{{ trans('users.dashboard') }}</p>
                        </a>
                    </li>
                    @impersonating
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('impersonate.leave') }}">
                            <i class="fa fa-user-times mr-2"></i>
                            <p>{{ trans('users.stop_impersonation') }}</p>
                        </a>
                    </li>
                    @endImpersonating
                </ul>
            </nav>
        </div>
    </aside>
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                @include('partials.session-message')
            </div>
        </div>
        @yield('content')
    </div>
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <div class="d-none d-sm-block mb-2">
                {{ trans('global.social_networks_baseline') }}
                <a href="{{ config('services.github.url') }}" target="_blank" rel="noopener" title="github.com"><i class="fab fa-github"></i></a>
                <a href="{{ config('services.twitter.url') }}" target="_blank" rel="noopener" title="twitter.com"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
        <span class="mr-1">{!! trans('global.copyright', ['date' => date('Y'), 'route' => route('anonymous.dashboard'), 'name' => config('app.name')]) !!}</span><span class="mr-1"><a href="{{ route('anonymous.terms') }}">{{ trans('users.terms') }}</a></span>
    </footer>
    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
@include('partials.scripts')
</body>
</html>
