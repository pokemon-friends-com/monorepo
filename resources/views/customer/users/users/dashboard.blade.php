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
                                <div class="card elevation-2"><div class="card-boddy text-center m-1"><img src="{{ $user['qr'] }}" class="img-fluid" alt="{{ $user['friend_code']['formated'] }}"></div></div>
                                <div class="text-center text-sm lead"><a href="{{ route('anonymous.trainers.show', ['trainer' => $user['identifier']]) }}"><i class="fas fa-eye mr-1"></i>{{ $user['friend_code']['formated'] }}</a></div>
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
        <!-- <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row mb-0">
                            <span for="alert" class="col-4 col-form-label text-sm-center">share your QrCode on your live stream</span>
                            <div class="col-6">


                                <div class="input-guard">
                                    <div class="input-guard__text"><i class="fas fa-lock mr-2" aria-hidden="true"></i>Click to show</div>
                                    <input type="text" id="alert" class="form-control" readonly="readonly" value="{{ route('anonymous.users.alert', ['hash' => $user['identifier']]) }}"/>
                                </div>


                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary btn-copy" data-clipboard-target="#alert"><i class="fas fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        @include('partials.row_trainers', ['trainers' => $users])
    </div>
</section>
@endsection
