@props(['groups','lazyImages'=>false])
<div {{ $attributes->merge(['class' => 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4']) }}>
    @foreach ($groups as $group)
    <x-group.card :group="$group" :lazyImages="$lazyImages" />
    @endforeach
</div>
