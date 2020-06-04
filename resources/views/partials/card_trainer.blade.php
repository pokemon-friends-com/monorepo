<div class="card card-outline card-team-{{ $trainer['team_color'] }}">
    <div class="card-header text-center">
        <div class="input-group">
            <input type="text" class="form-control" value="{{ $trainer['friend_code']['formated'] }}">
            <span class="input-group-append">
                <button type="button" class="btn btn-primary btn-copy" data-clipboard-text="{{ $trainer['friend_code']['default'] }}"><i class="fas fa-copy"></i></button>
              </span>
        </div>
    </div>
    <div class="card-body text-center d-none d-md-block">
        <figure class="imghvr-fade m-1">
            {{-- <img src="{{ asset_cdn('images/pokeball.jpg') }}" data-src="{{ $trainer['qr'] }}" class="img-fluid lazy" alt="{{ $trainer['friend_code'] }}"> --}}
            <qr-code-component friend_code="{{ $trainer['friend_code']['formated'] }}" color="{{ $trainer['team_color'] }}"></qr-code-component>
            <figcaption class="bg-team-{{ $trainer['team_color'] }}">
                <i class="icon-team-{{ $trainer['team_color'] }}" style="font-size: 3em;"></i>
                <div class="h-100 d-flex flex-row justify-content-center align-items-center">
                    <i class="fas fa-expand-arrows-alt"></i>
                </div>
            </figcaption>
            {{-- <a data-remote="{{ $trainer['qr'] }}" data-type="image" data-toggle="lightbox" data-title="{{ $trainer['friend_code'] }}" data-gallery="trainers"></a> --}}
            <qr-code-gallery-component friend_code="{{ $trainer['friend_code']['formated'] }}" color="{{ $trainer['team_color'] }}"></qr-code-gallery-component>
        </figure>
    </div>
</div>
