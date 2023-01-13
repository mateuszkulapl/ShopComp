@props(['product'])
<div class="  bg-slate-700 hover:bg-slate-600 duration-100 hover:duration-300 border border-slate-900 text-slate-300 rounded-md shadow-sm hover:shadow-lg shadow-slate-900 relative flex flex-col break-words " id="product-{{ $product->id }}">
    @if ($product->oldestImage)
        <div class="bg-white h-48 flex items-center rounded-t-md">
            <img class="max-w-full max-h-full w-auto mx-auto" src="{{ $product->oldestImage->getUrl(200) }}" alt="{{ $product->title }}">
        </div>
    @endif
    <div class="p-2 mt-auto">
        <h2>
            <a class="after:absolute after:inset-0" href="{{ $product->group->appUrl }}">
                <span class="before:content-['EAN:_'] hidden">
                    {{ $product->group->ean }}
                </span>
                @if ($product)
                    <span class="block break-words">
                        {{ $product->title }}
                    </span>
                @endif
            </a>
        </h2>
        <p><span class=" font-bold">{{ $product->latestPrice->currentFormatted() }}</span> <small>(cena z {{ $product->latestPrice->created_at->format('d.m.Y') }})</small></p>
    </div>
</div>
