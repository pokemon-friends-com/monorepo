@extends('default')

@section('header-left')
    <li class="nav-item"><a href="{{ route('customer.users.dashboard') }}" class="nav-link @if (Route::currentRouteNamed('customer.users.dashboard')) active @endif">{{ trans('users.dashboard') }}</a></li>
    <li class="nav-item"><a href="{{ route('anonymous.trainers.index') }}" class="nav-link @if (Route::currentRouteNamed('anonymous.trainers.index')) active @endif">{{ trans('users.trainers') }}</a></li>
@endsection
