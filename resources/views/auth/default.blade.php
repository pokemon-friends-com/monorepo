<!DOCTYPE html>
<html lang="{{ Session::get('locale') }}">
<head>
    @include('partials.metadata')
</head>
<body class="hold-transition login-page">
@include('partials.googletag-body')
<div id="template" class="login-box">
    <div class="login-logo">
        <a href="{{ route('anonymous.dashboard') }}">{{ config('app.name') }}</a>
    </div>
    <div class="card">
        @yield('content')
    </div>
</div>
@include('partials.scripts')
</body>
</html>
