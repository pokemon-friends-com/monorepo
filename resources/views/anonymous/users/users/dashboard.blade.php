@extends('anonymous.default')

@section('content')
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">{{ trans('global.home') }}</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0">Site en construction</h5>
                    </div>
                    <div class="card-body">
                        <p>Le site n'est pas disponible pour le moment.</p>
                        @if (Route::has('register'))
                            <a class="card-link" href="{{ route('register') }}">{{ trans('auth.register') }}</a>
                        @endif
                        @if (Route::has('login'))
                            <a class="card-link" href="{{ route('login') }}">{{ trans('auth.login') }}</a>
                        @endif
                        @if (Route::has('anonymous.terms'))
                            <a class="card-link" href="{{ route('anonymous.terms') }}">{{ trans('global.terms') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
