@if ($trainers)
    <div class="row">
        <div class="col-11 col-md-8 text-center mx-auto mb-4">
            <i class="fas fa-qrcode icon"></i>
            <h2 class="font-weight-bold font-size-lg">Trainers friends codes & qRcode</h2>
            @if (!Auth::check())
                <p class="lead"><strong>As unregistered user</strong>, you can see the daily selection of 96 trainers. <strong><a href="{{ route('register') }}">Register</a></strong> to see all our trainers profiles!</p>
            @endif
        </div>
    </div>
    <div class="row">
    @foreach ($trainers['data'] as $trainer)
        <div id="{{ $trainer['friend_code']['default'] }}" class="col-12 col-md-4 col-lg-3">
            @include('partials.card_trainer', ['trainer' => $trainer])
        </div>
    @endforeach
    </div>
@endif
