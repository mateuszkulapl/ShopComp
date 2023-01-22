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
        <div class=" absolute z-20 w-full hidden bg-slate-900 border-t border-slate-800" id="headerSearch">
            <div class="max-w-7xl w-full mx-auto px-2 py-2">
                <livewire:search-groups/> 
                <script>
                    function clickHeaderSearch() {
                        const headerSearchTrigger = document.getElementById('headerSearchTrigger');
                        const headerSearch = document.getElementById('headerSearch');
                        if (headerSearchTrigger.contains(event.target)) {
                            headerSearch.classList.remove('hidden');
                            document.getElementById('search').focus();
                            headerSearchTrigger.classList.add('hidden');
                            document.getElementById('main').style.filter="blur(5px)";
                            document.getElementById('main').style.pointerEvents="none";
                            return;
                        }
                        if (!headerSearch.contains(event.target)) {
                            headerSearch.classList.add('hidden');
                            headerSearchTrigger.classList.remove('hidden');
                            document.getElementById('main').style.filter="";                            
                            document.getElementById('main').style.pointerEvents="initial";
                        }
                    }
                    document.addEventListener('click', clickHeaderSearch, false);
                </script>
            </div>
        </div>
    @endif
</header>
