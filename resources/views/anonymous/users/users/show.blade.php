@extends('auth.default')

@section('title', $metadata['title'])
@section('description', $metadata['description'])
@section('image', $qr)
@section('card', 'summary')

@section('content')
    <div class="card-body login-card-body text-center">
        <h1 class="text-primary">{{ $friend_code }}</h1>
        <img src="{{ $qr }}" alt="{{ $friend_code }}">
        <a href="{{ route('anonymous.dashboard') }}" class="btn btn-primary btn-block mt-4">{{ trans('users.home') }}</a>
    </div>
@endsection
