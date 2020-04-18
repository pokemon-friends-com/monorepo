@extends('auth.default')

@section('title', $metadata['title'])
@section('description', $metadata['description'])
@section('image', $qr)
@section('card', 'summary')

@section('content')
    <div class="card-body login-card-body text-center">
        <h1 class="text-primary">{{ $friend_code }}</h1>
        <img src="{{ $qr }}" alt="{{ $friend_code }}">
        @if (Auth::check())
            <a href="{{ route('anonymous.dashboard') }}" class="btn btn-primary btn-block">{{ trans('users.home') }}</a>
        @else
        <a href="{{ route('register') }}" class="btn btn-primary btn-block mt-4">{{ trans('auth.register') }}</a>
        <a href="{{ route('anonymous.dashboard') }}" class="btn btn-outline-secondary btn-block">{{ trans('users.home') }}</a>
        @endif
    </div>
@endsection
