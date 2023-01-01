<x-layout showHeader="{{$groups->currentPage()!=1}}" :title="$title" :appendTitleSuffix="$appendTitleSuffix">
    @if ($groups->currentPage()==1)
    <x-search :searchTerm="$searchTerm" :emptySearchResults="$groups->isEmpty()&&$searchTerm">
        <x-slot name="additionalButtons">
            @if(!$searchTerm)
            <a href="#produkty" class="
                inline-block px-4 py-2 m-0 text-sm shadow-sm
                bg-slate-700 focus:bg-slate-500 hover:bg-slate-600
                border-none
                rounded-lg
                outline-none
                ring-1 ring-slate-400 focus:ring-slate-200
                ">Zobacz przykłady</a>
            @else
            <a href="/" class="
                inline-block px-4 py-2 m-0 text-sm shadow-sm
                bg-slate-700 focus:bg-slate-500 hover:bg-slate-600
                border-none
                rounded-lg
                outline-none
                ring-1 ring-slate-400 focus:ring-slate-200
                ">Strona główna</a>
            @endif
        </x-slot>

    </x-search>
    @endif
    @if($groups->isNotEmpty())
    <div id="produkty" class=" pb-8">
        @if($searchTerm)
        <h2 class=" text-2xl text-center my-4">Produkty pasujące do &quot;{{$searchTerm}}&quot;</h2>
        @endif
        <x-group.grid :groups="$groups" class=" mb-4" />
        {{ $groups->links() }}
    </div>
    @endif
</x-layout>
