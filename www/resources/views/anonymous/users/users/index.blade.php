@extends('default')

@section('title', $metadata['title'])
@section('description', $metadata['description'])

@section('content')
<section class="py-md-6">
    <div class="container">
        <div class="row">
            <div class="col-11 col-md-8 text-center mx-auto mb-4">
                <i class="fas fa-qrcode icon"></i>
                <h2 class="font-weight-bold font-size-lg">{!! trans('users.trainers') !!}</h2>
                @if (!Auth::check())
                    <p class="lead">As unregistered user, you can see the daily selection of 96 trainers. Register to see all our trainers profiles!</p>
                @endif
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">

        <div class="row">
            @foreach ($users['data'] as $trainer)
            <div id="{{ $trainer['friend_code']['default'] }}" class="col-12 col-md-4 col-lg-3">
                @include('partials.card_trainer', ['trainer' => $trainer])
            </div>
            @endforeach
        </div>
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
