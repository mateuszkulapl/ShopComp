@props(['product'])
<div class=" mb-2 shadow-sm bg-slate-700 w-full p-2 flex flex-col lg:flex-row" id="product-{{ $product->id }}">
    <div class=" flex-1 basis-3/5">
        <p class="text-lg"><span class=" text-gray-300">Sklep: </span>{{ $product->shop->name }}</p>
        @if ($product->shop->url)
            <p class=""><span class=" text-gray-300">Adres www sklepu: </span>{{ $product->shop->url }}</p>
        @endif
        <h3 class=""><span class=" text-gray-300">Nazwa w sklepie: </span>{{ $product->title }}</h3>
        @if ($product->url)
            <p class=""><span class=" text-gray-300">Adres www produktu: </span>{{ $product->url }}</p>
        @endif
        @if (!$product->categories->isEmpty())
            <p class=""><span class=" text-gray-300">Kategorie: </span>
                @foreach ($product->categories as $category)
                    {{ $category->name }}@if (!$loop->last)
                        ,
                    @endif
                @endforeach
            </p>
        @endif
    </div>
    <div class=" flex-1 space-y-2 basis-2/5">
        @foreach ($product->images as $image)
            <figure>
                <img class=" h-40" src="{{ $image->url }}" alt="{{ $product->title }} {{ $product->shop->name }}">
                @if ($loop->last)
                    <figcaption>Źródło: {{ $product->shop->url }}</figcaption>
                @endif
            </figure>
        @endforeach
        @empty($product->images)
            <p>Brak zdjęć</p>
        @endempty
    </div>
</div>
