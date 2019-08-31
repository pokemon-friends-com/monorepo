@extends('layouts.gameforest.home')

@section('content')
    <section class="p-0 overflow-hidden">
        <div class="owl-carousel" ya-carousel="autoplay: true;height: true">
            <div class="owl-carousel-item">
                <img src="{{ asset('img/home.index.jpg') }}" ya-style="opacity: .28" alt="">
                <div class="owl-caption">
                    <div class="owl-caption-container">
                        <h1 class="owl-title">{{ config('app.name') }}</h1>
                        <p class="owl-text">{{ trans('frontend/home.baseline') }}</p>
                        <a class="btn btn-outline-primary btn-lg btn-rounded" href="register" role="button">{{ trans('auth.register') }}</a>
                        <a class="btn btn-outline-light btn-lg btn-rounded ml-2" href="login" role="button">{{ trans('auth.login') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end .owl-carousel -->
    </section>
@endsection
