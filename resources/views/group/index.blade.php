<x-layout  showHeader="true" showSearchButton="{{ $groups->currentPage() != 1 }}" :title="$title" :appendTitleSuffix="$appendTitleSuffix" :breadcumbs="$breadcumbs" showBreadcumbs="0">
    @if ($groups->currentPage() == 1)
        <x-search :searchTerm="$searchTerm" :emptySearchResults="$groups->isEmpty() && $searchTerm">
            <x-slot name="additionalButtons">
                @if ($searchTerm)
                    <a class="
                inline-block px-4 py-2 m-0 text-sm shadow-sm
                bg-slate-700 focus:bg-slate-500 hover:bg-slate-600 active:bg-slate-400
                border-none
                rounded-lg
                outline-none
                ring-1 ring-slate-400 focus:ring-slate-200
                " href="/">Strona główna</a>
                @endif
            </x-slot>

        </x-search>
    @endif
    @if ($groups->isNotEmpty())
        <div class=" pb-8" id="produkty">
            @if ($searchTerm)
                <h2 class=" text-2xl my-4">Produkty pasujące do &quot;{{ $searchTerm }}&quot;</h2>
            @endif
            <x-group.grid class=" mb-4" :groups="$groups" />
            {{ $groups->onEachSide(1)->links() }}
        </div>
    @endif
</x-layout>
