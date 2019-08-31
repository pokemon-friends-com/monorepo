@extends('layouts.pages.default')

@section('css')
    {{--<link class="main-stylesheet" href="{{ mix('assets/css/backend/users/profiles/form.css') }}" rel="stylesheet" type="text/css"/>--}}
@endsection

@section('js')
    {{--<script type="text/javascript" src="{{ mix('assets/js/backend/users/profiles/form.js') }}"></script>--}}
@endsection

@section('breadcrumbs')
    @include('partials.pages.default.breadcrumbs', ['breadcrumbs' => [
        route('backend.users.profile.index') => trans('profiles.title')
    ]])
@endsection

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="panel panel-default">
            <div class="panel-heading ">
                <div class="panel-title"><i class="fa fa-user"></i> {!! trans('profiles.title') !!}</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-10">

                        <h3>{{ trans('profiles.edit.title') }}</h3>

                        <p>
                            Editer votre profile.
                        </p>

                        {!! Form::open(['route' => ['backend.users.profile.update', $profile['data']['id']], 'id' => 'form-work', 'class' => 'form-horizontal', 'role' => 'form', 'autoprimary' => 'off', 'novalidate' => 'novalidate', 'method' => 'PUT']) !!}
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">{{ trans('users.locale') }}</label>
                            <div class="col-sm-9">
                                <select name="locale" class="full-width" data-init-plugin="select2">
                                    @foreach ($locales as $key)
                                        <option value="{{ $key }}" @if ($key === $profile['data']['locale']['language']) selected="selected" @endif>{{ trans('global.locale.' . $key) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">{{ trans('users.timezone') }}</label>
                            <div class="col-sm-9">
                                <select name="timezone" class="full-width" data-init-plugin="select2">
                                    @foreach ($timezones as $key)
                                        <option value="{{ $key }}" @if ($key === $profile['data']['locale']['timezone']) selected="selected" @endif>{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">{{ trans('profiles.family_situation') }}</label>
                            <div class="col-sm-9">
                                <select name="family_situation" class="full-width" data-init-plugin="select2">
                                    @foreach ($families_situations as $key => $trans)
                                        <option value="{{ $key }}" @if ($key === $profile['data']['family_situation']['key']) selected="selected" @endif>{{ $trans }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="maiden_name" class="col-sm-3 control-label">{{ trans('profiles.maiden_name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="maiden_name" placeholder="{{ trans('profiles.maiden_name') }}" name="maiden_name" value="{{ $profile['data']['maiden_name'] }}">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="birth_date" class="col-sm-3 control-label">{{ trans('profiles.birth_date') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="birth_date" placeholder="{{ trans('profiles.birth_date') }}" name="birth_date" value="{{ $profile['data']['birth_date'] }}">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="providers_tokens" class="col-sm-3 control-label">{{ trans('profiles.providers_tokens') }}</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <a class="btn btn-block btn-info" href="{{ route('login_provider', ['provider' => \obsession\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface::TWITTER]) }}">
                                            <span class="pull-left"><i class="fa fa-twitter"></i></span>
                                            <span class="bold">Lier Twitter</span>
                                        </a>
                                        <a class="btn btn-block btn-info" href="{{ route('login_provider', ['provider' => \obsession\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface::GOOGLE]) }}">
                                            <span class="pull-left"><i class="fa fa-google-plus"></i></span>
                                            <span class="bold">Lier Google+</span>
                                        </a>
                                        <a class="btn btn-block btn-info" href="{{ route('login_provider', ['provider' => \obsession\Infrastructure\Interfaces\Domain\Users\ProvidersTokens\ProvidersInterface::LINKEDIN]) }}">
                                            <span class="pull-left"><i class="fa fa-linkedin"></i></span>
                                            <span class="bold">Lier Linkedin</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                &nbsp;
                            </div>
                            <div class="col-sm-9">
                                <button class="btn btn-primary" type="submit">{{ trans('global.record') }}</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
