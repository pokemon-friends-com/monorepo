@extends('default')

@section('content')
<section class="px-2 px-md-0 py-md-7">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
                <div class="card mb-0 border-0"
                        {{--                     style="background-color:transparent;box-shadow:none;"--}}
                >
                    <div class="card-header"><h5 class="card-title">{{ trans('auth.register_baseline') }}</h5></div>
                    <div class="card-body p-3">
                        {!! Form::open(['route' => ['register'], 'method' => 'POST']) !!}
                        @honeypot
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
                        <div class="form-group">
                            <div class="input-group">
                                <input
                                        type="password"
                                        name="password"
                                        class="form-control {{ $errors && $errors->has('password') ? 'is-invalid' : '' }}"
                                        placeholder="{{ trans('users.password') }}"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            @if ($errors && $errors->has('password'))
                                <div class="text-danger text-sm">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input
                                        type="password"
                                        name="password_confirmation"
                                        class="form-control {{ $errors && $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                        placeholder="{{ trans('users.password_confirmation') }}"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            @if ($errors && $errors->has('password_confirmation'))
                                <div class="text-danger text-sm">{{ $errors->first('password_confirmation') }}</div>
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
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
