<x-layout showHeader="{{$groups->currentPage()!=1}}">

    @if ($groups->currentPage()==1)
    <x-search>
        <x-slot name="additionalButtons">
            <a href="#przyklady" class="
        inline-block px-4 py-2 m-0 text-sm shadow-sm
        bg-slate-700 focus:bg-slate-500 hover:bg-slate-600
        border-none
        rounded-lg
        outline-none
        ring-1 ring-slate-400 focus:ring-slate-200
        ">Zobacz przykłady</a>
        </x-slot>
    </x-search>
    @endif

    <div id="przyklady">
        <x-group.grid :groups="$groups" class=" mb-4" />
        {{ $groups->links() }}
    </div>
</x-layout>
