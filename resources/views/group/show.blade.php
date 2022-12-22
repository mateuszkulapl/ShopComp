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
    <h1 class="text-2xl">{{ $group->ean }} Group index</h1>

    @foreach ($group->products as $product)
    <div>
        <h2 class="text-xl">{{ $product->shop->name }}</h2>
        <p>{{ $product->title }}</p>
        <p>{{ $product->url }}</p>

    </div>
    @endforeach
</body>

</html>
