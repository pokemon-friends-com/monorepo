@if ($trainers)
    <div class="row">
        <div class="col-12"><h2 class="text-dark">{{ trans('users.trainers') }}</h2></div>
    </div>
    <div class="row">
        @foreach ($trainers['data'] as $trainer)
            <div id="{{ $trainer['friend_code']['default'] }}" class="col-12 col-md-4 col-lg-3">
                @include('partials.card_trainer', ['trainer' => $trainer])
            </div>
        @endforeach
    </div>
    @include('partials.row_amazon', ['trainers' => $users])
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
