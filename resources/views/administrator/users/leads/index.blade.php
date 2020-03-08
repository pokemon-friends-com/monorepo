@extends('administrator.default')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="far fa-user-circle"></i> {{ trans('users.leads.title') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">
                        <i class="far fa-user-circle"></i> {{ trans('users.leads.title') }}
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
                @if ($leads['meta']['pagination']['total'])
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center w-15">{!! trans('global.id') !!}</th>
                                    <th class="text-center w-5"><i class="far fa-user-circle" title="{{ trans('users.leads.transformed_user') }}"></i></th>
                                    <th class="text-center w-25">{!! trans('users.civility_name') !!}</th>
                                    <th class="text-center w-25">{!! trans('users.email') !!}</th>
                                    <th class="text-center w-30">{!! trans('global.actions') !!}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leads['data'] as $lead)
                                <tr id="lead_{{ $lead['id'] }}">
                                    <td class="align-middle text-center">{{ $lead['identifier'] }}</td>
                                    <td class="align-middle text-center">
                                        @if ($lead['user']['is_user'])
                                        <i class="far fa-user-circle" title="{{ trans('users.leads.transformed_user') }}"></i>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($lead['user']['is_user'])
                                        <a href="{{ route('administrator.users.show', ['id' => $lead['user']['identifier']]) }}">
                                            {!! $lead['civility_name'] !!}
                                        </a>
                                        @else
                                        {!! $lead['civility_name'] !!}
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">{{ $lead['email'] }}</td>
                                    <td class="align-middle text-center">
                                        @if (!$lead['user']['is_user'])
                                        <button data-target="#confirm_lead_transformation_{{ $lead['id'] }}" data-toggle="modal" class="btn btn-primary btn-sm">
                                            <i class="fa fa-user"></i> {!! trans('users.leads.button.transform_into_user') !!}
                                        </button>
                                        @else
                                        <span>{{ trans('global.no_action') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {!! trans('users.leads.index_total_leads', ['total_lead' => $leads['meta']['pagination']['total']]) !!}
                        {!! adminlte_pagination($leads['meta']['pagination']['count'], $leads['meta']['pagination']['total'], $leads['meta']['pagination']['current_page'], $leads['meta']['pagination']['per_page']) !!}
                    </div>
                </div>
                @else
                <div class="box-body">
                    <div class="alert alert-info alert-dismissible alert-module">
                        <h4><i class="icon fa fa-info-circle"></i> {!! trans('users.leads.index_no_data_title') !!}</h4>
                        {!! trans('users.leads.index_no_data_description') !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@foreach ($leads['data'] as $lead)
<div class="modal fade show" id="confirm_lead_transformation_{{ $lead['id'] }}" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('users.leads.button.transform_into_user') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ trans('users.leads.transform_message', ['username' => $lead['civility_name']]) }}</p>
            </div>
            <div class="modal-footer justify-content-between">
                {!! Form::open(['route' => ['administrator.users.leads.update', $lead['id']], 'method' => 'PUT']) !!}
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-user"></i> {!! trans('users.leads.button.transform_into_user') !!}
                </button>
                {!! Form::close() !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('global.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
