@if ($paginator->hasPages())
    <nav class="admin-pagination" role="navigation" aria-label="Paginación de resultados">
        <div class="admin-pagination-buttons">
            @if ($paginator->onFirstPage())
                <span class="admin-page-link disabled" aria-disabled="true"><i class="fa-solid fa-chevron-left"></i> Anterior</span>
            @else
                <a class="admin-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa-solid fa-chevron-left"></i> Anterior</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))<span class="admin-page-ellipsis">{{ $element }}</span>@endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="admin-page-link current" aria-current="page">{{ $page }}</span>
                        @else
                            <a class="admin-page-link" href="{{ $url }}" aria-label="Ir a la página {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a class="admin-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente <i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="admin-page-link disabled" aria-disabled="true">Siguiente <i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </div>
        <p>Mostrando {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} de {{ $paginator->total() }} resultados</p>
    </nav>
@endif
