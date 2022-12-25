@props(['widthClasses'])
<header {{ $attributes->merge(['class' => 'bg-slate-900 mb-4 ']) }}>
    <div class="max-w-7xl w-full mx-auto px-2 py-2 flex justify-between">
        <div>
            <a href="{{route('group.index')}}" class="text-xl">{{ config('app.name') }}</a>
        </div>
        <div>
            <a href="#">Szukaj</a>
        </div>
    </div>
</header>
