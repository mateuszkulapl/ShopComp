@props(['group'])
<div class="  bg-slate-700 hover:bg-slate-800 duration-100 hover:duration-300 border border-slate-900 text-slate-300 rounded-md shadow-sm hover:shadow-lg shadow-slate-900 relative flex flex-col break-words " id="group-{{ $group->id }}">
    @if ($group->oldestProduct && $group->oldestProduct->oldestImage)
        <img class="max-w-full max-h-48 w-auto h-auto mx-auto rounded-t-md" src="{{ $group->oldestProduct->oldestImage->url }}" alt="{{ $group->oldestProduct->title }}">
    @endif
    <div class="p-2 mt-auto">
        <h2>
            <a class="after:absolute after:inset-0" href="{{ $group->getUrl() }}">
                <span class="block before:content-['EAN:_']">
                    {{ $group->ean }}
                </span>
                @if ($group->oldestProduct)
                    <span class="block">
                        {{ $group->oldestProduct->title }}
                    </span>
                @endif
            </a>
        </h2>
        <p>{{ $group->displayLatestPriceWeekRange() }}</p>
    </div>
</div>
