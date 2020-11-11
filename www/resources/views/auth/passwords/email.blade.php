@extends('default')

@section('content')
    <section class="px-2 px-md-0 py-md-7" >
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
                    <div class="card mb-0 border-0"
                            {{--                     style="background-color:transparent;box-shadow:none;"--}}
                    >
                        <div class="card-header"><h5 class="card-title">{{ trans('auth.forgot_password') }}</h5></div>
                        <div class="card-body p-3">

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
                        </div>
                    </div>
                    <div class="card mt-2 mb-0 border-0"
                            {{--                     style="background-color:transparent;box-shadow:none;"--}}
                    >
                        <div class="card-body p-3">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-block">{{ trans('login') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
