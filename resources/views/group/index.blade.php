<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    <h1 class="text-2xl">Groups index</h1>
    @foreach ($groups as $group)
    <div>
        <h2 class="text-xl"><a href="{{ route('group.show', $group->ean) }}">{{ $group->ean }} ({{$group->oldestProduct->title}})</a></h2>

        <h3 class="text-red bg-red-500">{{
        
        $group->priceWeekRange(2)
        }}</h3>
        <ul>
            @foreach ($group->products as $product)
            <li>{{ $product }}</li>
            @endforeach
        </ul>
    </div>
    @endforeach
    {{ $groups->links() }}
</body>

</html>
