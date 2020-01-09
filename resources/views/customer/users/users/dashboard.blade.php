@extends('customer.default')

@section('content')
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <example-component></example-component>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        @if (Route::has('anonymous.terms'))
                        <a class="card-link" href="{{ route('anonymous.terms') }}">{{ trans('global.terms') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
