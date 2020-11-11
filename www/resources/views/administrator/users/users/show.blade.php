@extends('administrator.default')

@section('content')
<nav class="bg-white border-bottom" aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('administrator.users.index') }}"><i class="fa fa-users mr-2"></i>{{ trans('users.title') }}</a></li>
            <li class="breadcrumb-item active">{{ $user['data']['civility_name'] }}</li>
        </ol>
    </div>
</nav>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-2">
                        <div class="card-title">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#user" data-toggle="tab">{{ trans('users.title') }}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#reports" data-toggle="tab">{{ trans('users.reports.title') }}</a></li>
                            </ul>
                        </div>
                        <div class="card-tools">
                            <a href="{{ route('administrator.users.edit', ['user' => $user['data']['identifier']]) }}" class="btn btn-tool"><i class="fa fa-edit"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">


                            <div class="active tab-pane" id="user">
                                <div class="row">
                                    <div class="col-12">
                                        <h3>{{ $user['data']['civility_name'] }}</h3>
                                        <div class="row">
                                            <label class="col-sm-3">{{ trans('users.role') }}</label>
                                            <div class="col-sm-9">{{ $user['data']['role']['trans'] }}</div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-3">{{ trans('users.email') }}</label>
                                            <div class="col-sm-9"><a href="mailto:{{ $user['data']['email'] }}">{{ $user['data']['email'] }}</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane" id="reports">
                                <div class="timeline timeline-inverse">

{{--                                    When no report at all --}}
                                    <div class="time-label"><span class="bg-info">{{ trans('global.today') }}</span></div>
                                    <div>
                                        <i class="fas fa-info bg-info"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock mr-2"></i>{{ trans('global.today') }}</span>
                                            <h3 class="timeline-header border-0">{{ trans('users.reports.no_report') }}</h3>
                                        </div>
                                    </div>
{{--                                    !When no report at all --}}

                                    <div class="time-label"><span class="bg-info">{{ $user['data']['created_at'] }}</span></div>
                                    <div>
                                        <i class="fas fa-info bg-info"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock mr-2"></i>{{ $user['data']['created_at'] }}</span>
                                            <h3 class="timeline-header border-0">{{ trans('auth.registration') }}</h3>
                                        </div>
                                    </div>

                                    <div><i class="far fa-clock bg-gray"></i></div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
