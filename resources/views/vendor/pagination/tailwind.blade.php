@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" aria-label="Previous">
                <span class="rounded-full border border-gray-300 bg-gray-200 text-gray-600 px-4 py-2 cursor-not-allowed"
                    aria-hidden="true">&laquo;</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="rounded-full border border-gray-300 bg-gray-100 text-gray-600 px-4 py-2 hover:bg-gray-200 focus:outline-none focus:ring focus:border-blue-300 active:bg-gray-200 transition ease-in-out duration-150">
                &laquo;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span
                    class="rounded-full border border-gray-300 bg-gray-100 text-gray-600 px-4 py-2 mx-2 cursor-not-allowed">{{ $element }}</span>
            @endif

            {{-- Array of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="rounded-full border border-gray-300 bg-gray-300 text-white px-4 py-2 mx-2">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                            class="rounded-full border border-gray-300 bg-gray-100 text-gray-600 px-4 py-2 mx-2 hover:bg-gray-200 focus:outline-none focus:ring focus:border-blue-300 active:bg-gray-200 transition ease-in-out duration-150">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="rounded-full border border-gray-300 bg-gray-100 text-gray-600 px-4 py-2 ml-2 hover:bg-gray-200 focus:outline-none focus:ring focus:border-blue-300 active:bg-gray-200 transition ease-in-out duration-150">
                &raquo;
            </a>
        @else
            <span aria-disabled="true" aria-label="Next">
                <span class="rounded-full border border-gray-300 bg-gray-200 text-gray-600 px-4 py-2 cursor-not-allowed"
                    aria-hidden="true">&raquo;</span>
            </span>
        @endif
    </nav>
@endif
