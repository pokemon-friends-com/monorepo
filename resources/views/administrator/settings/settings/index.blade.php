@extends('administrator.default')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-cogs mr-2"></i>{{ trans('settings.title') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><i class="fas fa-cogs mr-2"></i>{{ trans('settings.title') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
             <div class="row">
                <div class="col-12">
                    {!! Form::open(['route' => ['administrator.settings.store'], 'class' => 'form-horizontal', 'role' => 'form', 'autoprimary' => 'off', 'novalidate' => 'novalidate', 'method' => 'POST']) !!}
                    <div class="card">
                        <div class="card-body">


                            <div class="form-group row">
                                <label for="main-title" class="col-sm-2 col-form-label">{{ trans('settings.title') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="main-title" placeholder="{{ trans('settings.title') }}" name="main-title" value="{{ Settings::get('main-title') }}">
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
