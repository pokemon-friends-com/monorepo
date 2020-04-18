@if ($trainers)
    <div class="row">
        @foreach ($trainers['data'] as $trainer)
            <div id="{{ $trainer['friend_code'] }}" class="col-6 col-lg-2">
                @include('partials.card_trainer', ['trainer' => $trainer])
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-footer">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a href="{{ route('anonymous.trainers.index') }}" rel="next" class="page-link">{!! trans('pagination.next') !!}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
