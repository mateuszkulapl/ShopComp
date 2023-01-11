@props(['group'])
<div class="  bg-slate-700 hover:bg-slate-600 duration-100 hover:duration-300 border border-slate-900 text-slate-300 rounded-md shadow-sm hover:shadow-lg shadow-slate-900 relative flex flex-col break-words " id="group-{{ $group->id }}">
    @if ($group->oldestProduct && $group->oldestProduct->oldestImage)
        <div class="bg-white h-48 flex  items-center rounded-t-md">
            <img class="max-w-full max-h-full w-auto mx-auto " src="{{ $group->oldestProduct->oldestImage->getUrl(200) }}" alt="{{ $group->oldestProduct->title }}">
        </div>
    @endif
    <div class="p-2 mt-auto">
        <h2>
            <a class="after:absolute after:inset-0" href="{{ $group->appUrl }}">
                <span class="block before:content-['EAN:_']">
                    {{ $group->ean }}
                </span>
                @if ($group->oldestProduct)
                    <span class="block break-words">
                        {{ $group->oldestProduct->title }}
                    </span>
                @endif
            </a>
        </h2>
        <p>{{ $group->displayLatestPriceWeekRange() }}</p>
    </div>
</div>
