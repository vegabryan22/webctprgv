@if ($paginator->hasPages())
    <nav class="calendar-pagination" role="navigation" aria-label="Paginación de actividades">
        <div class="pagination-buttons">
            @if ($paginator->onFirstPage())
                <span class="pagination-link disabled" aria-disabled="true"><i class="fas fa-chevron-left"></i> Anterior</span>
            @else
                <a class="pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left"></i> Anterior</a>
            @endif

            <div class="pagination-pages">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="pagination-ellipsis">{{ $element }}</span>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="pagination-link current" aria-current="page">{{ $page }}</span>
                            @else
                                <a class="pagination-link" href="{{ $url }}" aria-label="Ir a la página {{ $page }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <a class="pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente <i class="fas fa-chevron-right"></i></a>
            @else
                <span class="pagination-link disabled" aria-disabled="true">Siguiente <i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
        <p>Mostrando {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} de {{ $paginator->total() }} actividades</p>
    </nav>
@endif
