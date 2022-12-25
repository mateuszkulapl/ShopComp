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
        @foreach ($groups as $group)
        <div>
            <h2 class="text-xl"><a href="{{ route('group.show', ['group'=>$group->ean, 'title'=>Str::slug($group->oldestProduct->title)]) }}">EAN: {{ $group->ean }} {{$group->oldestProduct->title}} </a></h2>
            <p class="p-3">Cena od {{$group->latestPriceWeekRange->min('current')}} do {{$group->latestPriceWeekRange->max('current')}} </p>
            <h3 class="text-red bg-red-500"></h3>
            <ul>
                {{-- @foreach ($group->products as $product)
            <li>{{ $product }}</li>
                @endforeach --}}
            </ul>
        </div>
        @endforeach
        {{ $groups->links() }}
    </div>
</x-layout>
