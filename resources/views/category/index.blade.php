<x-layout title="Kategorie produktów w sklepie {{ $shop->name }}" showHeader="{{ true }}" appendTitleSuffix="true" :breadcumbs="$breadcumbs">
    
    @if ($categories->isNotEmpty())
        <h1 class=" text-4xl mb-4">Kategorie produktów w sklepie {{ $shop->name }}</h1>
        <x-category.grid class=" mb-4" :categories="$categories" />
    @else
        <p>Brak danych o kategoriach w sklepie {{ $shop->name }}. Wróć później</p>
    @endif
</x-layout>
