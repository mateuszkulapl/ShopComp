<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;

class CartController extends Controller
{
    public function index($eans = '')
    {
        $eanCodes = explode(',', $eans);
        $groups = \App\Models\Group::whereIn('ean', $eanCodes)->orderBy('ean')->get();
        $correctUrl = $groups->implode('ean', ',');
        if ($eans != $correctUrl)
            return redirect(route('cart.index', ['eans' => $correctUrl]), 301);

        $groups->load('products', 'products.shop', 'oldestProduct.oldestImage', 'products.latestPrice');

        $shops = $groups->pluck('products')->flatten()->pluck('shop')->unique();

        $breadcumbs = $this->getBreadcumbs();

        foreach ($groups as $group) {
            $group->maxPrice = $group->products->max('latestPrice.current');
            $group->minPrice = $group->products->min('latestPrice.current');
            $group->avgPrice = $group->products->avg('latestPrice.current');
        }
        //for all shops, calculate the total price of all products in cart, if price is not available, get group avg price from other shops instead
        foreach ($shops as $shop) {
            //prices of products in cart from this shop
            $shop->totalPrice = $groups->pluck('products')->flatten()->where('shop_id', $shop->id)->sum(function ($product) {
                return $product->latestPrice->current;
            });
            //add prices of products not available in this shop (avg price from other shops)
            $shop->totalPrice += $groups->whereNotIn('id', $groups->pluck('products')->flatten()->where('shop_id', $shop->id)->pluck('group_id'))->sum('avgPrice');
        }

        return view('cart.index', [
            'groups' => $groups,
            'shops' => $shops,
            'breadcumbs' => $breadcumbs,
            'eans' => $groups->pluck('ean')
        ]);
    }

    private function getBreadcumbs()
    {
        $breadcumbs = collect();
        $cart = new stdClass();
        $cart->appUrl = route('cart.index');
        $cart->breadcumbTitle = "Koszyk";
        $breadcumbs->push($cart);
        return $breadcumbs;
    }
}
