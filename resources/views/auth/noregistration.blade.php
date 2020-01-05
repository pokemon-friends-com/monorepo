@extends('auth.default')

{{--@todo xABE : Remove at the end of beta--}}

@section('content')
    <div class="card-body login-card-body">
        <p class="login-box-msg">{{ trans('auth.register') }}</p>
        <p>Les inscriptions ne sont pas ouverte durant la période de beta privée.</p>
        @if (Route::has('login'))
            <p class="mt-3 mb-1">
                <a href="{{ route('login') }}">
                    {{ trans('auth.login') }}
                </a>
            </p>
        @endif
    </div>
@endsection
