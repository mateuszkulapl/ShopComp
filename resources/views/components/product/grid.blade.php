@props(['products'])
<div {{ $attributes->merge(['class' => 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4']) }}>
    @foreach ($products as $product)
        <x-product.card :product="$product" />
    @endforeach
</div>
