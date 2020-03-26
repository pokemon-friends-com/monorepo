@extends('customer.default')

{{--@section('js')--}}
{{--    <script type="text/javascript">--}}
{{--      (function (W, D, $) {--}}
{{--        $(D).ready(function() {--}}

{{--          $('.select2').select2({--}}
{{--            theme: 'bootstrap4'--}}
{{--          });--}}

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
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-user mr-2"></i>{{ trans('users.profiles.edit.title') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('anonymous.dashboard') }}">
                                {{ trans('global.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa fa-user mr-2"></i>{{ trans('users.profiles.edit.title') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    {!! Form::open(['route' => ['customer.users.profiles.update', $profile['data']['user']['identifier']], 'class' => 'form-horizontal', 'role' => 'form', 'autoprimary' => 'off', 'novalidate' => 'novalidate', 'method' => 'PUT']) !!}
                    <div class="card">
                        <div class="card-header">
                            Join the friend code list
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="friend_code" class="col-sm-3 col-form-label text-sm-right">{{ trans('users.profiles.friend_code') }}</label>
                                <div class="col-sm-9">
                                    <input
                                            type="text"
                                            class="form-control"
                                            id="friend_code"
                                            placeholder="{{ trans('users.profiles.friend_code') }}"
                                            name="friend_code"
                                            value="{{ $profile['data']['friend_code'] }}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="team_color" class="col-sm-3 col-form-label text-sm-right">{{ trans('users.profiles.team_color') }}</label>
                                <div class="col-sm-9">
                                    <select name="team_color" id="team_color" class="select2 w-100 form-control">
                                        @foreach ($teams as $key)
                                            <option value="{{ $key }}" @if ($key === $profile['data']['team_color']) selected="selected" @endif>
                                                {{ trans("users.profiles.teams_colors.{$key}") }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Optional data to field
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="locale" class="col-sm-3 col-form-label text-sm-right">{{ trans('users.locale') }}</label>
                                <div class="col-sm-9">
                                    <select name="locale" id="locale" class="select2 w-100 form-control">
                                        @foreach ($locales as $key)
                                            <option value="{{ $key }}" @if ($key === $profile['data']['locale']['language']) selected="selected" @endif>
                                                {{ trans("users.locale.{$key}") }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="timezone" class="col-sm-3 col-form-label text-sm-right">{{ trans('users.timezone') }}</label>
                                <div class="col-sm-9">
                                    <select name="timezone" id="timezone" class="select2 w-100 form-control">
                                        @foreach ($timezones as $key)
                                            <option value="{{ $key }}" @if ($key === $profile['data']['locale']['timezone']) selected="selected" @endif>{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="first_name" class="col-sm-3 col-form-label text-sm-right">{{ trans('users.civility') }}</label>
                                <div class="col-sm-9">
                                    <select name="civility" id="civility" class="select2 w-100 form-control">
                                        @foreach ($civilities as $key => $trans)
                                            <option
                                                    value="{{ $key }}"
                                                    @if (Auth::check() && $key === $profile['data']['user']['civility']) selected="selected" @endif
                                            >
                                                {{ $trans }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="alert alert-info">
                                Les informations suivante ne sont pas public (affichées sur internet) et ne sont pas transmisent à des services tiers.
                            </div>
                            <div class="form-group row">
                                <label for="first_name" class="col-sm-3 col-form-label text-sm-right">{{ trans('users.first_name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="first_name" placeholder="{{ trans('users.first_name') }}" name="first_name" value="{{ $profile['data']['user']['first_name'] }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_name" class="col-sm-3 col-form-label text-sm-right">{{ trans('users.last_name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="last_name" placeholder="{{ trans('users.last_name') }}" name="last_name" value="{{ $profile['data']['user']['last_name'] }}">
                                </div>
                            </div>
{{--                            <div class="form-group row">--}}
{{--                                <label for="family_situation" class="col-sm-3 col-form-label text-sm-right">{{ trans('users.profiles.family_situation') }}</label>--}}
{{--                                <div class="col-sm-9">--}}
{{--                                    <select name="family_situation" class="select2 w-100 form-control">--}}
{{--                                        @foreach ($families_situations as $key => $trans)--}}
{{--                                            <option value="{{ $key }}" @if ($key === $profile['data']['family_situation']['key']) selected="selected" @endif>{{ $trans }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label for="maiden_name" class="col-sm-3 col-form-label text-sm-right">{{ trans('users.profiles.maiden_name') }}</label>--}}
{{--                                <div class="col-sm-9">--}}
{{--                                    <input type="text" class="form-control" id="maiden_name" placeholder="{{ trans('users.profiles.maiden_name') }}" name="maiden_name" value="{{ $profile['data']['maiden_name'] }}">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label for="birth_date" class="col-sm-3 col-form-label text-sm-right">{{ trans('users.profiles.birth_date') }}</label>--}}
{{--                                <div class="col-sm-9">--}}
{{--                                    <input type="text" class="form-control" id="birth_date" placeholder="{{ trans('users.profiles.birth_date') }}" name="birth_date" value="{{ $profile['data']['birth_date'] }}" data-target="#birth_date" data-toggle="datetimepicker">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label for="providers_tokens" class="col-sm-3 col-form-label text-sm-right">{{ trans('users.profiles.providers_tokens') }}</label>--}}
{{--                                <div class="col-sm-9">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-4">--}}
{{--                                            <a class="btn btn-block btn-info" href="{{ route('login_provider', ['provider' => \template\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface::TWITTER]) }}">--}}
{{--                                                <span class="pull-left"><i class="fab fa-twitter"></i></span>--}}
{{--                                                <span class="bold">Lier Twitter</span>--}}
{{--                                            </a>--}}
{{--                                            <a class="btn btn-block btn-info" href="{{ route('login_provider', ['provider' => \template\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface::GOOGLE]) }}">--}}
{{--                                                <span class="pull-left"><i class="fab fa-google-plus"></i></span>--}}
{{--                                                <span class="bold">Lier Google+</span>--}}
{{--                                            </a>--}}
{{--                                            <a class="btn btn-block btn-info" href="{{ route('login_provider', ['provider' => \template\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface::LINKEDIN]) }}">--}}
{{--                                                <span class="pull-left"><i class="fab fa-linkedin"></i></span>--}}
{{--                                                <span class="bold">Lier Linkedin</span>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">{{ trans('global.record') }}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> Information</h5>
                        Il n'est pas encore possible de changer son adresse email, mais vous pouvez en faire la demande sur <a href="{{ route('anonymous.contact.index') }}">la page de contact</a>.
                    </div>
                </div>
                <div class="col-12">
                    {!! Form::open(['route' => ['customer.users.update-password', $profile['data']['user']['identifier']], 'class' => 'form-horizontal', 'role' => 'form', 'autoprimary' => 'off', 'novalidate' => 'novalidate', 'method' => 'PUT']) !!}
                    <div class="card">
                        <div class="card-header">
                            Update password
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="current_password"
                                       class="col-sm-3 col-form-label text-sm-right">{{ trans('users.current_password') }}</label>
                                <div class="col-sm-9">
                                    <input
                                            type="password"
                                            name="current_password"
                                            class="form-control"
                                            id="current_password"
                                            placeholder="{{ trans('users.current_password') }}"
                                            value=""/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password"
                                       class="col-sm-3 col-form-label text-sm-right">{{ trans('users.password') }}</label>
                                <div class="col-sm-9">
                                    <input
                                            type="password"
                                            name="password"
                                            class="form-control"
                                            id="password"
                                            placeholder="{{ trans('users.password') }}"
                                            value=""/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_confirmation"
                                       class="col-sm-3 col-form-label text-sm-right">{{ trans('users.password_confirmation') }}</label>
                                <div class="col-sm-9">
                                    <input
                                            type="password"
                                            name="password_confirmation"
                                            class="form-control"
                                            id="password_confirmation"
                                            placeholder="{{ trans('users.password_confirmation') }}"
                                            value=""/>
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
