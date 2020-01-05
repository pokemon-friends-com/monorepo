@extends('auth.default')

@section('content')
<div class="card-body login-card-body">
    <p class="login-box-msg">{{ trans('auth.forgot_password') }}</p>
    {!! Form::open(['route' => ['password.update'], 'method' => 'POST']) !!}
    @honeypot
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="input-group mb-3">
        <input
                type="text"
                name="email"
                class="form-control {{ $errors && $errors->has('email') ? 'is-invalid' : '' }}"
                placeholder="{{ trans('users.email') }}" value="{{ old('email') }}"
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
    <div class="input-group mb-3">
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
        @if ($errors && $errors->has('password_confirmation'))
        <div class="error mb-2">{{ $errors->first('password_confirmation') }}</div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary btn-block">
                {{ trans('users.leads.send') }}
            </button>
        </div>
    </div>
    {!! Form::close() !!}
    @if (Route::has('login'))
    <p class="mt-3 mb-1">
        <a href="{{ route('login') }}">{{ trans('auth.login') }}</a>
    </p>
    @endif
</div>
@endsection
