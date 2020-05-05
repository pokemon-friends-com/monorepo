@extends('auth.default')

@section('content')
<div class="card-body login-card-body">
    <p class="login-box-msg">{{ trans('auth.login') }}</p>
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
            <div class="icheck-primary">
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
    <div class="social-auth-links text-center mb-3">
        <hr/>
        <a href="{{ route('login_provider', ['provider' => \template\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface::GOOGLE]) }}" class="btn btn-block btn-default btn-google">
            <i class="fab fa-google mr-2"></i>{{ trans('auth.login_google') }}
        </a>
        <a href="{{ route('login_provider', ['provider' => \template\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface::TWITTER]) }}" class="btn btn-block btn-primary btn-twitter">
            <i class="fab fa-twitter mr-2"></i>{{ trans('auth.login_twitter') }}
        </a>
    </div>
    @if (Route::has('password.request'))
    <p class="mt-3 mb-1"><a href="{{ route('password.request') }}">{{ trans('auth.forgot_password') }}</a></p>
    @endif
    @if (Route::has('register'))
    <p class="mb-0"><a href="{{ route('register') }}" class="text-center">{{ trans('auth.register') }}</a></p>
    @endif
</div>
@endsection
