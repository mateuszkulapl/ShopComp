<x-layout :chart="true" :title="$group->getSeoTitle()" :appendTitleSuffix="true">
    <h1 class="text-4xl mb-8">EAN: {{ $group->ean }}</h1>

    @if ($products->isNotEmpty())
        <x-product.products-summary :products="$products" />

        <h2 class="text-xl font-bold mb-2">Wykres cen</h2>
        <x-charts.chart :products="$products" :group="$group" />

        <h2 class="text-xl font-bold mb-2">Historia cen</h2>
        <x-group.price-history-table :products="$products" :group="$group" :priceTable="$priceTable" />

        <h2 class="text-xl font-bold mb-2">Szczegóły produktów</h2>
        <x-product.products-details :products="$products" />
    @endif


    @if ($products->isEmpty())
        <p class="text-lg">Nie dodano jeszcze produktów. Wróć później</p>
    @endif


</x-layout>
