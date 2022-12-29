<x-layout>
@php
    $apexchartPalette=['#008FFB','#00E396','#FEB019','#FF4560','#775DD0'];
@endphp

    <h1 class="text-4xl mb-8">EAN: {{ $group->ean }}</h1>
    <div class="overflow-x-auto relative">
    <table class=" w-full border-collapse border-spacing-0 shadow-md mb-8">
        <thead class=" bg-slate-900 text-left">
            <tr class="border-b border-slate-400">
            <th class="py-4 px-1 ">Sklep</th>
            <th class="py-4 px-1 ">Cena</th>
            <th class="py-4 px-1 ">Cena z dnia</th>
            <th class="py-4 px-1 ">Nazwa w sklepie</th>
            <th class="py-4 px-1 ">Zdjęcie</th>
        </tr>
        </thead>
        <tbody class="">
            @foreach ($products as $product)
            <tr id="{{$product->id}}" class="bg-slate-700  hover:bg-slate-600 border-b border-slate-600 hover:duration-300 duration-100" style="background:{{$apexchartPalette[($loop->index)%count($apexchartPalette)]}}60">
                <td class="px-1">
                        {{ $product->shop->name }}
                </td>
                <td class="px-1 text-right">
                    {{ $product->prices->last()->current }}
                </td>
                <td class="px-1">
                    {{ \Carbon\Carbon::parse($product->prices->last()->created_at)->format('d.m.Y')}}
                </td>
                <td class="px-1">
                    {{ $product->title}}
                </td>
                <td class="px-1">
                    <img src="{{ $product->images->last()->url}}" alt="{{ $product->title }}" class=" max-h-10">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

<x-charts.chart :products="$products" :group="$group"/>

</x-layout>
