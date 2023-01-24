@props(['category'])
<div class="  bg-slate-700 hover:bg-slate-600 duration-100 hover:duration-300 border border-slate-900 text-slate-300 rounded-md shadow-sm hover:shadow-lg shadow-slate-900 relative flex flex-col break-words p-2 " id="category-{{ $category->id }}">
    <a class="after:absolute after:inset-0" href="{{ $category->appUrl }}">
        <h2 class=" text-2xl mb-2 font-bold">{{ $category->name }}</h2>
    </a>
    <div class="mt-auto">
        <p>Liczba produktów: {{ number_format($category->products_count, 0, null, ' ') }}</p>
        <p>Liczba podkategorii: {{ number_format($category->children_count, 0, null, ' ') }}</p>
    </div>

</div>
