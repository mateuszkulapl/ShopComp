<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use App\Models\Shop;
use Illuminate\Http\Request;
use stdClass;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcumbs = collect();
        $allShops = new stdClass();
        $allShops->appUrl = route('shop.index');
        $allShops->breadcumbTitle = "Sklepy";
        $breadcumbs->push($allShops);

        $shops = Shop::withCount('products', 'categories')->with('latestProduct', 'oldestProduct')->get();
        return view('shop.index', [
            'shops' => $shops,
            'breadcumbs' => $breadcumbs,
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

        $categoriesCount = Shop::where('id', $shop->id)->withCount('categories')->first()->categories_count;

        $title = $shop->name;
        //TODO: Search
        if ($searchTerm) {
            $products = $products->search($searchTerm);
            $title = $searchTerm . ' - wyniki wyszukiwania w sklepie ' . $shop->name;
            $appendTitleSuffix = true;
        } else {
            $title = $shop->name;
            $appendTitleSuffix = true;
        }
        $breadcumbs = collect();
        $allShops = new stdClass();
        $allShops->appUrl = route('shop.index');
        $allShops->breadcumbTitle = "Sklepy";
        $breadcumbs->push($allShops);
        $breadcumbs->push($shop);

        return view('shop.show', [
            'shop' => $shop,
            'products' => $products->with('latestPrice', 'oldestImage', 'group', 'group.oldestProduct')->paginate(30),
            'searchTerm' => $searchTerm,
            'title' => $title,
            'appendTitleSuffix' => $appendTitleSuffix,
            'categoriesCount' => $categoriesCount,
            'breadcumbs' => $breadcumbs,
        ]);
    }
}
