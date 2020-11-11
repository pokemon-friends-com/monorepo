<div class="row">
    <div class="col-12 col-sm-4">
        @include('partials.card_our_news')
    </div>
    <div class="col-12 col-sm-4">
        <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">{{ trans('global.next_features') }}</span>
                <span class="info-box-number text-center text-muted mb-0"><a href="{{ config('services.github.nextgen') }}" target="_blank" rel="noopener" title="github.com"><i class="fab fa-github mr-2"></i>Github</a></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">{{ trans('global.bugs_reported') }}</span>
                <span class="info-box-number text-center text-muted mb-0"><a href="{{ config('services.github.issues') }}" target="_blank" rel="noopener" title="github.com"><i class="fab fa-github mr-2"></i>Github</a></span>
            </div>
        </div>
    </div>
</div>