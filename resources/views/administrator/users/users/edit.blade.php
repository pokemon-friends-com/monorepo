@extends('administrator.default')

{{--@section('js')--}}
{{--    <script type="text/javascript">--}}
{{--      (function (W, D, $) {--}}
{{--        $(D).ready(function() {--}}
{{--          $('#birth_date').datetimepicker({--}}
{{--            locale: $('meta[name="locale"]').attr('content'),--}}
{{--            format: 'L'--}}
{{--          });--}}
{{--        });--}}
{{--      })(window, document, jQuery);--}}
{{--    </script>--}}
{{--@endsection--}}

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
                    <li class="breadcrumb-item active">
                        {{ $user['data']['civility_name'] }}
                    </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {!! Form::open(['route' => ['administrator.users.update', $user['data']['identifier']], 'method' => 'PUT']) !!}
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="friend_code" class="col-sm-2 col-form-label">{{ trans('users.profiles.friend_code') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control {{ $errors && $errors->has('friend_code') ? 'is-invalid' : '' }}" id="friend_code" placeholder="{{ trans('users.profiles.friend_code') }}" name="friend_code" value="{{ $user['data']['profile']['friend_code'] }}">
                                @if ($errors && $errors->has('friend_code'))
                                    <div class="text-danger text-sm">{{ $errors->first('friend_code') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="team_color" class="col-sm-2 col-form-label">{{ trans('users.profiles.team_color') }}</label>
                            <div class="col-sm-10">
                                <select name="team_color" id="team_color" class="w-100 form-control">
                                    @foreach ($teams as $key)
                                        <option value="{{ $key }}" @if ($key === $user['data']['profile']['team_color']) selected="selected" @endif>
                                            {{ trans("users.profiles.teams_colors.{$key}") }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="first_name" class="col-sm-2 col-form-label">{{ trans('users.civility') }}</label>
                            <div class="col-sm-10">
                                <select name="civility" id="civility" class="w-100 form-control">
                                    @foreach ($civilities as $key)
                                        <option
                                                value="{{ $key }}"
                                                @if (Auth::check() && $key === $user['data']['civility']) selected="selected" @endif
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
                                <input type="text" class="form-control {{ $errors && $errors->has('first_name') ? 'is-invalid' : '' }}" id="first_name" placeholder="{{ trans('users.first_name') }}" name="first_name" value="{{ $user['data']['first_name'] }}">
                                @if ($errors && $errors->has('first_name'))
                                    <div class="text-danger text-sm">{{ $errors->first('first_name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-sm-2 col-form-label">{{ trans('users.last_name') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control {{ $errors && $errors->has('last_name') ? 'is-invalid' : '' }}" id="last_name" placeholder="{{ trans('users.last_name') }}" name="last_name" value="{{ $user['data']['last_name'] }}">
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
                                        <option value="{{ $key }}" @if ($key === $user['data']['role']['key']) selected="selected" @endif>
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
                                        value="{{ old('email', $user['data']['email']) }}"
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
                                        <option value="{{ $key }}" @if ($key === $user['data']['locale']['language']) selected="selected" @endif>
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
                                        <option value="{{ $key }}" @if ($key === $user['data']['locale']['timezone']) selected="selected" @endif>{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{--                        <div class="form-group row">--}}
                        {{--                            <label for="birth_date" class="col-sm-2 col-form-label">{{ trans('users.profiles.birth_date') }}</label>--}}
                        {{--                            <div class="col-sm-10">--}}
                        {{--                                <input type="text" class="form-control" id="birth_date" placeholder="{{ trans('users.profiles.birth_date') }}" name="birth_date" value="{{ $user['data']['profile']['birth_date'] }}" data-target="#birth_date" data-toggle="datetimepicker">--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="form-group row">
                            <label for="family_situation" class="col-sm-2 col-form-label">{{ trans('users.profiles.family_situation') }}</label>
                            <div class="col-sm-10">
                                <select name="family_situation" class="w-100 form-control">
                                    @foreach ($families_situations as $key => $trans)
                                        <option value="{{ $key }}" @if ($key === $user['data']['profile']['family_situation']['key']) selected="selected" @endif>{{ $trans }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="maiden_name" class="col-sm-2 col-form-label">{{ trans('users.profiles.maiden_name') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control {{ $errors && $errors->has('maiden_name') ? 'is-invalid' : '' }}" id="maiden_name" placeholder="{{ trans('users.profiles.maiden_name') }}" name="maiden_name" value="{{ $user['data']['profile']['maiden_name'] }}">
                                @if ($errors && $errors->has('maiden_name'))
                                    <div class="text-danger text-sm">{{ $errors->first('maiden_name') }}</div>
                                @endif
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
