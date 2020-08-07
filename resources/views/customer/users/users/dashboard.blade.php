@extends('customer.default')

@section('content')
<section class="bg-image bg-dark d-flex align-items-end py-3" style="background-color: #3a3a3c !important;min-height: 320px;">
    <img class="background" src="{{ asset_cdn('images/david-grandmougin-Am1io6KusFM-unsplash.jpg') }}" alt="" ya-style="opacity: .25">
    <div class="container position-relative">
        <div class="row">
            <div class="col d-flex flex-column flex-lg-row align-items-center text-center position-absolute bottom left pl-lg-8">
                <a class="avatar-thumbnail avatar-lg d-lg-none bg-dark mb-3 mb-lg-0 border-0" href="#"><img src="{{ $user['qr'] }}" alt="{{ $user['friend_code']['formated'] }}" /></a>
                <h2 class="h4 text-white mb-0 ml-2 pl-lg-8">{{ Auth::user()->full_name }}</h2>
                <div class="ml-lg-auto mt-4 mb-3 my-lg-0">
                    <a class="btn btn-facebook btn-sm btn-icon-left font-weight-semibold" target="_blank" rel="noopener" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('anonymous.trainers.show', ['trainer' => $user['identifier']])) }}&t={{ urlencode(trans('users.trainer', ['friend_code' => $user['friend_code']['formated']])) }}"><i class="fab fa-facebook mr-1"></i>Share on Facebook</a>
                    <a class="btn btn-twitter btn-sm btn-icon-left font-weight-semibold ml-2" target="_blank" rel="noopener" href="https://twitter.com/intent/tweet?url={{ urlencode(route('anonymous.trainers.show', ['trainer' => $user['identifier']])) }}&text={{ urlencode(trans('users.trainer', ['friend_code' => $user['friend_code']['formated']])) }}&via=pkmn_friends"><i class="fab fa-twitter mr-1"></i>Share on twitter</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white border-bottom nav-profile py-0" ya-sticky>
    <div class="container">
        <div class="row">
            <div class="col d-flex align-items-center">
                <a class="avatar-thumbnail avatar-xl position-absolute d-none d-lg-block" href="#">
                    <img src="{{ $user['qr'] }}" alt="{{ $user['friend_code']['formated'] }}" />
                </a>
                <div class="avatar-fixed d-none d-lg-block">
                    <a class="avatar-tile" href="#">
                        <img src="{{ $user['qr'] }}" alt="{{ $user['friend_code']['formated'] }}" />
                        <div>
                            <strong>{{ Auth::user()->full_name }}</strong>
                            <span class="d-block">{{ $user['friend_code']['formated'] }}</span>
                        </div>
                    </a>
                </div>
                <div class="nav-scroll">
                    <div class="nav nav-list nav-list-profile">
                        <a class="nav-item nav-link" href="{{ route('anonymous.trainers.show', ['trainer' => $user['identifier']]) }}">See my public profile</a>
                    </div>
                </div>
                <div class="dropdown d-none d-xl-inline-block ml-auto">
                    <button class="btn btn-default btn-icon" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ya ya-gear"></i></button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('customer.users.edit', ['user' => $user['identifier']]) }}">Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 order-2 order-lg-1">
                <div class="widget mt-4">
                    <div class="widget-header">About me</div>
                    <div class="widget-body">
{{--                        <p>I am a frontend developer &amp; web designer. I love to work on creative and standalone projects like gameforest.</p>--}}
{{--                        <p class="font-size-sm font-weight-semibold mb-1"><i class="ya ya-pin mr-1"></i> Budapest</p>--}}
                        @if ($user['birth_date'])
                            <p class="font-size-sm font-weight-semibold mb-1"><i class="ya ya-calendar mr-1"></i>Birthday {{ $user['birth_date']->format('d F Y') }}</p>
                        @endif
                        <p class="font-size-sm font-weight-semibold mb-1"><i class="ya ya-calendar mr-1"></i>Joined {{ $user['created_at']->format('F Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                <div class="card">
                    <div class="card-header">
                        share your QrCode on your live stream
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-0">
                            <div class="col-9">


                                <!-- <div class="input-guard">
                                    <div class="input-guard__text"><i class="fas fa-lock mr-2" aria-hidden="true"></i>Click to show</div> -->
                                <input type="text" id="alert" class="form-control" readonly="readonly" value="{{ route('anonymous.trainers.show', ['trainer' => $user['identifier'], 'view' => 'qrcode']) }}"/>
                                <!-- </div> -->


                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-primary btn-block btn-copy" data-clipboard-target="#alert"><i class="fas fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="row">--}}
{{--            <div class="col-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="form-group row mb-0">--}}
{{--                            <div for="alert" class="col-12 col-form-label text-sm-center">--}}
{{--                            Allows your viewers to share there pokemon friend qrcode <a type="button" class="btn btn-primary" href="{{ route('anonymous.subscribe', ['plan' => 'twitch']) }}"><i class="fa fa-shopping-cart mr-2"></i>Subscribe 5 EUR / month</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</section>

@endsection
