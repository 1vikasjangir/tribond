@if ($paginator->hasPages())
    <div class="pagination">
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="current disabled" aria-disabled="true">
                    <span aria-hidden="true"></span>
                </li>
            @else
                <li class="current disabled">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="dots" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="current disabled" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="next">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"></a>
                </li>
            @else
                <li class="disabled next" aria-disabled="true">
                    <span aria-hidden="true"></span>
                </li>
            @endif
        </ul>
    </div>
@endif
