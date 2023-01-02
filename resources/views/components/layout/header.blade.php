@props(['widthClasses'])
<header {{ $attributes->merge(['class' => 'bg-slate-900 mb-4']) }}>
    <div class="max-w-7xl w-full mx-auto px-2 py-2 flex justify-between">
        <div>
            <a href="{{route('group.index')}}" class="text-xl">{{ config('app.name') }}</a>
        </div>
        <div>
            <span id="headerSearchTrigger" class=" cursor-pointer">Szukaj</p>
        </div>
    </div>
    <div id="headerSearch" class=" absolute w-full hidden bg-slate-900 border-t border-slate-800">
        <div class="max-w-7xl w-full mx-auto px-2 py-2">
            <form action="{{route('group.searchPost')}}" method="post" class=" flex items-center w-full justify-center">
                @csrf
                <label for="search" class=" text-lg mr-4">Wyszukaj</label>
                <input type="text" name="search" id="search" class="
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
                " placeholder="Podaj nazwę produktu" required value="">

                <div id="buttons" class="flex items-center justify-center align-middle space-x-4">
                    <button type="submit" class="
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
                    ">Szukaj!</button>
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
