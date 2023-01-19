@props(['widthClasses', 'showSearchButton' => true])
<header {{ $attributes->merge(['class' => 'bg-slate-900 mb-4']) }}>
    <div class="max-w-7xl w-full mx-auto px-2 py-2 flex justify-between">
        <div>
            <a class="text-xl" href="{{ route('group.index') }}">{{ config('app.name') }}</a>
        </div>
        <div class=" flex gap-x-4">
            @if ($showSearchButton)
                <p class=" cursor-pointer" id="headerSearchTrigger">
                    <x-icons.search class="h-full w-4 fill-current inline-block" />Szukaj
                </p>
            @endif
            <a href="{{ route('shop.index') }}">Sklepy</a>
        </div>
    </div>
    @if ($showSearchButton)
        <div class=" absolute z-10 w-full hidden bg-slate-900 border-t border-slate-800" id="headerSearch">
            <div class="max-w-7xl w-full mx-auto px-2 py-2">
                <form class=" flex items-center w-full justify-center flex-wrap" action="{{ route('group.searchPost') }}" method="post">
                    @csrf
                    <label class=" mr-4 text-md sm:text-lg" for="search">Wyszukaj</label>
                        <div class="flex">
                            <input class="
                            inline-block
                            w-48 sm:w-96
                            text-sm sm:text-md
                            py-1 px-2 my-1
                            shadow-sm
                            bg-slate-700 hover:bg-slate-600 duration-100 hover:duration-300
                            border-none
                            rounded-md
                            outline-none
                            ring-1 ring-slate-600
                            rounded-r-none
                            mr-0
                            " id="search" name="search" type="text" value="" placeholder="Podaj nazwę produktu" required>
                            <button class="
                                inline-block py-1 px-4 my-1
                                text-sm sm:text-md
                                shadow-sm
                                bg-slate-700 hover:bg-slate-600 active:bg-slate-400 duration-100 hover:duration-300
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
    @endif
</header>
