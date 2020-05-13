@extends('auth.default')

@section('title', $metadata['title'])
@section('description', $metadata['description'])
@section('image', $qr)
@section('card', 'summary')

@section('content')
    <div class="card-body login-card-body text-center">
        <h1 class="text-primary">{{ $friend_code }}</h1>
        @if ($nickname)
            <h3 class="text-primary">{{ $nickname }}</h3>
        @endif
        <img class="img-fluid lazy" src="{{ asset_cdn('images/pokeball.jpg') }}" data-src="{{ $qr }}" alt="{{ $friend_code }}">
        @if (Auth::check())
            <a href="{{ route('anonymous.dashboard') }}" class="btn btn-primary btn-block mt-4"><i class="fas fa-tachometer-alt mr-2"></i>{{ trans('users.dashboard') }}</a>
        @else
        <a href="{{ route('register') }}" class="btn btn-primary btn-block mt-4">{{ trans('auth.register') }}</a>
        <a href="{{ route('anonymous.dashboard') }}" class="btn btn-outline-secondary btn-block"><i class="fas fa-home mr-2"></i>{{ trans('users.home') }}</a>
        @endif
    </div>
@endsection
