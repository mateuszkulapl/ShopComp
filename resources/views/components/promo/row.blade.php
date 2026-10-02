@props(['product', 'lazyImages' => false])

<tr
    id="product-{{ $product->id }}"
    class="group bg-slate-700 border-b border-slate-800 hover:bg-slate-600"
>
    <td>
        @if ($product->images->isNotEmpty())
            <div class="w-16 h-16 flex items-center justify-center">
                <img
                    class="
                        w-16 h-16
                        object-contain
                        bg-white
                        rounded
                        transition-transform
                        duration-200
                        ease-out
                        group-hover:scale-150
                        relative
                        z-10
                        group-hover:z-50
                    "
                    src="{{ $product->images->first()->getUrl(200) }}"
                    alt="{{ $product->title }}"
                    @if ($lazyImages) loading="lazy" @endif
                >
            </div>
        @else
            <div class="w-16 h-16 flex items-center justify-center bg-slate-800 rounded text-xs text-slate-500">
                Brak
            </div>
        @endif
    </td>

    <td class="px-4 py-3">
        <a
            href="{{ $product->url }}"
            class="font-medium text-white hover:underline"
        >
            {{ $product->title }}
        </a>

        <small class="text-xs">
            <br>

            <a
                href="{{ $product->group->appUrl }}"
                class="text-slate-500"
            >
                {{ $product->group->ean }}
            </a>
        </small>
    </td>

    <td class="px-4 py-3 text-right whitespace-nowrap">
        <div class="font-bold text-white">
            {{ number_format($product->price_current ?? 0, 2, ',', ' ') }} zł
        </div>

        <div class="text-sm text-slate-400 line-through">
            {{ number_format($product->promo_reference_price ?? 0, 2, ',', ' ') }} zł
        </div>

        @if (
            $product->competitor_min_price !== null &&
            $product->promo_reference_price == $product->competitor_min_price
        )
            <div class="text-xs text-orange-400">
                cena konkurencji
            </div>
        @else
            <div class="text-xs text-slate-500">
                cena regularna
            </div>
        @endif
    </td>

    <td class="px-4 py-3 text-right whitespace-nowrap">
        <span class="font-bold text-green-400">
            -{{ number_format($product->promo_percent, 0) }}%
        </span>
    </td>

    <td class="px-4 py-3 text-right whitespace-nowrap">
        <span class="font-bold text-green-300">
            -{{ number_format($product->promo_pln, 2, ',', ' ') }} zł
        </span>
    </td>

    <td class="px-4 py-3 whitespace-nowrap">
        <div class="space-y-1">
            @foreach ($product->group->products as $otherProduct)
                @if ($otherProduct->latestPrice)
                    <div class="flex items-center justify-between gap-3 text-sm">
                        <span class="text-slate-400">
                            {{ $otherProduct->shop->name }}
                        </span>

                        <span class="font-medium text-white">
                            {{ number_format($otherProduct->latestPrice->current, 2, ',', ' ') }} zł
                        </span>
                    </div>
                @endif
            @endforeach
        </div>
    </td>
</tr>
