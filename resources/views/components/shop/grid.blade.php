@props(['shops'])
<div {{ $attributes->merge(['class' => 'grid grid-cols-1 md:grid-cols-2 gap-4']) }}>
    @foreach ($shops as $shop)
        <x-shop.card :shop="$shop" />
    @endforeach
</div>
