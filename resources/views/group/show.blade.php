<x-layout>
    <h1 class="text-2xl mb-8">EAN: {{ $group->ean }}</h1>
    <table class=" w-full">
        <thead>
            <th>Sklep</th>
            <th>Cena</th>
            <th>Cena z dnia</th>
            <th>Nazwa w sklepie</th>
            <th>Zdjęcie</th>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr id={{$product->id}}>
                <td>
                    {{ $product->shop->name }}
                </td>
                <td>
                    {{ $product->prices->last()->current }}
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($product->prices->last()->created_at)->format('d.m.Y')}}
                </td>
                <td>
                    {{ $product->title}}
                </td>
                <td>
                    <img src="{{ $product->images->last()->url}}" alt="{{ $product->title }}" class=" max-h-10">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
