@extends('layouts.pages.secondary')

@section('breadcrumbs')
    @include('partials.pages.default.breadcrumbs', ['breadcrumbs' => [
        route('backend.users.index') => trans('users.title'),
    ]])
@endsection

@section('sidebar')
    <a href="{{ route('backend.users.create') }}" class="btn btn-primary btn-block m-b-30">
        <i class="fa fa-plus"></i> {{ trans('global.add') }}
    </a>
    <p class="menu-title all-caps">{{ trans('global.more_actions') }}</p>
    <ul class="main-menu">
        <li class="">
            <a href="{{ route('backend.users.export') }}">
                <span class="title"><i class="fa fa-file-excel-o"></i> {{ trans('global.export') }}</span>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="panel panel-transparent">
        <div class="panel-heading ">
            <div class="panel-title"><i class="fa fa-users"></i> {!! trans('users.title') !!}</div>
        </div>
        <div class="panel-body">
            @if ($users['meta']['pagination']['total'])
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
                        @foreach ($users['data'] as $user)
                            <tr>
                                <td class="v-align-middle semi-bold text-center">{{ $user['identifier'] }}</td>
                                <td class="v-align-middle semi-bold text-center">
                                    @if ($user['lead']['is_lead'])
                                        <i class="fa fa-user-circle-o"
                                           title="{{ trans('leads.transformed_user') }}"></i>
                                    @endif
                                </td>
                                <td class="v-align-middle semi-bold text-center">
                                    <a href="{{ route('backend.users.show', ['id' => $user['id']]) }}">{{ $user['civility_name'] }}</a>
                                </td>
                                <td class="v-align-middle semi-bold text-center">{{ $user['email'] }}</td>
                                <td class="v-align-middle text-right">
                                    @canImpersonate
                                    @if ($user['impersonation']['can_be_impersonated'])
                                        <a href="{{ route('impersonate', $user['id']) }}" class="btn btn-primary">
                                            <i class="fa fa-user-secret"></i> {{ trans('global.impersonate') }}
                                        </a>
                                    @endif
                                    @endCanImpersonate
                                    <a href="{{ route('backend.users.edit', ['id' => $user['id']]) }}"
                                       class="btn btn-primary">
                                        <i class="fa fa-edit"></i> {!! trans('global.edit') !!}
                                    </a>
                                    <button data-target="#confirm_user_deletion_{{ $user['id'] }}"
                                            data-toggle="modal" class="btn btn-danger">
                                        <i class="fa fa-trash"></i> {!! trans('global.delete') !!}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    {!! trans('users.index_total_users', ['total_user' => $users['meta']['pagination']['total']]) !!}
                    {!! pages_pagination(
                        $users['meta']['pagination']['count'],
                        $users['meta']['pagination']['total'],
                        $users['meta']['pagination']['current_page'],
                        $users['meta']['pagination']['per_page']
                    ) !!}
                </div>
            @else
                <div class="box-body">
                    <div class="alert alert-info alert-dismissible alert-module">
                        <h4><i class="icon fa fa-info-circle"></i> {!! trans('users.index_no_data_title') !!}</h4>
                        {!! trans('users.index_no_data_description') !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
    @foreach ($users['data'] as $user)
        <div class="modal fade slide-right" id="confirm_user_deletion_{{ $user['id'] }}" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content-wrapper">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="pg-close fs-14"></i>
                        </button>
                        <div class="container-xs-height full-height">
                            <div class="row-xs-height">
                                <div class="modal-body col-xs-height col-middle text-center   ">
                                    <h5 class="text-danger">{{ trans('global.deletion') }}</h5>
                                    <p>{{ trans('users.delete_message', ['username' => $user['civility_name']]) }}</p>
                                    <br>
                                    {!! Form::open(['route' => ['backend.users.destroy', $user['id']], 'method' => 'DELETE']) !!}
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <i class="fa fa-trash"></i> {!! trans('global.delete') !!}
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
