<header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ya ya-bar"></i>
            </button>
            <a class="navbar-brand" href="{{ route('frontend.home') }}">{{ config('app.name') }}</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.home') }}" aria-haspopup="true" aria-expanded="false">{{ trans('global.home') }}</a>
                    </li>
                </ul>
            </div>
            <!-- end .navbar-collapse -->
            <ul class="navbar-nav navbar-right flex-row d-flex align-items-center">
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="{{ route('login') }}">--}}
{{--                        <span class="d-none d-md-inline-block">{{ trans('auth.login') }}</span>--}}
{{--                        <span class="d-inline-block d-md-none"><i class="ya ya-user"></i></span>--}}
{{--                    </a>--}}
{{--                </li>--}}
            </ul>
            <!-- end .navbar-nav -->
        </div>
    </nav>
</header>
<!-- end .site-header -->
