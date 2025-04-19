<x-layout title="Porównaj cenę Twojego koszyka w różnych sklepach" :showHeader="true" appendTitleSuffix="true" :breadcumbs="null">
    <h1 class="text-4xl mb-4">Porównaj cenę Twojego koszyka w różnych sklepach</h1>
    @if ($groups->isEmpty())
        <div class="text-xl mb-4">
            <p>Twój koszyk jest pusty.</p>
            <p>Wyszukaj produkty, które chcesz kupić i dodaj je do porównania.</p>
        </div>
    @else
        <div class="relative my-8 " id="compare">
            <div class="sticky top-0 grid grid-cols-12 bg-slate-900 font-bold break-all">
                <div class="col-span-3 py-2 px-2 text-left border border-slate-600">
                    Produkt
                </div>
                <div class="col-span-9 flex flex-row flex-nowrap justify-between">
                    @foreach ($shops as $shop)
                        <div class="flex-1 text-right py-2 px-2 border border-slate-600">
                            {{ $shop->name }}
                        </div>
                    @endforeach
                </div>
            </div>

            @foreach ($groups as $group)
                <div class="grid grid-cols-12 bg-slate-700 hover:bg-slate-800" id="group-{{ $group->ean }}">
                    <div class="col-span-3 py-2  pl-1 pr-2 text-left border border-slate-600 flex flex-row gap-1 items-center justify-start">
                        <span class="cursor-pointer text-red-500 hover:text-red-700 px-1 py-2 compareremove" data-ean="{{ $group->ean }}" title="Usuń">X</span>
                        @if ($group->oldestProduct->oldestImage?->getUrl(64))
                            <img class="max-h-full w-16" src="{{ $group->oldestProduct->oldestImage?->getUrl(64) }}" alt="{{ $group->oldestProduct->title }}" width="64">
                        @endif
                        <a class="" href="{{ $group->getAppUrlAttribute() }}">{{ $group->oldestProduct->title }}</a>
                    </div>
                    <div class="col-span-9 flex flex-row flex-nowrap justify-between">
                        @foreach ($shops as $shop)
                            <div class="flex-1 text-right py-2 px-2 border border-slate-600 flex flex-col justify-center">
                                <div>
                                    @if ($group->products->where('shop_id', $shop->id)->first())
                                        <span @class([
                                            'text-lg',
                                            'text-red-400' =>
                                                $group->products->where('shop_id', $shop->id)->first()->latestPrice->current == $group->maxPrice &&
                                                $group->products->where('shop_id', $shop->id)->first()->latestPrice->current != $group->minPrice,
                                            'text-green-400' =>
                                                $group->products->where('shop_id', $shop->id)->first()->latestPrice->current == $group->minPrice &&
                                                $group->products->where('shop_id', $shop->id)->first()->latestPrice->current != $group->maxPrice,
                                        ])>{{ $group->products->where('shop_id', $shop->id)->first()->latestPrice->currentFormatted() }}</span><br>
                                        <span class="text-xs bg-slate-600 md:p-1" title="Cena z dnia">{{ $group->products->where('shop_id', $shop->id)->first()->latestPrice->created_at->format('d.m.Y') }}</span>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <div class="grid grid-cols-12 bg-slate-900 font-bold">
                <div class="col-span-3 py-2 px-2 text-left border border-slate-600">
                    <p>Suma</p>
                    <p class="text-xs">(Jeśli w sklepie nie ma produktu, to brana jest pod uwagę średnia cena w innych sklepach)</p>
                </div>
                <div class="col-span-9 flex flex-row flex-nowrap justify-between brek-all">
                    @foreach ($shops as $shop)
                        <div class="flex-1 text-right py-2 px-2 border border-slate-600">
                            {{ number_format($shop->totalPrice, 2, ',', '') . ' zł ' }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</x-layout>
