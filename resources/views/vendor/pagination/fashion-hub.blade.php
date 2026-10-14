@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="px-4 py-2 text-sm font-medium text-stone-500 bg-stone-950 border border-stone-800 rounded-xl cursor-not-allowed">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-4 py-2 text-sm font-medium text-stone-300 bg-stone-950 border border-stone-700 rounded-xl hover:border-amber-400 hover:text-amber-400 transition">
                    Previous
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-4 py-2 text-sm font-medium text-stone-300 bg-stone-950 border border-stone-700 rounded-xl hover:border-amber-400 hover:text-amber-400 transition">
                    Next
                </a>
            @else
                <span
                    class="px-4 py-2 text-sm font-medium text-stone-500 bg-stone-950 border border-stone-800 rounded-xl cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-stone-400">
                    Showing
                    <span class="font-semibold text-amber-400">
                        {{ $paginator->firstItem() ?? 0 }}
                    </span>
                    to
                    <span class="font-semibold text-amber-400">
                        {{ $paginator->lastItem() ?? 0 }}
                    </span>
                    of
                    <span class="font-semibold text-amber-400">
                        {{ $paginator->total() }}
                    </span>
                    products
                </p>
            </div>

            <div>
                <span class="inline-flex items-center gap-1">
                    @if ($paginator->onFirstPage())
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 text-stone-600 bg-stone-950 border border-stone-800 rounded-xl cursor-not-allowed">
                            &lsaquo;
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}"
                            class="inline-flex items-center justify-center w-10 h-10 text-stone-300 bg-stone-950 border border-stone-700 rounded-xl hover:bg-stone-800 hover:text-amber-400 hover:border-amber-400 transition">
                            &lsaquo;
                        </a>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="inline-flex items-center justify-center w-10 h-10 text-stone-500">
                                {{ $element }}
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page"
                                        class="inline-flex items-center justify-center w-10 h-10 text-sm font-bold text-stone-950 bg-amber-400 border border-amber-400 rounded-xl shadow-lg shadow-amber-400/10">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-stone-300 bg-stone-950 border border-stone-800 rounded-xl hover:text-amber-400 hover:border-amber-400 hover:bg-stone-800 transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}"
                            class="inline-flex items-center justify-center w-10 h-10 text-stone-300 bg-stone-950 border border-stone-700 rounded-xl hover:bg-stone-800 hover:text-amber-400 hover:border-amber-400 transition">
                            &rsaquo;
                        </a>
                    @else
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 text-stone-600 bg-stone-950 border border-stone-800 rounded-xl cursor-not-allowed">
                            &rsaquo;
                        </span>
                    @endif

                </span>
            </div>
        </div>
    </nav>
@endif
