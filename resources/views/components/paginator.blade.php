@if ($paginator->hasPages())
<div class="w-full flex flex-col sm:flex-row items-center justify-between">
    {{-- Item Count --}}
    <div class="text-sm text-gray-600 dark:text-gray-400">
        Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
    </div>

    {{-- Pagination --}}
    <nav aria-label="Pagination">
        <ul class="inline-flex -space-x-px text-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            <li>
                <span
                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-400 bg-white border border-e-0 border-gray-300 rounded-s-lg cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                    Previous
                </span>
            </li>
            @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    rel="prev">
                    Previous
                </a>
            </li>
            @endif

            {{-- Pagination Elements --}}
            @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            $start = max(1, $currentPage - 2);
            $end = min($lastPage, $currentPage + 2);
            @endphp

            {{-- First Page --}}
            @if($start > 1)
            <li>
                <a href="{{ $paginator->url(1) }}"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    1
                </a>
            </li>
            @if($start > 2)
            <li>
                <span
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                    ...
                </span>
            </li>
            @endif
            @endif

            {{-- Page Range --}}
            @for ($i = $start; $i <= $end; $i++) <li>
                @if ($i == $currentPage)
                <span aria-current="page"
                    class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                    {{ $i }}
                </span>
                @else
                <a href="{{ $paginator->url($i) }}"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    {{ $i }}
                </a>
                @endif
                </li>
                @endfor

                {{-- Last Page --}}
                @if($end < $lastPage) @if($end < $lastPage - 1) <li>
                    <span
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                        ...
                    </span>
                    </li>
                    @endif
                    <li>
                        <a href="{{ $paginator->url($lastPage) }}"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{ $lastPage }}
                        </a>
                    </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            rel="next">
                            Next
                        </a>
                    </li>
                    @else
                    <li>
                        <span
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-400 bg-white border border-gray-300 rounded-e-lg cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                            Next
                        </span>
                    </li>
                    @endif
        </ul>
    </nav>
</div>
@else
<div class="text-sm text-gray-600 dark:text-gray-400">
    Showing {{ $paginator->total() }} results
</div>
@endif