@extends('layouts.pages.default')

@section('breadcrumbs')
    @include('partials.pages.default.breadcrumbs', ['breadcrumbs' => [
        route('backend.leads.index') => trans('leads.title'),
    ]])
@endsection

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="panel panel-transparent">
            <div class="panel-heading ">
                <div class="panel-title"><i class="fa fa-user-circle-o"></i> {!! trans('leads.title') !!}</div>
            </div>
            <div class="panel-body">
                @if ($leads['meta']['pagination']['total'])
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed" id="condensedTable">
                            <thead>
                            <tr>
                                <th style="width:15%" class="text-center">{!! trans('global.id') !!}</th>
                                <th style="width:5%" class="text-center">
                                    <i class="fa fa-user-circle-o" title="{{ trans('leads.transformed_user') }}"></i>
                                </th>
                                <th style="width:25%" class="text-center">{!! trans('global.civility_name') !!}</th>
                                <th style="width:25%" class="text-center">{!! trans('global.email') !!}</th>
                                <th style="width:30%" class="text-center">{!! trans('global.actions') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($leads['data'] as $lead)
                                <tr>
                                    <td class="v-align-middle semi-bold text-center">{{ $lead['identifier'] }}</td>
                                    <td class="v-align-middle semi-bold text-center">
                                        @if ($lead['user']['is_user'])
                                            <i class="fa fa-user-circle-o"
                                               title="{{ trans('leads.transformed_user') }}"></i>
                                        @endif
                                    </td>
                                    <td class="v-align-middle semi-bold text-center">
                                        @if ($lead['user']['is_user'])
                                            <a href="{{ route('backend.users.show', ['id' => $lead['user']['id']]) }}">
                                                {{ $lead['civility_name'] }}
                                            </a>
                                        @else
                                            {{ $lead['civility_name'] }}
                                        @endif
                                    </td>
                                    <td class="v-align-middle semi-bold text-center">{{ $lead['email'] }}</td>
                                    <td class="v-align-middle text-right">
                                        @if (!$lead['user']['is_user'])
                                            <button data-target="#confirm_lead_transformation_{{ $lead['id'] }}"
                                                    data-toggle="modal" class="btn btn-primary">
                                                <i class="fa fa-user"></i> {!! trans('leads.button.transform_into_user') !!}
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
                    <div>
                        {!! trans('leads.index_total_leads', ['total_lead' => $leads['meta']['pagination']['total']]) !!}
                        {!! pages_pagination(
                            $leads['meta']['pagination']['count'],
                            $leads['meta']['pagination']['total'],
                            $leads['meta']['pagination']['current_page'],
                            $leads['meta']['pagination']['per_page']
                        ) !!}
                    </div>
                @else
                    <div class="box-body">
                        <div class="alert alert-info alert-dismissible alert-module">
                            <h4><i class="icon fa fa-info-circle"></i> {!! trans('leads.index_no_data_title') !!}</h4>
                            {!! trans('leads.index_no_data_description') !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @foreach ($leads['data'] as $lead)
        <div class="modal fade slide-right" id="confirm_lead_transformation_{{ $lead['id'] }}" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content-wrapper">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="pg-close fs-14"></i>
                        </button>
                        <div class="container-xs-height full-height">
                            <div class="row-xs-height">
                                <div class="modal-body col-xs-height col-middle text-center">
                                    <h5 class="text-primary">{{ trans('leads.button.transform_into_user') }}</h5>
                                    <p>{{ trans('leads.transform_message', ['username' => $lead['civility_name']]) }}</p>
                                    <br>
                                    {!! Form::open(['route' => ['backend.leads.update', $lead['id']], 'method' => 'PUT']) !!}
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-user"></i> {!! trans('leads.button.transform_into_user') !!}
                                    </button>
                                    {!! Form::close() !!}
                                    <button type="button" class="btn btn-default btn-block m-t-10" data-dismiss="modal">
                                        {{ trans('global.cancel') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
