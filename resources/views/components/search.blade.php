@props(['searchTerm', 'emptySearchResults', 'searchExamples' => collect()])
<section class="flex flex-col h-screen items-center justify-evenly">
    <form class="flex flex-col items-center" action="{{ route('group.searchPost') }}" method="post">
        @csrf
        @if ($emptySearchResults)
            <p class=" text-lg text-rose-300 font-bold mx-4">{!! __('search.products_not_found') !!}</p>
        @endif
        <label class=" text-lg"
               for="search">{!!  $emptySearchResults ?  __('search.search_again_cta') : __('search.search_cta') !!}</label>
        <div class="flex flex-wrap mx-auto flex-col sm:flex-row items-center">
            <input class="
                inline-block
                w-64 sm:w-96
                p-2 my-2 mx-0
                text-lg
                shadow-sm
                bg-slate-700 focus:bg-slate-600 hover:bg-slate-600 duration-100 hover:duration-300
                border-none
                rounded-md sm:rounded-l-lg sm:rounded-r-none
                outline-none
                ring-1 ring-slate-400 focus:ring-slate-200
                " id="search" name="search" type="text"
                   value="{{ old('search') ?? ($searchTerm ?? '') }}"
                   placeholder="{!! __('search.input_placeholder') !!}" required {{ $searchTerm ? '' : ' autofocus ' }}>

            <button class=" inline-block shadow-sm
                bg-slate-700 focus:bg-slate-500 hover:bg-slate-600 active:bg-slate-400 duration-100 hover:duration-300
                p-2 my-2 mx-0
                text-lg
                border-none
                rounded-md sm:rounded-r-lg sm:rounded-l-none
                outline-none
                ring-1 ring-slate-400 focus:ring-slate-200
                    " type="submit">{!! __('search.search_button') !!}</button>
        </div>
        <div class="flex flex-wrap gap-x-2 gap-y-1 justify-center" id="search-examples">
            @foreach ($searchExamples as $searchExample)
                <a class=" text-sm px-2 border border-slate-900 rounded-sm bg-slate-700 hover:bg-slate-600 duration-100 hover:duration-300"
                   href="{{ route('group.search', ['searchTerm' => $searchExample]) }}#produkty">{{ $searchExample }}</a>
            @endforeach
        </div>
        <div class="flex items-center justify-center align-middle space-x-4" id="buttons">
            {{ $additionalButtons }}
        </div>
    </form>
    @if (!$searchTerm || ($searchTerm && !$emptySearchResults))
        <a class=" p-4 flex flex-col items-center text-slate-400 hover:text-slate-300 duration-100 hover:duration-300 space-y-2"
           href="#produkty">
            @if ($searchTerm)
                <span>{!! __('search.see_search_lists') !!}</span>
            @else
                <span>Zobacz wszystkie produkty</span>
            @endif
            <x-icons.down class="h-full w-8 fill-current inline-block"/>
        </a>
    @else
        <div></div>
    @endif

</section>
