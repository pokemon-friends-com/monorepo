@extends('default')

@section('title', $metadata['title'])
@section('description', $metadata['description'])

@section('content')
<section class="py-5 py-md-6">
    <div class="container">
        <div class="row">
            <div class="col-11 col-md-8 text-center mx-auto mb-4">
                <h2 class="font-weight-bold font-size-lg">{{ trans('users.welcome') }}</h2>
                <p class="lead">{{ trans('users.baseline') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-sm">
                    <span class="card-img card-img-lg">
                        <img class="card-img-top" src="{{ asset_cdn('images/pokemon-1581774_1920.jpg') }}" alt="Pokemon Go mobile">
                    </span>
                    <div class="card-body">
                        <h5 class="card-title text-center">You only need a Pokemon Go account</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-sm">
                    <span class="card-img card-img-lg">
                        <img class="card-img-top" src="{{ asset_cdn('images/hands-1167612_1920.jpg') }}" alt="Capture a qrcode">
                    </span>
                    <div class="card-body">
                        <h5 class="card-title text-center">Meet friends worldwide and connect with</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-sm">
                    <span class="card-img card-img-lg">
                        <img class="card-img-top" src="{{ asset_cdn('images/pokemon-2965902_1920.jpg') }}" alt="Pokemon Go mobile with friend">
                    </span>
                    <div class="card-body">
                        <h5 class="card-title text-center">Share gift, get opponents, won eggs & XP</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 px-0 mx-auto">
                <div class="d-flex align-items-center position-relative overflow-hidden py-5 py-md-7 px-3 px-xl-0" data-parallax="scroll" data-image-src="{{ asset_cdn('images/pokemon-go-1569794_1920.jpg') }}" style="min-height: 500px">
                    <div class="overlay" ya-style="background-color: #292b2f"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 order-2 order-md-1 text-center text-sm-left">
                                <h2 class="display-6 font-weight-bold text-white">{{ trans('users.welcome') }}</h2>
                                <p class="text-white">With your participation, we are building a large directory of pokemon GO friends codes,</p>
                                <ul class="text-white">
                                    <li>Browse dozens of friend codes from around the world</li>
                                    <li>Add new friends to your Pokemon Go game simply like a photo</li>
                                    <li>Share your profile easily on all your social networks</li>
                                </ul>
                                <div class="d-flex d-sm-block flex-column mt-3 pt-3">
                                    <a class="btn btn-primary btn-shadow btn-rounded btn-lg mb-2 mb-sm-0" href="{{ route('register') }}" role="button">Register now</a>
                                    <span class="text-light font-size-sm">Unregistered users could only see our daily selection of 96 trainers</span>
                                </div>
                            </div>
                            <div class="col-md-4 order-1 order-md-2 d-flex align-items-md-center justify-content-center justify-content-md-end text-center mb-4 mb-md-0">
                                <div>
                                    <p class="font-weight-semibold text-white d-none d-md-inline-block">All trainers</p>
                                    <a class="easypiechart" href="{{ route('anonymous.trainers.index') }}" data-percent="100" data-scale-color="#e3e3e3" data-bar-color="#5eb404">
                                        <span class="easypiechart-text">{{ $nbTotalTrainers }}</span>
                                    </a>
                                </div>
                                <div class="ml-3 d-none d-md-inline-block">
                                    <p class="font-weight-semibold text-white">visible unregistered</p>
                                    <a class="review-score" href="{{ route('register') }}">{{ $users['meta']['pagination']['total'] }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white border-bottom border-top py-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 img-cover py-7" style="min-height: 300px;">
                <img src="{{ asset_cdn('images/qrcode-sharing.jpg') }}" alt="">
            </div>
            <div class="col-md-4 py-5 m-auto text-left">
                <div class="px-1 px-md-0">
                    <h2 class="display-5 font-weight-normal text-dark mb-5 mt-4">Share your profile on social networks</h2>
                    <p class="mb-4">Share your pkmn-friends profile easily on all your social networks, the sharing is focused to allow others trainers to add you as fast as possible, just a pic and play together!</p>
                    <div class="text-center">
                        <a class="btn btn-secondary btn-lg" href="{{ route('register') }}" role="button">Register</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 py-5 m-auto order-2 order-md-1 text-left">
                <div class="px-1 px-md-0">
                    <h2 class="display-5 font-weight-normal text-dark mb-5 mt-4">Integrate your profile in your lives</h2>
                    <p class="mb-4">Integrate your pkmn-friends profile easily on your live streams, once again, others trainers could add you as fast as possible, just a pic and play together!</p>
                    <div class="text-center">
                        <a class="btn btn-secondary btn-lg" href="{{ route('register') }}" role="button">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 img-cover order-1 order-md-2 py-7" style="min-height: 300px;">
                <img src="{{ asset_cdn('images/qrcode-stream-2.jpg') }}" alt="">
            </div>
        </div>
    </div>
</section>

<section class="py-md-6">
    <div class="container">
        @include('partials.row_trainers', ['trainers' => $users])
        <div class="text-center mt-2 mb-3">
            <a class="btn btn-secondary btn-lg" href="{{ route('anonymous.trainers.index') }}" role="button">View all trainers</a>
        </div>
    </div>
</section>

<section class="bg-image py-0 py-lg-3 py-xl-6" ya-style="background-color: #2e2f2f">
    <img class="background" src="http://i3.ytimg.com/vi/2GNw1j7fepI/maxresdefault.jpg" alt="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div ya-embed="https://www.youtube.com/watch?v=2GNw1j7fepI" ya-title="Pokémon GO - Making Friends" ya-length="1:35">
                    <img src="http://i3.ytimg.com/vi/2GNw1j7fepI/maxresdefault.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

{{--<section class="bg-primary py-0">--}}
{{--    <div class="container">--}}
{{--        <div class="promo">--}}
{{--            <h2 class="promo-title h4">How to add friends ? Easy, looks the Pokemon GO</h2>--}}
{{--            <a class="btn btn-outline-light mt-4 mt-lg-0 ml-md-4"--}}
{{--               target="_blank"--}}
{{--               rel="noopener noreferrer nofollow"--}}
{{--               href="https://niantic.helpshift.com/a/pokemon-go/?p=web&l={{ Session::get('locale') }}&s=friends-gifting-and-trading&f=friend-list-friendship-levels"--}}
{{--               role="button"--}}
{{--            >--}}
{{--                {{ trans('global.official_documentation') }}--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
@endsection
