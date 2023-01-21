@props(['product'])
<div class=" mb-2 shadow-sm bg-slate-700 w-full p-2 flex flex-col lg:flex-row" id="product-{{ $product->id }}">
    <div class=" flex-1 basis-3/5">
        <p class="text-lg">
            <x-icons.circle :color="$product->color" />
            <span class=" text-gray-300">Sklep: </span><a href="{{ $product->shop->getAppUrlAttribute() }}">{{ $product->shop->name }}</a>
        </p>
        @if ($product->shop->url)
            <p class=""><span class=" text-gray-300">Adres www sklepu: </span>{{ $product->shop->url }}</p>
        @endif
        <h3 class=""><span class=" text-gray-300">Nazwa w sklepie: </span>{{ $product->title }}</h3>
        @if ($product->url)
            <p class="break-words"><span class=" text-gray-300">Adres www produktu: </span>{{ $product->url }}</p>
        @endif
        @if (!$product->categories->isEmpty())
            <div class="block space-x-1">
                <span class=" text-gray-300">Kategorie: </span>
                @foreach ($product->categories as $category)
                    <a class=" duration-100 hover:duration-300 bg-slate-600 hover:bg-slate-500 px-1 py-0 mt-1" href="{{ $category->appUrl }}">{{ $category->name }}</a>
                @endforeach
            </div>
        @endif
    </div>
    <div class=" flex-1 space-y-2 basis-2/5">
        @foreach ($product->images as $image)
            <figure>
                <img class=" h-40" src="{{ $image->getUrl(200) }}" alt="{{ $product->title }} {{ $product->shop->name }}" loading="lazy">
                @if ($loop->last)
                    <figcaption>Źródło: {{ $product->shop->url ? $product->shop->url : $product->shop->name }}</figcaption>
                @endif
            </figure>
        @endforeach
        @empty($product->images)
            <p>Brak zdjęć</p>
        @endempty
    </div>
</div>
