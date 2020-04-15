@extends('anonymous.default')

@section('title', $metadata['title'])

@section('content')
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark text-center">{{ trans('users.baseline') }}</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="d-none d-md-block col-lg-8">
                <div class="card card-widget widget-user">
                    <div class="ribbon-wrapper ribbon-lg"><div class="ribbon bg-danger">{{ trans('global.beta') }}</div></div>
                    <div class="widget-user-header text-white" style="background:url({{ asset_cdn('images/pokemon-banner.jpg') }}) no-repeat center center;">
                        <h3 class="widget-user-username text-left">{{ trans('users.welcome') }}</h3>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="{{ asset_cdn('images/avatar.jpg') }}" alt="Avatar">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <span class="description-text">{{ trans('users.anonymous.dashboard.share_gift') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <span class="description-text">{{ trans('users.anonymous.dashboard.fight_friend') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <span class="description-text">{{ trans('users.anonymous.dashboard.boost_xp') }}</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        {!! trans('users.anonymous.dashboard.features', ['home_url' => route('anonymous.dashboard'), 'app_name' => config('app.name')]) !!}
                    </div>
                </div>
                <div class="card card-widget widget-user">
                    <div class="ribbon-wrapper ribbon-lg"><div class="ribbon bg-info">{{ trans('global.to_come_up') }}</div></div>
                    <div class="card-body">
                        {!! trans('users.anonymous.dashboard.to_come_up', ['home_url' => route('anonymous.dashboard'), 'app_name' => config('app.name')]) !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    {!! Form::open(['route' => ['register'], 'method' => 'POST']) !!}
                    @honeypot
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <input
                                        type="text"
                                        name="friend_code"
                                        class="form-control {{ $errors && $errors->has('friend_code') ? 'is-invalid' : '' }}"
                                        placeholder="{{ trans('users.profiles.friend_code') }}"
                                        value="{{ old('friend_code') }}"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-users"></span>
                                    </div>
                                </div>
                            </div>
                            @if ($errors && $errors->has('friend_code'))
                                <div class="text-danger text-sm">{{ $errors->first('friend_code') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input
                                        type="email"
                                        name="email"
                                        class="form-control {{ $errors && $errors->has('email') ? 'is-invalid' : '' }}"
                                        placeholder="{{ trans('users.email') }}"
                                        value="{{ old('email') }}"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            @if ($errors && $errors->has('email'))
                                <div class="text-danger text-sm">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="sm-p-t-10 clearfix"></div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ trans('auth.register') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                @include('partials.card_official_doc')
                @include('partials.card_our_news')
            </div>
        </div>
        <trainers-profiles-list-component></trainers-profiles-list-component>
    </div>
</div>
@endsection
