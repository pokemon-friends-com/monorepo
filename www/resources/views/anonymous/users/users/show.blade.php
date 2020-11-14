@extends('default')

@section('title', $metadata['title'])
@section('description', $metadata['description'])
@section('image', $qr)
@section('card', 'summary')
@section('schema')
    {!! $schema->toScript() !!}
@endsection

@section('content')

    <section class="px-2 px-md-0 py-md-7" >
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
                    <div class="card mt-2 pb-2 mb-0 border-0">
                        <div class="separator mt-2"><h1 class="text-primary">{{ $friend_code }}</h1></div>
                        @if ($nickname)
                            <div class="separator mt-1"><h2 class="text-primary">{{ $nickname }}</h2></div>
                        @endif
                        <img class="img-fluid lazy" src="{{ asset_cdn('images/pokeball.jpg') }}" data-src="{{ $qr }}" alt="{{ $friend_code }}">
                    </div>
                    <div class="card mt-2 mb-0 border-0">
                        <div class="card-body p-3">
                            @if (Auth::check())
                                <a href="{{ route('anonymous.dashboard') }}" class="btn btn-primary btn-block"><i class="fas fa-tachometer-alt mr-2"></i>{{ trans('users.dashboard') }}</a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary btn-block">{{ trans('auth.register') }}</a>
                                <a href="{{ route('anonymous.dashboard') }}" class="btn btn-outline-secondary btn-block"><i class="fas fa-home mr-2"></i>{{ trans('users.home') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
