<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Price;
use App\Models\Product;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /*
        TODO:
        validate input
        store images
        store categories
        return group url
        */

        // $request->validate([
        //     'shop_name' => 'required',
        //     'ean' => 'required',
        // ]);

        $message = collect();
        try {
            $shop = Shop::where('name', request()->input('shop_name'))->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                [
                    'Error' => [
                        'message' => 'Shop not found',
                    ]
                ],
                404
            );
        }

        $group = Group::firstOrCreate(
            ['ean' => request()->input('ean')]
        );

        $product = Product::updateOrCreate(
            [
                'shop_id' => $shop->id,
                'group_id' => $group->id
            ],
            [
                'title' => request()->input('title'),
                'url' => request()->input('url')
            ]
        );


        $newPrice = new Price();

        $newPrice->product_id = $product->id;
        $newPrice->current = request()->input('price_current');
        $newPrice->old = request()->input('price_old');

        $existingPrice = $product->prices()->whereDate('created_at', Carbon::today())->first();
        if ($existingPrice) {
            $existingPrice->current = $newPrice->current;
            $existingPrice->old = $newPrice->old;

            if ($existingPrice->isDirty()) {
                $message->push("Price updated.");
                $existingPrice->save();
            } else {
                $message->push("Same price exist.");
            }
            $price = $existingPrice;
        } else {
            $newPrice->save();
            $message->push("Price created.");
            $price = $newPrice;
        }

        $product->load(['shop', 'group']);

        return response()->json(['message' => $message->join(' '), 'product' => $product, 'price' => $price], 200);
    }
}
