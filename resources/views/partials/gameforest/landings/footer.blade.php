<footer class="site-footer bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0 pb-1 pb-md-0">
                <div class="footer-title">{{ config('app.name') }}</div>
                <p>{{ trans('global.baseline') }}</p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0 pb-1 pb-md-0">
                <div class="footer-title">{{ config('app.name') }}</div>
                <p>{{ trans('global.baseline') }}</p>
            </div>
            <div class="col-md-4">
                <div class="footer-title">{{ config('app.name') }}</div>
                <p>{{ trans('global.baseline') }}</p>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container d-flex flex-column flex-md-row">
            <div class="order-2 order-md-1">
                <div class="footer-links d-none d-md-inline-block">
                    <a href="{{ route('frontend.terms') }}">{{ trans('global.terms') }}</a>
                    <a href="{{ route('frontend.contact.index') }}">{{ trans('leads.contacts') }}</a>
                    <a href="{{ config('services.github.changelog') }}" target="_blank" rel="noopener">{{ trans('global.changelog') }}</a>
                </div>
                <p class="footer-copyright">{!! trans('global.copyright', ['date' => date('Y'), 'route' => route('frontend.home'), 'name' => config('app.name')]) !!}</p>
            </div>
            <div class="footer-social order-1 order-md-2 ml-md-auto text-center text-md-right">
                <span class="d-none d-sm-block mb-2">{{ trans('global.social_networks_baseline') }}</span>
                <a href="{{ config('services.github.url') }}" target="_blank" rel="noopener" data-toggle="tooltip" title="github.com"><i class="ya ya-github"></i></a>
                <a href="{{ config('services.twitter.url') }}" target="_blank" rel="noopener" data-toggle="tooltip" title="twitter.com"><i class="ya ya-twitter"></i></a>
            </div>
        </div>
    </div>
</footer>
