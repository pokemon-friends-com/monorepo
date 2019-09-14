<header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <button class="navbar-toggler" type="button"></button>
            <a class="navbar-brand" href="{{ route('frontend.home') }}">{{ config('app.name') }}</a>
            <ul class="navbar-nav navbar-right flex-row d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <span class="d-none d-md-inline-block">{{ trans('auth.login') }}</span>
                        <span class="d-inline-block d-md-none"><i class="ya ya-user"></i></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
