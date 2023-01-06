@props(['product'])
<div id="product-{{$product->id}}" class=" mb-2 shadow-sm bg-slate-700 w-full p-2 flex flex-col lg:flex-row">
    <div class=" flex-1 basis-3/5">
        <p class="text-lg"><span class=" text-gray-300">Sklep: </span>{{$product->shop->name}}</p>
        <p class=""><span class=" text-gray-300">Adres www sklepu: </span>{{$product->shop->url}}</p>
        <h3 class=""><span class=" text-gray-300">Nazwa w sklepie: </span>{{$product->title}}</h3>
        @if($product->url)
        <p class=""><span class=" text-gray-300">Adres www produktu: </span>{{$product->url}}</p>
        <p class=""><span class=" text-gray-300">Kategorie: </span>
            @foreach ($product->categories as $category )
            <a href="{{$category->url}}">{{$category->name}}</a>@if(!$loop->last),@endif
            @endforeach
        </p>
        @endif
    </div>
    <div class=" flex-1 space-y-2 basis-2/5">
        @foreach ($product->images as $image)
        <figure>
            <img src="{{$image->url}}" alt="{{$product->title}} {{$product->shop->name}}" class=" max-h-40">
            @if($loop->last)
            <figcaption>Źródło: {{$product->shop->url}}</figcaption>
            @endif
        </figure>
        @endforeach
        @empty($product->images)
        <p>Brak zdjęć</p>
        @endempty
    </div>
</div>
