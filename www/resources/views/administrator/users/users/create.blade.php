@extends('administrator.default')

@section('content')
<nav class="bg-white border-bottom" aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('administrator.users.index') }}"><i class="fa fa-users mr-2"></i>{{ trans('users.title') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('users.create.title') }}</li>
        </ol>
    </div>
</nav>
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
