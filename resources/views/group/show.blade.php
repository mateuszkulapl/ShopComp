<x-layout>
    <h1 class="text-2xl">{{ $group->ean }} Group index</h1>

    @foreach ($products as $product)
    <div>
        <h2 class="text-xl">{{ $product->shop->name }}</h2>
        <p>{{ $product->title }}</p>
        <p>{{ $product->url }}</p>
        <ul>
            @foreach ($product->prices as $price)
            <li>{{$price->current}}</li>
            @endforeach
        </ul>
    </div>
    @endforeach
</x-layout>
