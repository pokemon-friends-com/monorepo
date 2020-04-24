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
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('administrator.users.dashboard') }}" class="nav-link @if (Route::currentRouteNamed('administrator.users.dashboard')) active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>{{ trans('users.dashboard') }}</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview @if (
                        Route::currentRouteNamed('administrator.users.index')
                        || Route::currentRouteNamed('administrator.users.create')
                        || Route::currentRouteNamed('administrator.users.edit')
                        || Route::currentRouteNamed('administrator.users.show')
                        || Route::currentRouteNamed('administrator.users.leads.index')
                        ) menu-open @endif">
                        <a href="javascript:void(0);" class="nav-link @if (
                            Route::currentRouteNamed('administrator.users.index')
                            || Route::currentRouteNamed('administrator.users.create')
                            || Route::currentRouteNamed('administrator.users.edit')
                            || Route::currentRouteNamed('administrator.users.show')
                            || Route::currentRouteNamed('administrator.users.leads.index')
                            ) active @endif">
                            <i class="nav-icon fa fa-users"></i>
                            <p>{{ trans('users.title') }}<i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('administrator.users.leads.index') }}" class="nav-link @if (Route::currentRouteNamed('administrator.users.leads.index')) active @endif">
                                    <i class="far fa-user-circle nav-icon"></i>
                                    <p>{{ trans('users.leads.title') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('administrator.users.index') }}" class="nav-link @if (
                                    Route::currentRouteNamed('administrator.users.index')
                                    || Route::currentRouteNamed('administrator.users.create')
                                    || Route::currentRouteNamed('administrator.users.edit')
                                    || Route::currentRouteNamed('administrator.users.show')
                                    ) active @endif">
                                    <i class="fa fa-users nav-icon"></i>
                                    <p>{{ trans('users.title') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('administrator.files.index') }}" class="nav-link @if (Route::currentRouteNamed('administrator.files.index')) active @endif">
                            <i class="nav-icon fa fa-folder-open"></i>
                            <p>{{ trans('files.title') }}</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                @include('partials.session-message')
            </div>
        </div>
        @yield('content')
    </div>
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            {!! trans('global.environment', ['environment' => config('app.env') . '-' . config('sentry.release')]) !!}
        </div>
        <span class="mr-0">{!! trans('global.copyright', ['date' => date('Y'), 'route' => route('anonymous.dashboard'), 'name' => config('app.name')]) !!}</span>
    </footer>
    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
@include('partials.scripts')
</body>
</html>
