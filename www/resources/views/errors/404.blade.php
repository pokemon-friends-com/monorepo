@extends('default')

@section('title', trans('errors.404_title'))
@section('robots', 'noindex')

@section('content')
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{ trans('errors.404_title') }}</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning">404</h2>
            <div class="error-content">
                <h3>
                    <i class="fas fa-exclamation-triangle text-warning mr-2"></i>{{ trans('errors.404_title') }}
                </h3>
                <p>
                    {{ trans('errors.404_description') }}
                </p>
                <p>
                    <a class="btn btn-primary btn-sm" href="{{ route('anonymous.dashboard') }}">{{ trans('home') }}</a>
                </p>
            </div>
        </div>
    </section>
@endsection
