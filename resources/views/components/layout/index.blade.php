@props(['title' => config('app.name'), 'titleSuffix' => ' | ' . config('app.name'), 'appendTitleSuffix' => false, 'paddingX' => 'px-2', 'showHeader' => true, 'metaDesc' => '', 'chart' => false, 'showBreadcumbs' => true, 'breadcumbs' => null,'showSearchButton'=>true])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}{{ $appendTitleSuffix ? $titleSuffix : '' }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    @if ($chart)
        <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
    @endif
    <meta name="description" content="{{ $metaDesc }}">
    @livewireStyles
</head>

<body class="bg-slate-800 text-slate-50 font-sans flex flex-col h-screen">
    @if ($showHeader)
        <x-layout.header :showSearchButton="$showSearchButton" />
    @endif
    <x-layout.main>
        @if ($showBreadcumbs)
            <x-breadcumbs :elements="$breadcumbs" />
        @endif
        {{ $slot }}
    </x-layout.main>
    <x-layout.footer class="">
        <p>&copy; {{ config('app.name') }}</p>
    </x-layout.footer>
    @livewireScripts
</body>

</html>
