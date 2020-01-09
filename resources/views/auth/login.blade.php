@extends('auth.default')

@section('content')
<div class="card-body login-card-body">
    <p class="login-box-msg">{{ trans('auth.login') }}</p>
    {!! Form::open(['route' => ['login'], 'method' => 'POST']) !!}
    @honeypot
    <div class="input-group mb-3">
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
        @if ($errors && $errors->has('email'))
        <div class="error mb-2">{{ $errors->first('email') }}</div>
        @endif
    </div>
    <div class="input-group mb-3">
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
        @if ($errors && $errors->has('password'))
        <div class="error mb-2">{{ $errors->first('password') }}</div>
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
    @if (Route::has('password.request'))
    <p class="mb-1">
        <a href="{{ route('password.request') }}">
            {{ trans('auth.forgot_password') }}
        </a>
    </p>
    @endif
    @if (Route::has('register'))
    <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">
            {{ trans('auth.register') }}
        </a>
    </p>
    @endif
</div>
@endsection
