<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::withCount('products', 'categories')->with('latestProduct', 'oldestProduct')->get();
        return view('shop.index', [
            'shops' => $shops
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop, $searchTerm = null)
    {
        $products = $shop->products()->latest();


        $title = $shop->name;
        //TODO: Search
        // if ($searchTerm) {
        //     $products = $products->search($searchTerm);
        //     $title = $searchTerm . ' - wyniki wyszukiwania w sklepie ' . $shop->name;
        //     $appendTitleSuffix = true;
        // } else {
        //     $title = $shop->name;
        //     $appendTitleSuffix = true;
        // }
        return view('shop.show', [
            'shop' => $shop,
            'products' => $products->with('latestPrice', 'oldestImage', 'group')->paginate(30),
            'searchTerm' => $searchTerm,
            'title' => $title,
            'appendTitleSuffix' => $appendTitleSuffix,
        ]);
    }
}
