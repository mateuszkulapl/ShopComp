<footer {{ $attributes->merge(['class' => 'text-center bg-slate-900 mt-auto']) }}>
    <div class="max-w-7xl w-full mx-auto px-2 py-2 text-xs">
        {{$slot}}
    </div>
</footer>
