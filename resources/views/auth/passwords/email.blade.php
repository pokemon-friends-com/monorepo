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

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ trans('auth.forgot_password') }}</div>
                        <div class="card-body">
                            {!! Form::open(['route' => ['password.email'], 'method' => 'POST']) !!}


                            <div class="form-group form-group-default required">
                                <label class="control-label">{{ trans('users.email') }}</label>
                                <input type="text" name="email" class="form-control" placeholder="{{ trans('users.email') }}" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"/>
                                @if ($errors && $errors->has('email'))
                                    <span class="error">{{ $errors->first('email') }}</span>
                                @endif
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
