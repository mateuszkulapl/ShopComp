@props(['elements' => collect()])

<nav class="w-full text-sm text-gray-400 mb-2">
    <ol class="flex">
        <li>
            <a class=" hover:text-gray-100 hover:duration-300 duration-100" href="{{ route('group.index') }}">Strona główna</a>@if ($elements->isNotEmpty())<span class="separator mx-1">></span>@endif
        </li>
        @foreach ($elements as $element)
            <li>
                <a class=" hover:text-gray-100 hover:duration-300 duration-100" href="{{ $element->appUrl }}">{{ $element->breadcumbTitle }}</a>@if (!$loop->last)<span class="separator mx-1">></span>@endif
            </li>
        @endforeach
    </ol>
</nav>
