@props(['groups'])
<div {{ $attributes->merge(['class' => 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4']) }}>
    @foreach ($groups as $group)
    <x-group.card :group="$group" />
    @endforeach
</div>
