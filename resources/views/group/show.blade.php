<h1>{{ $group->ean }} Group index</h1>

@foreach ($group->products as $product)
    <div>
        <h2>{{ $product->shop->name }}</h2>
        <p>{{ $product->title }}</p>
        <p>{{ $product->url }}</p>

    </div>
@endforeach
