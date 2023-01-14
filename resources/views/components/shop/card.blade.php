@props(['shop'])
<div class="  bg-slate-700 hover:bg-slate-600 duration-100 hover:duration-300 border border-slate-900 text-slate-300 rounded-md shadow-sm hover:shadow-lg shadow-slate-900 relative flex flex-col break-words p-2 " id="shop-{{ $shop->id }}">
    <a class="after:absolute after:inset-0" href="{{ $shop->appUrl }}">
        <h2 class=" text-2xl mb-2 font-bold">{{ $shop->name }}</h2>
    </a>
    <p>Liczba produktów: {{ number_format($shop->products_count, 0, null, ' ') }}</p>
    <p>Liczba kategorii: {{ number_format($shop->categories_count, 0, null, ' ') }}</p>

    @if($shop->oldestProduct)
    <p>Pierwszy produkt dodany {{ $shop->oldestProduct->created_at->diffForHumans() }}</p>
    <p>Najnowszy produkt dodany {{ $shop->latestProduct->created_at->diffForHumans() }}</p>
    @endif


</div>
