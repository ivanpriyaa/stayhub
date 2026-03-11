@if ($paginator->hasPages())
<nav>
    <ul class="pagination justify-content-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- First Page + Ellipsis --}}
        @if ($paginator->currentPage() > 3)
            <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
            @if ($paginator->currentPage() > 4)
                <li class="page-item disabled"><span class="page-link">…</span></li>
            @endif
        @endif

        {{-- Page links around current page --}}
        @foreach (range(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page)
            @if ($page == $paginator->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
            @endif
        @endforeach

        {{-- Last Page + Ellipsis --}}
        @if ($paginator->currentPage() < $paginator->lastPage() - 2)
            @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                <li class="page-item disabled"><span class="page-link">…</span></li>
            @endif
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
</nav>
@endif