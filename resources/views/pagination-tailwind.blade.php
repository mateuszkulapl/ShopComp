@if ($paginator->hasPages())
    <nav class="flex items-center justify-between" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-slate-200 bg-slate-700 border border-slate-500 cursor-default leading-5 rounded-md">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-slate-200 bg-slate-700 border border-slate-500 leading-5 rounded-md hover:bg-slate-500 focus:outline-none focus:ring ring-slate-500 focus:border-slate-900 active:bg-slate-300 active:text-slate-500 transition ease-in-out duration-150" href="{{ $paginator->previousPageUrl() }}">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-slate-200 bg-slate-700 border border-slate-500 leading-5 rounded-md hover:bg-slate-500 focus:outline-none focus:ring ring-slate-500 focus:border-slate-900 active:bg-slate-300 active:text-slate-500 transition ease-in-out duration-150" href="{{ $paginator->nextPageUrl() }}">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-slate-200 bg-slate-700 border border-slate-500 cursor-default leading-5 rounded-md">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-slate-400 leading-5">
                    {!! __('pagination.showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('pagination.to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('pagination.of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('pagination.results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-slate-200 bg-slate-700 border border-slate-500 cursor-default rounded-l-md leading-5" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-slate-200 bg-slate-700 border border-slate-500 rounded-l-md leading-5 hover:bg-slate-500 focus:z-10 focus:outline-none focus:ring ring-slate-500 focus:border-slate-900 active:bg-slate-300 active:text-slate-500 transition ease-in-out duration-150" href="{{ $paginator->previousPageUrl() }}" aria-label="{{ __('pagination.previous') }}" rel="prev">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-slate-200 bg-slate-700 border border-slate-500 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-slate-200 bg-slate-600 border border-slate-500 cursor-default leading-5">{{ $page }}</span>
                                    </span>
                                @else
                                    <a class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-slate-200 bg-slate-700 border border-slate-500 leading-5 hover:bg-slate-500 focus:z-10 focus:outline-none focus:ring ring-slate-500 focus:border-slate-900 active:bg-slate-300 active:text-slate-500 transition ease-in-out duration-150" href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-slate-200 bg-slate-700 border border-slate-500 rounded-r-md leading-5 hover:bg-slate-500 focus:z-10 focus:outline-none focus:ring ring-slate-500 focus:border-slate-900 active:bg-slate-300 active:text-slate-500 transition ease-in-out duration-150" href="{{ $paginator->nextPageUrl() }}" aria-label="{{ __('pagination.next') }}" rel="next">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-slate-200 bg-slate-700 border border-slate-500 cursor-default rounded-r-md leading-5" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
