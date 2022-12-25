@props(['title'=>config('app.name'),'paddingX'=>'px-2', 'showHeader'=>true, 'metaDesc'=>''])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <meta name="description" content="{{ $metaDesc }}">
</head>
<body class="bg-slate-800 text-slate-50 font-sans flex flex-col h-screen">
    @if ($showHeader)
    <x-layout.header />
    @endif

    <x-layout.main>
        {{$slot}}
    </x-layout.main>
    <x-layout.footer class="">
        <p>&copy; {{ config('app.name') }}</p>
    </x-layout.footer>
</body>
</html>
