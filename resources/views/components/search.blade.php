@props(['searchTerm', 'emptySearchResults'])
<section class="flex flex-col h-screen items-center justify-evenly">

    <form class="  text-center" action="{{ route('group.searchPost') }}" method="post">
        @csrf
        @if ($emptySearchResults)
            <p class=" text-lg text-rose-300 font-bold mx-4">Nie znaleziono produktów</p>
        @endif
        <label class=" text-lg" for="search">Wyszukaj{{ $emptySearchResults ? ' ponownie' : '' }}</label>
        <input class="
            block
            w-64 sm:w-96
            p-2 my-2 mx-auto
            text-lg
            shadow-sm
            bg-slate-700 focus:bg-slate-600 hover:bg-slate-600 duration-100 hover:duration-300
            border-none
            rounded-lg
            outline-none
            ring-1 ring-slate-400 focus:ring-slate-200

            " id="search" name="search" type="text" value="{{ old('search') ? old('search') : ($searchTerm ? $searchTerm : '') }}" placeholder="Podaj nazwę produktu" required {{ $searchTerm ? '' : ' autofocus ' }}>

        <div class="flex items-center justify-center align-middle space-x-4" id="buttons">
            <button class=" inline-block px-4 py-2 m-0 text-sm shadow-sm
            bg-slate-700 focus:bg-slate-500 hover:bg-slate-600 active:bg-slate-400 duration-100 hover:duration-300
            border-none
            rounded-lg
            outline-none
            ring-1 ring-slate-400 focus:ring-slate-200
                " type="submit">Szukaj!</button>
            {{ $additionalButtons }}
        </div>
    </form>
    <a class=" p-4 flex flex-col items-center text-slate-400 hover:text-slate-300 duration-100 hover:duration-300 space-y-2" href="#produkty">
        @if ($searchTerm)
            @if (!$emptySearchResults)
                <span>Zobacz wyniki wyszukiwania</span>
                <x-icons.down class="h-full w-8 fill-current inline-block" />
            @endif
        @else
            <span>Zobacz wszystkie produkty</span>
            <x-icons.down class="h-full w-8 fill-current inline-block" />
        @endif
    </a>

</section>
