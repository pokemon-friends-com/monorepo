@extends('anonymous.default')

@section('title', $metadata['title'])
@section('description', $metadata['description'])

@section('content')
<section class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{!! trans('users.trainers') !!}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('anonymous.dashboard') }}">
                            @if(Auth::check())
                                <i class="fas fa-tachometer-alt mr-2"></i>{{ trans('users.dashboard') }}
                            @else
                                <i class="fas fa-home mr-2"></i>{{ trans('users.home') }}
                            @endif
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{!! trans('users.trainers') !!}</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container">
        @if (!Auth::check())
        <div class="container-fluid">
            <div class="row pt-2 pb-2 align-items-center">
                <div class="col-4">@include('partials.card_amazon')</div>
                <div class="col-4">@include('partials.card_official_doc')</div>
                <div class="col-4">
                    <div class="alert alert-warning pt-2 pb-2 mb-1">Register to see more trainers friends codes!</div>
                    @include('partials.card_register')
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            @foreach ($users['data'] as $trainer)
            <div id="{{ $trainer['friend_code'] }}" class="col-6 col-lg-2">
                @include('partials.card_trainer', ['trainer' => $trainer])
            </div>
            @endforeach
        </div>
        @include('partials.row_amazon')
        @if ($users['meta']['pagination']['total'] > $users['meta']['pagination']['count'])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-footer clearfix">
                        {!! adminlte_pagination($users['meta']['pagination']['count'], $users['meta']['pagination']['total'], $users['meta']['pagination']['current_page'], $users['meta']['pagination']['per_page']) !!}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
