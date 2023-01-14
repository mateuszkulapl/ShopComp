<x-layout title="{{ $category->name }} w sklepie {{ $shop->name }}" showHeader="{{ true }}" appendTitleSuffix="true" :breadcumbs="$breadcumbs">


    <h1 class=" text-4xl mb-4">{{ $category->name }} w sklepie {{ $shop->name }}</h1>
    @if ($categories->isNotEmpty())
        <h2 class=" text-2xl mb-4">Podkategorie:</h2>

        <x-category.grid class=" mb-4" :categories="$categories" />
    @else
        {{-- <p>Brak podkategorii</p> --}}
    @endif
    <x-product.grid class=" mb-4" :products="$products" />
    {{ $products->onEachSide(1)->links() }}
</x-layout>
