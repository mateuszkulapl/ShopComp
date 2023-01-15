<x-layout :title="$title" :appendTitleSuffix="$appendTitleSuffix" :breadcumbs="$breadcumbs">
    @if ($categoriesCount > 0)
        <p class=" float-right"><a href="{{ route('category.index', ['shop' => $shop]) }}" class="p-2 bg-slate-900 rounded-md hover:bg-slate-700 border border-slate-700 hover:border-slate-600 ">Zobacz kategorie</a></p>
    @endif
    @if ($products->isNotEmpty())
        <div class=" pb-8" id="produkty">
            @if ($searchTerm)
                <h1 class=" text-2xl my-4">Produkty pasujące do &quot;{{ $searchTerm }}&quot; w sklepie {{ $shop->name }}</h1>
            @else
                <h1 class=" text-2xl my-4">Produkty w sklepie {{ $shop->name }}</h1>
            @endif
            <x-product.grid class=" mb-4" :products="$products" />
            {{ $products->onEachSide(1)->links() }}
        </div>
    @else
    <h1 class=" text-2xl my-4">Brak danych o produktach w sklepie {{ $shop->name }}. Wróć później.</h1>
    @endif
</x-layout>
