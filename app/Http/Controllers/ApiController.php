<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Image;
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
        /*note: ISO-8601 dates - UTC */

        /*
        TODO:
        validate input
        store categories
        add custom created_at value
        */

        // $request->validate([
        //     'shop_name' => 'required',
        //     'ean' => 'required',
        // ]);

        //return request()->input();

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
            ['shop_id' => $shop->id, 'group_id' => $group->id],
            ['title' => request()->input('title'), 'url' => request()->input('url')]
        );
        $product->created_now = $product->wasRecentlyCreated;

        $newPrice = new Price();

        $newPrice->product_id = $product->id;
        $newPrice->current = request()->input('price_current');
        $newPrice->old = request()->input('price_old');

        $existingPrice = $product->prices()->whereDate('created_at', Carbon::today())->first();
        if ($existingPrice) {

            $existingPrice->current = $newPrice->current;
            $existingPrice->old = $newPrice->old;

            if ($existingPrice->isDirty()) {
                $existingPrice->save();

                $existingPrice->updated_now = true;
            } else {
                $existingPrice->updated_now = false;
            }

            $price = $existingPrice;
            $price->created_now = false;
        } else {
            $newPrice->save();
            $price = $newPrice;
            $price->created_now = true;
        }

        $postedImages = collect();
        foreach (request()->input('images') as $postImage) {
            $image = Image::firstOrCreate(
                [
                    'product_id' => $product->id,
                    'url' => $postImage
                ]
            );
            $image->created_now = $image->wasRecentlyCreated;
            $postedImages->push($image);
        }

        $product->group = $group;
        $product->shop = $shop;
        $product->price = $price;
        $product->posted_images = $postedImages;


        $product->group->append('app_url');
        $product->group->created_now = $group->wasRecentlyCreated;


        return response()->json(
            [
                'message' => $message->join(' '),
                'product' => $product
            ],
            200
        );
    }
}
