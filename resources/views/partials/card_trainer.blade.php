<div class="card card-outline card-team-{{ $trainer['team_color'] }}">
    <div class="card-header text-center">{{ $trainer['friend_code'] }}</div>
    <div class="card-boddy text-center">
        <figure class="imghvr-fade m-1">
            {{-- <img src="{{ asset_cdn('images/pokeball.jpg') }}" data-src="{{ $trainer['qr'] }}" class="img-fluid lazy" alt="{{ $trainer['friend_code'] }}"> --}}
            <qr-code-component friend_code="{{ $trainer['friend_code'] }}" color="{{ $trainer['team_color'] }}"></qr-code-component>
            <figcaption class="bg-team-{{ $trainer['team_color'] }}">
                <i class="icon-team-{{ $trainer['team_color'] }}" style="font-size: 3em;"></i>
                <div class="h-100 d-flex flex-row justify-content-center align-items-center">
                    <i class="fas fa-expand-arrows-alt"></i>
                </div>
            </figcaption>
            {{-- <a data-remote="{{ $trainer['qr'] }}" data-type="image" data-toggle="lightbox" data-title="{{ $trainer['friend_code'] }}" data-gallery="trainers"></a> --}}
            <qr-code-gallery-component friend_code="{{ $trainer['friend_code'] }}" color="{{ $trainer['team_color'] }}"></qr-code-gallery-component>
        </figure>
    </div>
</div>
