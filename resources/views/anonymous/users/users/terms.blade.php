@extends('anonymous.default')

@section('title', $metadata['title'])
@section('description', $metadata['description'])

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-file-signature mr-2"></i>{{ trans('users.terms') }}</h1>
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
                        <li class="breadcrumb-item active"><i class="fas fa-file-signature mr-2"></i>{{ trans('users.terms') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! trans('users.terms-of-services', ['home_url' => route('anonymous.dashboard'), 'contact_url' => route('anonymous.contact.index')]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
