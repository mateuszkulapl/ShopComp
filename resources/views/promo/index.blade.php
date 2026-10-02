<x-layout showHeader="true" :breadcumbs="$breadcumbs" showBreadcumbs="0">
    @if ($products->isNotEmpty())
        <div class="pb-8" id="produkty">

            <table class="w-full text-sm text-left text-slate-300">
                <thead class="text-xs uppercase bg-slate-800 text-slate-400">
                <tr>
                    <th class="px-4 py-3 w-20">
                        Zdjęcie
                    </th>
                    <th class="px-4 py-3">
                        Produkt
                    </th>
                    <th class="px-4 py-3 text-right">
                        Cena
                    </th>
                    <th class="px-4 py-3 text-right">
                        Promocja
                    </th>
                    <th class="px-4 py-3 text-right">
                        Oszczędność
                    </th>
                    <th class="px-4 py-3 text-right">

                    </th>
                </tr>
                </thead>

                <tbody>
                @foreach ($products as $product)
                    <x-promo.row :product="$product" />
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $products->onEachSide(1)->links() }}
            </div>

        </div>
    @endif
</x-layout>
