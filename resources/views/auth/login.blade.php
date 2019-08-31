@extends('layouts.gameforest.landings')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h5 class="card-title">{{ trans('auth.login') }}</h5>
                        </div>
                        <div class="card-body p-3">
                            {!! Form::open(['route' => ['login'], 'method' => 'POST']) !!}


                                @csrf


                                <input type="text" name="email" class="form-control mb-2" placeholder="{{ trans('users.email') }}" value="{{ old('email') }}"/>
                                @if ($errors && $errors->has('email'))
                                    <div class="error mb-2">{{ $errors->first('email') }}</div>
                                @endif


                                <input type="password" name="password" class="form-control mb-2" placeholder="{{ trans('users.password') }}"/>
                                @if ($errors && $errors->has('password'))
                                    <div class="error mb-2">{{ $errors->first('password') }}</div>
                                @endif


                                <div class="form-group form-check custom-control custom-checkbox mt-1">
                                    <input type="checkbox" class="custom-control-input" id="check" name="remember" {{ old('remember') ? 'checked' : '' }}/>
                                    <label class="custom-control-label" for="check">{{ trans('auth.remember_me') }}</label>
                                </div>


                                <button type="submit" class="btn btn-primary btn-block">{{ trans('auth.login') }}</button>


                            {!! Form::close() !!}
                            <div class="separator mt-4"><span>{{ trans('auth.forgot_password') }}</span></div>
                            @if (Route::has('password.request'))
                                <a class="btn btn-default btn-block" href="{{ route('password.request') }}">
                                    {{ trans('auth.forgot_password') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
