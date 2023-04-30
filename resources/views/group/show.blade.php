<x-layout :chart="true" :title="$group->getSeoTitle()" :appendTitleSuffix="true" :breadcumbs="$breadcumbs">
    <h1 class="text-4xl mb-8 inline-block">EAN: {{ $group->ean }}</h1>
    @if (strlen($group->ean) == 13)
        <div style="background: white; padding:4px; float:right;"><img src="https://barcode.tec-it.com/barcode.ashx?data={{ $group->ean }}&code=EAN13&translate-esc=true" alt="kod kreskowy ean {{ $group->ean }}"></div>
        <div style="clear:both;"></div>
    @else
        @if (strlen($group->ean) == 8)
            <div style="background: white; padding:4px; float:right;"><img src="https://barcode.tec-it.com/barcode.ashx?data={{ $group->ean }}&code=EAN8&translate-esc=true" alt="kod kreskowy ean {{ $group->ean }}"></div>
            <div style="clear:both;"></div>
        @endif
    @endif

    @if ($products->isNotEmpty())
        <x-product.products-summary :products="$products" />

        <h2 class="text-xl font-bold mb-2">Wykres cen</h2>
        <x-charts.chart :products="$products" :group="$group" />

        <h2 class="text-xl font-bold mb-2">Historia cen</h2>
        <x-group.price-history-table :products="$products" :group="$group" :priceTable="$priceTable" />

        <h2 class="text-xl font-bold mb-2">Szczegóły produktów</h2>
        <x-product.products-details :products="$products" />
    @else
        <p class="text-lg">Nie dodano jeszcze produktów. Wróć później</p>
    @endif

</x-layout>
