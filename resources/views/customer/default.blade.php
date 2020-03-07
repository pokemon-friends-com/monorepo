<!DOCTYPE html>
<html lang="{{ Session::get('locale') }}">
<head>
    @include('partials.metadata')
</head>
<body class="hold-transition layout-top-nav">
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
                        <a href="{{ route('anonymous.contact.index') }}" class="nav-link">
                            {{ trans('users.leads.contacts') }}
                        </a>
                    </li>
                </ul>
            </div>
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item">
                    <a href="{{ route('customer.users.dashboard') }}" class="nav-link"><i class="fa fa-user mr-2"></i>{{ trans('users.profiles.edit.title') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"><i class="fa fa-sign-out-alt mr-2"></i>{{ trans('auth.logout') }}</a>
                </li>
                @impersonating
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('impersonate.leave') }}"><i class="fa fa-user-times mr-2"></i>{{ trans('users.stop_impersonation') }}</a>
                </li>
                @endImpersonating
            </ul>
        </div>
    </nav>
    <div class="content-wrapper">
        @if (Session::has('message-success'))
        <section class="content">
            <div class="container-fluid">
                <div class="row pt-2 pb-2">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! trans(Session::get('message-success')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
        @if (Session::has('message-error'))
        <section class="content">
            <div class="container-fluid">
                <div class="row pt-2 pb-2">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! trans(Session::get('message-error')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
        @if (Session::has('message-warning'))
        <section class="content">
            <div class="container-fluid">
                <div class="row pt-2 pb-2">
                    <div class="col-12">
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! trans(Session::get('message-warning')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
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
        <span class="mr-1">{!! trans('global.copyright', ['date' => date('Y'), 'route' => route('anonymous.dashboard'), 'name' => config('app.name')]) !!}</span><a href="{{ route('anonymous.terms') }}">{{ trans('global.terms') }}</a>
    </footer>
</div>
@include('partials.scripts')
</body>
</html>
