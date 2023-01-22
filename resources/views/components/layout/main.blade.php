@props(['widthClasses'])
<main {{ $attributes->merge(['class' => 'max-w-7xl w-full mx-auto px-2 mb-16']) }} id="main">
    {{ $slot }}
</main>
