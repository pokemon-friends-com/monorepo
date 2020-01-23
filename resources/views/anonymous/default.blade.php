<!DOCTYPE html>
<html lang="{{ Session::get('locale') }}">
<head>
    @include('partials.metadata')
</head>
<body class="hold-transition layout-top-nav">
<div id="template" class="wrapper">
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            @if(Auth::check())
            <a href="{{ route('customer.users.dashboard') }}" class="navbar-brand">
                <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
            </a>
            @else
            <a href="{{ route('anonymous.dashboard') }}" class="navbar-brand">
                <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
            </a>
            @endif
            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('customer.users.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i> {{ trans('users.dashboard') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('anonymous.contact.index') }}" class="nav-link">
                            {{ trans('users.leads.contacts') }}
                        </a>
                    </li>
                </ul>
            </div>
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                @impersonating
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('impersonate.leave') }}"><i class="fa fa-user-times"></i> {{ trans('users.stop_impersonation') }}</a>
                </li>
                @endImpersonating
            </ul>
        </div>
    </nav>
    <div class="content-wrapper">
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
        {!! trans('global.copyright', ['date' => date('Y'), 'route' => route('anonymous.dashboard'), 'name' => config('app.name')]) !!} <a href="{{ route('anonymous.terms') }}">CGV / CGU</a>
    </footer>
</div>
@include('partials.scripts')
</body>
</html>
