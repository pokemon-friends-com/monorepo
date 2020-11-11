@if ($paginator->hasPages())
    <ul class="pagination pagination-sm m-0 float-right">

        @if (!$paginator->onFirstPage())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">{!! trans('pagination.previous') !!}</a>
            </li>
        @endif

        @foreach ($elements as $element)

            @if (is_string($element))
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0);">{{ $element }}</a>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                                <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                        </li>
                    @else
                        <li>
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">{!! trans('pagination.next') !!}</a>
            </li>
        @endif

    </ul>
@endif