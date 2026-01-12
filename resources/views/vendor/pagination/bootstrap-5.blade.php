@if ($paginator->hasPages())
    <nav class="d-flex justify-content-between align-items-center w-100 py-3" aria-label="Page navigation">
        {{-- Mobile View: Simple Buttons --}}
        <div class="d-flex d-md-none justify-content-between w-100">
            @if ($paginator->onFirstPage())
                <span class="btn btn-sm btn-light text-muted disabled">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm btn-outline-dark">Previous</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm btn-outline-dark">Next</a>
            @else
                <span class="btn btn-sm btn-light text-muted disabled">Next</span>
            @endif
        </div>

        {{-- Desktop View: Full Pagination --}}
        <div class="d-none d-md-flex align-items-center justify-content-between w-100">
            <div class="small text-muted">
                Showing <span class="fw-bold text-dark">{{ $paginator->firstItem() }}</span> to <span class="fw-bold text-dark">{{ $paginator->lastItem() }}</span> of <span class="fw-bold text-dark">{{ $paginator->total() }}</span> results
            </div>

            <div class="d-flex gap-1">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="btn btn-sm btn-light text-muted border-0 disabled" aria-disabled="true">&lsaquo;</span>
                @else
                    <a class="btn btn-sm btn-outline-light text-dark border-0 hover-bg-gray-200" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                @endif

                {{-- Pages --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="btn btn-sm btn-light text-muted border-0 disabled">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="btn btn-sm btn-dark fw-bold border-0">{{ $page }}</span>
                            @else
                                <a class="btn btn-sm btn-outline-light text-dark border-0 hover-bg-gray-200" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a class="btn btn-sm btn-outline-light text-dark border-0 hover-bg-gray-200" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a>
                @else
                    <span class="btn btn-sm btn-light text-muted border-0 disabled" aria-disabled="true">&rsaquo;</span>
                @endif
            </div>
        </div>
    </nav>
@endif