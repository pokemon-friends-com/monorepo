@extends('administrator.default')

{{--@section('breadcrumbs')--}}
{{--    @include('partials.pages.default.breadcrumbs', ['breadcrumbs' => [--}}
{{--        route('administrator.users.index') => trans('users.title'),--}}
{{--        route('administrator.users.show', ['id' => $user['data']['id']]) => trans('users.show.title', ['username' => $user['data']['full_name']]),--}}
{{--    ]])--}}
{{--@endsection--}}

{{--@section('sidebar')--}}
{{--    <a href="{{ route('administrator.users.create') }}" class="btn btn-primary btn-block btn-compose m-b-30">--}}
{{--        <i class="fa fa-plus"></i> {{ trans('global.add') }}--}}
{{--    </a>--}}
{{--@endsection--}}

@section('content')
    <div class="panel panel-transparent">
        <div class="panel-heading ">
            <div class="panel-title"><i class="fa fa-users"></i> {!! trans('users.title') !!}</div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-10">
                    <h3>{{ $user['data']['civility_name'] }}</h3>
                    <div class="row">
                        <label class="col-sm-3">{{ trans('users.role') }}</label>
                        <div class="col-sm-9">
                            {{ $user['data']['role']['trans'] }}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3">{{ trans('users.civility') }}</label>
                        <div class="col-sm-9">
                            {{ $user['data']['civility']['trans'] }}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3">{{ trans('users.last_name') }}</label>
                        <div class="col-sm-9">
                            {{ $user['data']['last_name'] }}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3">{{ trans('users.first_name') }}</label>
                        <div class="col-sm-9">
                            {{ $user['data']['first_name'] }}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3">{{ trans('global.email') }}</label>
                        <div class="col-sm-9">
                            {{ $user['data']['email'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
