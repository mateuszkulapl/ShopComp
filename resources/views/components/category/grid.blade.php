@props(['categories'])
<div {{ $attributes->merge(['class' => 'grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4']) }}>
    @foreach ($categories as $category)
        <x-category.card :category="$category" />
    @endforeach
</div>
