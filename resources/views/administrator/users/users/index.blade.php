@extends('administrator.default')

@section('content')
<nav class="bg-white border-bottom" aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><i class="fa fa-users mr-2"></i>{{ trans('users.title') }}</li>
        </ol>
    </div>
</nav>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    {!! Form::open(['route' => ['administrator.users.index'], 'method' => 'GET']) !!}
                    <div class="card-header">{{ trans('global.filters') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <input type="text" class="form-control {{ $errors && $errors->has('full_name') ? 'is-invalid' : '' }}" id="full_name" placeholder="{{ trans('users.full_name') }}" name="full_name" value="{{ old('full_name', $f_full_name) }}">
                            @if ($errors && $errors->has('full_name'))
                                <div class="text-danger text-sm">{{ $errors->first('full_name') }}</div>
                            @endif
                        </div>
                        <div class="form-group row">
                            <input type="text" class="form-control {{ $errors && $errors->has('email') ? 'is-invalid' : '' }}" id="email" placeholder="{{ trans('users.email') }}" name="email" value="{{ old('email', $f_email) }}">
                            @if ($errors && $errors->has('email'))
                                <div class="text-danger text-sm">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary btn-sm" type="submit">{{ trans('global.filter') }}</button>
                    </div>
                    {{ Form::close() }}
                </div>
                <div class="card">
                    <div class="card-header">{{ trans('global.actions') }}</div>
                    <div class="card-body">
                        <a href="{{ route('administrator.users.export', ['full_name' => $f_full_name, 'email' => $f_email]) }}" class="btn btn-secondary btn-sm btn-block elevation-1">
                            <i class="fa fa-file-excel mr-2"></i>{!! trans('global.export') !!}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-9">
                @if ($users['meta']['pagination']['total'])
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <a href="{{ route('administrator.users.create') }}" class="btn btn-primary btn-sm elevation-1">
                                <i class="fa fa-user-plus mr-2"></i>{!! trans('global.add') !!}
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center w-25">{!! trans('users.civility_name') !!}</th>
                                <th class="text-center w-30">{!! trans('users.email') !!}</th>
                                <th class="text-center w-40">{!! trans('global.actions') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users['data'] as $user)
                            <tr>
                                <td class="align-middle text-center">
                                    <a href="{{ route('administrator.users.show', ['user' => $user['identifier']]) }}">{{ $user['civility_name'] }}</a>
                                </td>
                                <td class="align-middle text-center"><a href="mailto:{{ $user['email'] }}">{{ $user['email'] }}</a></td>
                                <td class="align-middle text-right">
                                    @canImpersonate
                                    @if ($user['impersonation']['can_be_impersonated'])
                                    <a href="{{ route('impersonate', $user['id']) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-user-secret mr-2"></i>{{ trans('users.impersonate') }}
                                    </a>
                                    @endif
                                    @endCanImpersonate
                                    <a href="{{ route('administrator.users.edit', ['user' => $user['identifier']]) }}"
                                       class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit mr-2"></i>{!! trans('global.edit') !!}
                                    </a>
                                    <button data-target="#confirm_user_deletion_{{ $user['identifier'] }}"
                                            data-toggle="modal" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash mr-2"></i>{!! trans('global.delete') !!}
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {!! trans('users.index_total_users', ['total_user' => $users['meta']['pagination']['total']]) !!}
                        {!! adminlte_pagination($users['meta']['pagination']['count'], $users['meta']['pagination']['total'], $users['meta']['pagination']['current_page'], $users['meta']['pagination']['per_page']) !!}
                    </div>
                </div>
                @else
                <div class="box-body">
                    <div class="alert alert-info alert-dismissible alert-module">
                        <h4><i class="icon fa fa-info-circle mr-2"></i>{!! trans('users.index_no_data_title') !!}</h4>
                        {!! trans('users.index_no_data_description') !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@foreach ($users['data'] as $user)
    <div class="modal fade show" id="confirm_user_deletion_{{ $user['identifier'] }}" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('users.delete_message', ['username' => $user['civility_name']]) }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ trans('users.delete_message', ['username' => $user['civility_name']]) }}</p>
                </div>
                <div class="modal-footer justify-content-between">
                    {!! Form::open(['route' => ['administrator.users.destroy', $user['identifier']], 'method' => 'DELETE']) !!}
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash mr-2"></i>{!! trans('global.delete') !!}
                    </button>
                    {!! Form::close() !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('global.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
