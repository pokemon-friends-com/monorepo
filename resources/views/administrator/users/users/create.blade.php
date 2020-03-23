@extends('administrator.default')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-users mr-2"></i>{{ trans('users.title') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('administrator.users.index') }}">
                                <i class="fa fa-users mr-2"></i>{{ trans('users.title') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('users.create.title') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {!! Form::open(['route' => ['administrator.users.store'], 'method' => 'POST']) !!}
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="first_name" class="col-sm-2 col-form-label">{{ trans('users.civility') }}</label>
                                <div class="col-sm-10">
                                    <select name="civility" id="civility" class="w-100 form-control">
                                        @foreach ($civilities as $key)
                                            <option
                                                    value="{{ $key }}"
                                                    @if ($key === old('civility')) selected="selected" @endif
                                            >
                                                {{ trans("users.civility.{$key}") }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="first_name" class="col-sm-2 col-form-label">{{ trans('users.first_name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control {{ $errors && $errors->has('first_name') ? 'is-invalid' : '' }}" id="first_name" placeholder="{{ trans('users.first_name') }}" name="first_name" value="{{ old('first_name') }}">
                                    @if ($errors && $errors->has('first_name'))
                                        <div class="text-danger text-sm">{{ $errors->first('first_name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_name" class="col-sm-2 col-form-label">{{ trans('users.last_name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control {{ $errors && $errors->has('last_name') ? 'is-invalid' : '' }}" id="last_name" placeholder="{{ trans('users.last_name') }}" name="last_name" value="{{ old('last_name') }}">
                                    @if ($errors && $errors->has('last_name'))
                                        <div class="text-danger text-sm">{{ $errors->first('last_name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role" class="col-sm-2 col-form-label">{{ trans('users.role') }}</label>
                                <div class="col-sm-10">
                                    <select name="role" id="role" class="w-100 form-control">
                                        @foreach ($roles as $key)
                                            <option value="{{ $key }}" @if ($key === old('role', 'customer')) selected="selected" @endif>
                                                {{ trans("users.role.{$key}") }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">{{ trans('users.email') }}</label>
                                <div class="col-sm-10">
                                    <input
                                            type="email"
                                            name="email"
                                            class="form-control {{ $errors && $errors->has('email') ? 'is-invalid' : '' }}"
                                            placeholder="{{ trans('users.email') }}"
                                            value="{{ old('email') }}"
                                    />
                                    @if ($errors && $errors->has('email'))
                                        <div class="text-danger text-sm">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="locale" class="col-sm-2 col-form-label">{{ trans('users.locale') }}</label>
                                <div class="col-sm-10">
                                    <select name="locale" id="locale" class="w-100 form-control">
                                        @foreach ($locales as $key)
                                            <option value="{{ $key }}" @if ($key === old('locale', $locale)) selected="selected" @endif>
                                                {{ trans("users.locale.{$key}") }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="timezone" class="col-sm-2 col-form-label">{{ trans('users.timezone') }}</label>
                                <div class="col-sm-10">
                                    <select name="timezone" id="timezone" class="w-100 form-control">
                                        @foreach ($timezones as $key)
                                            <option value="{{ $key }}" @if ($key === old('timezone', $timezone)) selected="selected" @endif>
                                                {{ $key }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">{{ trans('global.record') }}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@extends('administrator.default')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="panel panel-default">
            <div class="panel-heading ">
                <div class="panel-title"><i class="fa fa-users"></i> {!! trans('users.title') !!}</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-10">

                        <h3>{{ trans('users.create.title') }}</h3>

                        <p>
                            Complèter la fiche du nouvel utilisateur, à l'ajout, celui-ci recevra un courriel pour l'informer de la création de son compte.
                        </p>

                        {!! Form::open(['route' => 'administrator.users.store', 'id' => 'form-work', 'class' => 'form-horizontal', 'role' => 'form', 'autoprimary' => 'off', 'novalidate' => 'novalidate', 'data-user_identifier' => 0]) !!}
                            <div class="form-group required">
                                <label class="col-sm-3 control-label">{{ trans('users.locale') }}</label>
                                <div class="col-sm-9">
                                    <select name="locale" class="full-width" data-init-plugin="select2" data-disable-search="true">
                                        @foreach ($locales as $key)
                                            <option value="{{ $key }}" @if ($key === $locale) selected="selected" @endif>{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-3 control-label">{{ trans('users.timezone') }}</label>
                                <div class="col-sm-9">
                                    <select name="timezone" class="full-width" data-init-plugin="select2" data-disable-search="false">
                                        @foreach ($timezones as $key)
                                            <option value="{{ $key }}" @if ($key === $timezone) selected="selected" @endif>{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-3 control-label">{{ trans('users.role') }}</label>
                                <div class="col-sm-9">
                                    <select name="role" class="full-width" data-init-plugin="select2" data-disable-search="true">
                                        @foreach ($roles as $key => $trans)
                                            <option value="{{ $key }}">{{ $trans }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-3 control-label">{{ trans('users.civility') }}</label>
                                <div class="col-sm-9">
                                    <div class="radio radio-primary">
                                        @foreach ($civilities as $key => $trans)
                                        <input type="radio" value="{{ $key }}" name="civility" id="{{ $key }}">
                                        <label for="{{ $key }}">{{ $trans }}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="last_name" class="col-sm-3 control-label">{{ trans('users.last_name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="last_name" placeholder="{{ trans('users.last_name') }}" name="last_name" required="required" aria-required="true">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="first_name" class="col-sm-3 control-label">{{ trans('users.first_name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="first_name" placeholder="{{ trans('users.first_name') }}" name="first_name" required="required" aria-required="true">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="email" class="col-sm-3 control-label">{{ trans('global.email') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="email" placeholder="{{ trans('global.email') }}" name="email" required="required" aria-required="true">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-3">
                                    &nbsp;
                                </div>
                                <div class="col-sm-9">
                                    <button class="btn btn-primary" type="submit">{{ trans('global.record') }}</button>
                                    <a href="{{ route('administrator.users.index') }}" class="btn btn-default pull-right">{{ trans('global.back') }}</a>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
