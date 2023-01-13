<x-layout title="Sklepy" showHeader="{{ true }}" appendTitleSuffix="true" :breadcumbs="$breadcumbs">
    @if ($shops->isNotEmpty())
        <h1 class=" text-4xl mb-4">Sklepy</h1>

        <x-shop.grid class=" mb-4" :shops="$shops" />
    @endif

    @empty($shops)
        <p>Wróć później</p>
    @endempty
</x-layout>
