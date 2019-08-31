@extends('layouts.gameforest.errors')
@section('title', trans('errors.503_title'))

@section('js')
	@if(app()->bound('sentry') && !empty(app('sentry')->getLastEventID()))
		<script>
			var data = {
				eventId: '{{ app('sentry')->getLastEventID() }}',
				dsn: '{{ env('SENTRY_PUBLIC_DSN') }}',
			};
			@if (Auth::check())
				data['user'] = {
				'name': '{{ Auth::user()->email }}',
				'email': '{{ Auth::user()->email }}',
			};
			@endif
			Raven.showReportDialog(data);
		</script>
	@endif
@endsection

@section('content')
    <div class="site-content" role="main">
        <section class="bg-image text-center py-8 px-4 px-md-0" ya-style="background-color: #252525">
            <img class="background" src="https://img.youtube.com/vi/y3Cpetu4ke4/maxresdefault.jpg" alt="">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-lg-6 mx-auto">
                        <h1 class="font-weight-black text-white mb-0">{{ trans('errors.503_title') }}</h1>
                        <p class="text-light mb-4">
                        {{ trans('errors.503_description') }}
                            @if (app()->bound('sentry') && !empty(app('sentry')->getLastEventID()))
                                <div>Error ID: {{ app('sentry')->getLastEventID() }}</div>
                            @endif
                        </p>
{{--                        <form class="mb-5" action="search.html">--}}
{{--                            <div class="input-group">--}}
{{--                                <input type="text" class="form-control form-control-inline border-0 shadow-none" placeholder="Search page...">--}}
{{--                                <div class="input-group-append">--}}
{{--                                    <button type="submit" class="btn btn-light border-0"><i class="ya ya-search m-0"></i></button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
                        <a class="btn btn-primary btn-rounded btn-lg" href="{{ route('frontend.home') }}">{{ trans('home') }}</a>
                        <a class="btn btn-outline-light btn-rounded btn-lg ml-2" href="{{ route('frontend.contact.index') }}">{{ trans('leads.contact_form') }}</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- end .site-content -->
@endsection
