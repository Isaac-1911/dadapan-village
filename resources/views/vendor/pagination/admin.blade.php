@if ($paginator->hasPages())
    <nav class="admin-pagination-nav" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="admin-pagination-btn admin-pagination-btn--disabled" aria-disabled="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="admin-pagination-btn" rel="prev">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
            </a>
        @endif

        <div class="admin-pagination-pages">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="admin-pagination-ellipsis">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="admin-pagination-page admin-pagination-page--active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="admin-pagination-page">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="admin-pagination-btn" rel="next">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
            </a>
        @else
            <span class="admin-pagination-btn admin-pagination-btn--disabled" aria-disabled="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
            </span>
        @endif
    </nav>
@endif
