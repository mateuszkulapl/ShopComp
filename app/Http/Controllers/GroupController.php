<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return view('group.index', [
            'groups' => Group::latest()->with('oldestProduct', 'latestPriceWeekRange', 'oldestProduct.oldestImage')->paginate(20)
        ]);
    }

    public function getShowView(Group $group)
    {
        $products = $group->products()->with('shop', 'prices', 'images')->get();
        $priceTable = collect();
        foreach ($products as $product) {
            $value = $product->prices->first()->current;
            foreach ($product->prices as $price) {
                $price->change = $price->current - $value;
                $value = $price->current;
            }
            $priceTable = $priceTable->merge($product->prices);
        }
        $priceTable = $priceTable->sortBy('created_at');
        $priceTableGrouped = $priceTable->groupBy(function ($item) {
            return $item->created_at->startOfDay()->format('d.m.Y');
        });

        $priceTableGrouped = $priceTableGrouped->map(function ($item) {
            return $item->keyBy('product_id');
        });

        $apexchartPalette = ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0'];


        foreach ($products as $key => $product) {
            $product->color = $apexchartPalette[($key) % count($apexchartPalette)] . "60";
        }

        return view('group.show', [
            'group' => $group,
            'products' => $products,
            'priceTable' => $priceTableGrouped
        ]);
    }

    public function show(Group $group, String $oldestProductTitleSlug = '')
    {
        $correctOldestProductTitleSlug = Str::slug($group->oldestProduct->title);
        if ($correctOldestProductTitleSlug == $oldestProductTitleSlug) {
            return $this->getShowView($group);
        } else {
            return redirect(route('group.show', [$group, 'title' => Str::slug($group->oldestProduct->title)]), 301);
        }
    }
}
