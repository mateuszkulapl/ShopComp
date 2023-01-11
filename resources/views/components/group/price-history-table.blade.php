@props(['products', 'priceTable'])
<div class="overflow-x-auto relative max-h-96 mb-8" id="productPriceHistory">
    <table class=" w-full border-collapse border-spacing-0 shadow-md text-right table-auto">
        <thead class=" bg-slate-900 sticky top-0">
            <tr class="border-b border-slate-400">
                <th class="py-4 border border-slate-600 px-2">Data</th>
                @foreach ($products as $product)
                    <th class="py-4 border border-slate-600 px-2">
                        <span class=" w-4 h-4 rounded-full inline-block" style="background:{{ $product->color }}"></span>{{ $product->shop->name }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($priceTable as $date => $priceTableRow)
                <tr class="bg-slate-700  hover:bg-slate-800 border-b border-slate-600 hover:duration-300 duration-100" class="border-b border-slate-400" id="{{ $loop->index }}">
                    <td class="border border-slate-600 px-2 bg-slate-900">
                        {{ $date }}
                    </td>
                    @foreach ($products as $product)
                        @php
                            $change = null;
                            $price = null;
                            if ($priceTableRow->has($product->id)) {
                                $change = $priceTableRow->get($product->id)->change;
                                $price = $priceTableRow->get($product->id)->current;
                            }
                        @endphp
                        <td @class([
                            'bg-rose-900' => $change > 0,
                            'bg-green-900' => $change < 0,
                            'border border-slate-600 px-2',
                        ])>
                            {{ $price }}
                            @if ($change != 0)
                                <small class=" text-xs">{{ $change > 0 ? '+' . $change : '' . $change }}</small>
                            @endif
                        </td>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
