@props(['group', 'lazyImages' => false])
<div class=" group  bg-slate-700 hover:bg-slate-600 duration-100 hover:duration-300 border border-slate-900 text-slate-300 rounded-md shadow-sm hover:shadow-lg shadow-slate-900 relative flex flex-col break-words " id="group-{{ $group->id }}">
    @if ($group->oldestProduct && $group->oldestProduct->oldestImage)
        <div class="bg-white h-48 flex  items-center rounded-t-md">
            <img class="max-w-full max-h-full w-auto mx-auto " src="{{ $group->oldestProduct->oldestImage->getUrl(200) }}" alt="{{ $group->oldestProduct->title }}" @if ($lazyImages) loading="lazy" @endif>
        </div>
    @else
        <div class="bg-gray-800 h-48 flex  items-center rounded-t-md justify-center">
            <span class=" text-center text-slate-400 text-sm">Brak zdjęcia</span>
        </div>
    @endif
    <div class="px-2 pt-2 pb-1">
        <h2>
            <a class="after:absolute after:inset-0" href="{{ $group->appUrl }}">
                <span class="hidden before:content-['EAN:_']">
                    {{ $group->ean }}
                </span>
                @if ($group->oldestProduct)
                    <span class="block break-words">
                        {{ $group->oldestProduct->title }}
                    </span>
                @endif
            </a>
        </h2>
    </div>
    <div class="px-2 pb-2 pt-1 mt-auto bg-slate-600  group-hover:bg-slate-500 duration-100 hover:duration-300 rounded-b-md ">
        <p class=" text-sm">{{ $group->displayLatestPriceWeekRange() }}</p>
        <p class="text-sm">{{ $group->getProductNumberText() }}</p>
    </div>
</div>
