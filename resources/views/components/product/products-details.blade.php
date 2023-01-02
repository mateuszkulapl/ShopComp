@props(['products'])
<div id="productsDetails">
    @foreach ($products as $product)
    <x-product.product-details :product="$product" />
    @endforeach
</div>
