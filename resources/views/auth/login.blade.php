@extends('default')

@section('content')
<section class="px-2 px-md-0 py-md-7" >
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
                <div class="card mb-0 border-0"
{{--                     style="background-color:transparent;box-shadow:none;"--}}
                >
                    <div class="card-body p-3">

                        <a href="{{ route('login_provider', ['provider' => \template\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface::GOOGLE]) }}" class="btn btn-social btn-block btn-google-plus"><i class="fab fa-google mr-1"></i>{{ trans('auth.login_google') }}</a>
                        <a href="{{ route('login_provider', ['provider' => \template\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface::TWITTER]) }}" class="btn btn-social btn-block btn-twitter"><i class="fab fa-twitter mr-1"></i>{{ trans('auth.login_twitter') }}</a>

                        <div class="separator mt-4"><span>Sign in with your username/password</span></div>

                        {!! Form::open(['route' => ['login'], 'method' => 'POST']) !!}
                        @honeypot
                        <div class="form-group">
                            <div class="input-group">
                                <input
                                        type="text"
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
                        <div class="row">
                            <div class="col-7">
                                <div>
                                    <input
                                            type="checkbox"
                                            id="remember"
                                            name="remember"
                                            {{ old('remember') ? 'checked' : '' }}
                                    />
                                    <label for="remember">{{ trans('auth.remember_me') }}</label>
                                </div>
                            </div>
                            <div class="col-5">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ trans('auth.login') }}
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="card mt-2 mb-0 border-0"
                        {{--                     style="background-color:transparent;box-shadow:none;"--}}
                >
                    <div class="card-body p-3">
                        @if (Route::has('login'))
                            <a href="{{ route('register') }}" class="btn btn-secondary btn-block d-md-none">{{ trans('auth.register') }}</a>
                        @endif
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="btn btn-outline-secondary btn-block">{{ trans('auth.forgot_password') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
