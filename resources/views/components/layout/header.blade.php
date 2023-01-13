@props(['widthClasses'])
<header {{ $attributes->merge(['class' => 'bg-slate-900 mb-4']) }}>
    <div class="max-w-7xl w-full mx-auto px-2 py-2 flex justify-between">
        <div>
            <a class="text-xl" href="{{ route('group.index') }}">{{ config('app.name') }}</a>
        </div>
        <div class=" flex gap-x-4">
            <p class=" cursor-pointer" id="headerSearchTrigger">
                <x-icons.search class="h-full w-4 fill-current inline-block" />Szukaj
            </p>
            <a href="{{ route('shop.index') }}">Sklepy</a>
        </div>
    </div>
    <div class=" absolute z-10 w-full hidden bg-slate-900 border-t border-slate-800" id="headerSearch">
        <div class="max-w-7xl w-full mx-auto px-2 py-2">
            <form class=" flex items-center w-full justify-center" action="{{ route('group.searchPost') }}" method="post">
                @csrf
                <label class=" text-lg mr-4" for="search">Wyszukaj</label>
                <input class="
                inline-block w-96 py-1 px-2 my-1
                text-md
                shadow-sm
                bg-slate-700 hover:bg-slate-600
                border-none
                rounded-md
                outline-none
                ring-1 ring-slate-600
                rounded-r-none
                mr-0
                " id="search" name="search" type="text" value="" placeholder="Podaj nazwę produktu" required>

                <div class="flex items-center justify-center align-middle space-x-4" id="buttons">
                    <button class="
                    inline-block py-1 px-4 my-1
                    text-md
                    shadow-sm
                    bg-slate-700 hover:bg-slate-600 active:bg-slate-400
                    border-none
                    rounded-md
                    outline-none
                    ring-1 ring-slate-600
                    rounded-l-none
                    ml-0
                    " type="submit">Szukaj!</button>
                </div>
            </form>
            <script>
                function clickHeaderSearch() {
                    const headerSearchTrigger = document.getElementById('headerSearchTrigger');
                    const headerSearch = document.getElementById('headerSearch');
                    if (headerSearchTrigger.contains(event.target)) {
                        headerSearch.classList.remove('hidden');
                        document.getElementById('search').focus();
                        headerSearchTrigger.classList.add('hidden');
                        return;
                    }
                    if (!headerSearch.contains(event.target)) {
                        headerSearch.classList.add('hidden');
                        headerSearchTrigger.classList.remove('hidden');
                    }
                }
                document.addEventListener('click', clickHeaderSearch, false);
            </script>
        </div>
    </div>
</header>
