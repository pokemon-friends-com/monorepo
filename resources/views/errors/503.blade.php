@extends('anonymous.default')

@section('title', trans('errors.503_title'))

@section('content')
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <h1 class="m-0 text-dark"><i class="fas fa-power-off mr-2"></i>{{ trans('errors.503_title') }}</h1>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {!! trans('errors.503_description', ['news_feed' => config('services.twitter.url')]) !!}
                    </div>
                </div>
            </div>
            <div class="col-12">
                @include('partials.row_socials_news')
            </div>
        </div>
    </div>
</div>
@endsection
