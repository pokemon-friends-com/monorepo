@extends('auth.default')

@section('content')
<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ trans('auth.register') }}</div>
                    <div class="card-body">
                        <p class="semi-bold no-margin">{{ trans('auth.register_baseline') }}</p>
                        {!! Form::open(['route' => ['register'], 'method' => 'POST']) !!}
                        @honeypot
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group form-group-default required">
                                    <label class="control-label">{{ trans('users.civility') }}</label>
                                    <select name="civility" id="civility" class="form-control">
                                        @foreach ($civilities as $key => $trans)
                                        <option
                                                value="{{ $key }}"
                                                @if (Auth::check() && $key === Auth::user()->civility) selected="selected" @endif
                                        >
                                            {{ $trans }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default required">
                                    <label class="control-label">{{ trans('users.first_name') }}</label>
                                    <input
                                            type="text"
                                            name="first_name"
                                            class="form-control"
                                            placeholder="{{ trans('users.first_name') }}"
                                            value="{{ old('first_name', Auth::check() ? Auth::user()->first_name : '') }}"
                                    />
                                    @if ($errors && $errors->has('first_name'))
                                    <span class="error">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default required">
                                    <label class="control-label">{{ trans('users.last_name') }}</label>
                                    <input
                                            type="text"
                                            name="last_name"
                                            class="form-control"
                                            placeholder="{{ trans('users.last_name') }}"
                                            value="{{ old('last_name', Auth::check() ? Auth::user()->last_name : '') }}"
                                    />
                                    @if ($errors && $errors->has('last_name'))
                                    <span class="error">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-default required">
                            <label class="control-label">{{ trans('users.email') }}</label>
                            <input
                                    type="text"
                                    name="email"
                                    class="form-control"
                                    placeholder="{{ trans('users.email') }}"
                                    value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"
                            />
                            @if ($errors && $errors->has('email'))
                            <span class="error">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
                                    <label class="control-label">{{ trans('users.password') }}</label>
                                    <input
                                            type="password"
                                            name="password"
                                            class="form-control"
                                            placeholder="{{ trans('users.password') }}"
                                    />
                                    @if ($errors && $errors->has('password'))
                                    <span class="error">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default required">
                                    <label class="control-label">{{ trans('users.password_confirmation') }}</label>
                                    <input
                                            type="password"
                                            name="password_confirmation"
                                            class="form-control"
                                            placeholder="{{ trans('users.password_confirmation') }}"
                                    />
                                    @if ($errors && $errors->has('password_confirmation'))
                                    <span class="error">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="sm-p-t-10 clearfix">
                            <p class="pull-left small hint-text m-t-10 font-arial">{{ trans('users.leads.certify') }}</p>
                            <button type="submit" class="btn btn-primary pull-right xs-pull-left">
                                {{ trans('users.leads.send') }}
                            </button>
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
