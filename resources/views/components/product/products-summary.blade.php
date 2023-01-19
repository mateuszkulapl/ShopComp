@props(['products'])
<div class="overflow-x-auto relative" id="productInfo">
    <table class=" w-full border-collapse border-spacing-0 shadow-md mb-8">
        <thead class=" bg-slate-900 text-left">
            <tr class="border-b border-slate-400">
                <th class="py-4 px-1 ">Sklep</th>
                <th class="py-4 px-1  text-right pr-4">Cena</th>
                <th class="py-4 px-1 ">Cena z dnia</th>
                <th class="py-4 px-1 ">Nazwa w sklepie</th>
                {{-- <th class="py-4 px-1 ">Zdjęcie</th> --}}
            </tr>
        </thead>
        <tbody class="">
            @foreach ($products as $product)
                <tr class="bg-slate-700  hover:bg-slate-600 border-b border-slate-600 hover:duration-300 duration-100" id="{{ $product->id }}">
                    <td class="px-1">
                        <x-icons.circle :color="$product->color" />
                        {{ $product->shop->name }}
                    </td>
                    <td class="px-1 text-right pr-4">
                        {{ $product->prices->last()->currentFormatted() }}
                        @if($product->prices->last()->old)
                            <s>{{$product->prices->last()->oldFormatted()}}</s>
                        @endif
                    </td>
                    <td class="px-1">
                        {{ \Carbon\Carbon::parse($product->prices->last()->created_at)->format('d.m.Y') }}
                    </td>
                    <td class="px-1">
                        {{ $product->title }}
                    </td>
                    {{-- <td class="px-1">
                        @if ($product->images->last())
                            <img class=" max-h-10" src="{{ $product->images->last()->getUrl(40) }}" alt="{{ $product->title }}">
                        @endif
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
