@extends('layouts.gameforest.landings')

@section('content')
    <nav class="bg-white border-bottom" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('login') }}">{{ trans('auth.login') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('auth.forgot_password') }}</li>
            </ol>
        </div>
    </nav>
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ trans('auth.forgot_password') }}</div>
                        <div class="card-body">
                            {!! Form::open(['route' => ['password.update'], 'method' => 'POST']) !!}


                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group form-group-default required">
                                    <label class="control-label">{{ trans('users.email') }}</label>
                                    <input type="text" name="email" class="form-control" placeholder="{{ trans('users.email') }}" value="{{ old('email') }}"/>
                                    @if ($errors && $errors->has('email'))
                                        <span class="error">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-group-default required">
                                            <label class="control-label">{{ trans('users.password') }}</label>
                                            <input type="password" name="password" class="form-control" placeholder="{{ trans('users.password') }}"/>
                                            @if ($errors && $errors->has('password'))
                                                <span class="error">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-group-default required">
                                            <label class="control-label">{{ trans('users.password_confirmation') }}</label>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('users.password_confirmation') }}"/>
                                            @if ($errors && $errors->has('password_confirmation'))
                                                <span class="error">{{ $errors->first('password_confirmation') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="sm-p-t-10 clearfix">
                                    <input type="submit" value="{{ trans('leads.send') }}" name="submit" class="btn btn-primary font-montserrat all-caps fs-12 pull-right xs-pull-left" />
                                </div>
                                <div class="clearfix"></div>


                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
