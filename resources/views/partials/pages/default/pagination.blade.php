<style>
    .pagination-sm > li:first-child > a, .pagination-sm > li:first-child > span,
    .pagination-sm > li:last-child > a, .pagination-sm > li:last-child > span {
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
    }

    .pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover {
        background-color: #2b303b;
        border-color: #2b303b;
    }

    .pagination > li {
        padding-left: 3px;
    }

    .pagination > li > a, .pagination > li > span {
        color: #2b303b;
        border: none;
    }
</style>


@if ($paginator->hasPages())
    <ul class="pagination pagination-sm no-margin pull-right" aria-label="Pagination">

        @if (!$paginator->onFirstPage())
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev">«</a>
            </li>
        @endif

        @foreach ($elements as $element)

            @if (is_string($element))
                <li class="disabled">
                    <a href="javascript:void(0);">{{ $element }}</a>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active">
                            <a href="javascript:void(0)">{{ $page }}</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next">»</a>
            </li>
        @endif

    </ul>
@endif
