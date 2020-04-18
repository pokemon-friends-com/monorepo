@extends('customer.default')

@section('content')
<section class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-tachometer-alt mr-2"></i>{{ trans('users.dashboard') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><i class="fas fa-tachometer-alt mr-2"></i>{{ trans('users.dashboard') }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 offset-2">
                                <div class="h-100 d-flex flex-row justify-content-center align-items-center">
                                    <div class="text-center text-sm mr-2">{{ trans('users.trainer.social_share_qr') }}</div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card"><div class="card-boddy text-center m-1"><img src="{{ $user['qr'] }}" class="img-fluid" alt="{{ $user['friend_code'] }}"></div></div>
                                <div class="text-center text-sm lead"><a href="{{ route('anonymous.trainers.index', ['user' => $user['identifier']]) }}"><i class="fas fa-eye mr-1"></i>{{ $user['friend_code'] }}</a></div>
                            </div>
                            <div class="col-3">
                                <div class="h-100 d-flex flex-row justify-content-center align-items-center">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('anonymous.trainers.show', ['trainer' => $user['identifier']])) }}&t={{ urlencode(trans('users.trainer.meta.title')) }}" class="btn btn-primary mr-2" target="_blank" rel="noopener"><i class="fab fa-facebook"></i></a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('anonymous.trainers.show', ['trainer' => $user['identifier']])) }}&text={{ urlencode(trans('users.trainer.meta.title')) }}&via=pkmn_friends" class="btn btn-default btn-twitter mr-2 text-white" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                                    {{--<a href="" class="btn btn btn-primary mr-2"><i class="far fa-copy"></i></a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            @include('partials.row_trainers', ['trainers' => $users])
        </div>
    </div>
</section>
@endsection
