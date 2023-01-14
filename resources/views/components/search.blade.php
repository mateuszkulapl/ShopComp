@props(['searchTerm','emptySearchResults'])
<section class="flex flex-col h-screen justify-center items-center">

    <form action="{{route('group.searchPost')}}" method="post" class="  text-center">
        @csrf
        @if($emptySearchResults)
        <p class=" text-lg text-rose-300 font-bold mx-4">Nie znaleziono produktów</p>
        @endif
        <label for="search" class=" text-lg">Wyszukaj{{$emptySearchResults?' ponownie' :''}}</label>
        <input type="text" name="search" id="search" class="
            block w-96 p-2 my-2 mx-auto
            text-lg
            shadow-sm
            bg-slate-700 focus:bg-slate-600 hover:bg-slate-600
            border-none
            rounded-lg
            outline-none
            ring-1 ring-slate-400 focus:ring-slate-200

            " placeholder="Podaj nazwę produktu" required {{$searchTerm? '' : ' autofocus ' }} value="{{ old('search')?old('search'):($searchTerm?$searchTerm:'') }}">

        <div id="buttons" class="flex items-center justify-center align-middle space-x-4">
            <button type="submit" class=" inline-block px-4 py-2 m-0 text-sm shadow-sm
            bg-slate-700 focus:bg-slate-500 hover:bg-slate-600 active:bg-slate-400
            border-none
            rounded-lg
            outline-none
            ring-1 ring-slate-400 focus:ring-slate-200
                ">Szukaj!</button>
            {{$additionalButtons}}
        </div>
    </form>

</section>
