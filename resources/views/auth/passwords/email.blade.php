@extends('auth.default')

@section('content')
<div class="card-body login-card-body">
    <p class="login-box-msg">{{ trans('auth.forgot_password') }}</p>
    @if (session('status'))
        <div class="alert alert-success text-sm" role="alert">{{ session('status') }}</div>
    @endif
    {!! Form::open(['route' => ['password.email'], 'method' => 'POST']) !!}
    @honeypot
    <div class="form-group">
        <div class="input-group">
            <input
                    type="text"
                    name="email"
                    class="form-control {{ $errors && $errors->has('email') ? 'is-invalid' : '' }}"
                    placeholder="{{ trans('users.email') }}"
                    value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"
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
        <a href="{{ route('login') }}">
            {{ trans('auth.login') }}
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
