@extends('default')

@section('header-left')
    <li class="nav-item"><a href="{{ route('administrator.users.dashboard') }}" class="nav-link @if (Route::currentRouteNamed('administrator.users.dashboard')) active @endif">{{ trans('users.dashboard') }}</a></li>
    <li class="nav-item"><a href="{{ route('administrator.users.index') }}" class="nav-link @if (Route::currentRouteNamed('administrator.users.index')) active @endif">{{ trans('users.title') }}</a></li>
    <li class="nav-item"><a href="{{ route('administrator.files.index') }}" class="nav-link @if (Route::currentRouteNamed('administrator.files.index')) active @endif">{{ trans('files.title') }}</a></li>
@endsection
