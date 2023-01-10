<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index($searchTerm = null)
    {
        $groups = Group::latest();
        if ($searchTerm) {
            $groups = $groups->search($searchTerm);
            $title = $searchTerm . ' - wyniki wyszukiwania';
            $appendTitleSuffix = true;
        } else {
            $title = null;
            $appendTitleSuffix = false;
        }
        return view('group.index', [
            'groups' => $groups->with('oldestProduct', 'latestPriceWeekRange', 'oldestProduct.oldestImage')->paginate(30),
            'searchTerm' => $searchTerm,
            'title' => $title,
            'appendTitleSuffix' => $appendTitleSuffix,

        ]);
    }

    public function searchPost()
    {
        request()->validate([
            'search' => ['required']
        ]);
        return redirect(
            route(
                'group.search',
                ['searchTerm' => request('search'), '#produkty']
            )
        );
    }



    public function getShowView(Group $group)
    {
        $products = $group->products()->with('shop', 'prices', 'images', 'categories')->get();
        $products= $products->keyBy('id');
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

        $priceTable = $priceTable->map(function ($price) {
            $price->startOfDay=$price->created_at->startOfDay()->getTimestampMs();
            $price->date=$price->created_at->startOfDay()->format('d.m.Y');
            return $price;
        });

        $priceTableGroupedByDate = $priceTable->groupBy('day');
        $priceTableGroupedByDate = $priceTableGroupedByDate->map(function ($item) {
            return $item->keyBy('product_id');
        });

        $priceTableGroupedByDateTimestamp = $priceTable->groupBy('startOfDay');
        $priceTableGroupedByDateTimestamp = $priceTableGroupedByDateTimestamp->map(function ($item) {
            return $item->keyBy('product_id');
        });

        $priceTableGroupedByDate = $priceTable->groupBy('date');
        $priceTableGroupedByDate = $priceTableGroupedByDate->map(function ($item) {
            return $item->keyBy('product_id');
        });

        $apexchartPalette = ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0'];
  

        $priceTableGroupedByProduct = $priceTable->groupBy('product_id');
        $priceTableGroupedByProduct = $priceTableGroupedByProduct->map(function ($item) {
            return $item->keyBy('startOfDay');
        });
        //dd($priceTableGroupedByProduct);
        foreach ($priceTableGroupedByProduct as $product_id => $priceTableProduct) {
            $chartPrices=null;
            $chartPrices = $priceTableProduct->map(function ($price, $key) {
                return [$key,floatval($price->current)];
            });

            $diffDates=$priceTableGroupedByDateTimestamp->diffKeys($chartPrices)->map(function ($price,$key) {
                return [$key,null];
            });



            //$chartPrices=$chartPrices->union($diffDates)->sortKeys();
            $products[$product_id]->setChartPrices($chartPrices->values());
        }



        $index=0;
        foreach ($products as $product_id => $product) {
            $product->color = $apexchartPalette[($index++) % count($apexchartPalette)] . "66";
            
        }

        return view('group.show', [
            'group' => $group,
            'products' => $products,
            'priceTable' => $priceTableGroupedByDate
        ]);
    }

    public function show(Group $group, String $oldestProductTitleSlug = '')
    {
        $group->oldestProduct ? $correctOldestProductTitleSlug = Str::slug($group->oldestProduct->title) : $correctOldestProductTitleSlug = '';
        if ($correctOldestProductTitleSlug == $oldestProductTitleSlug) {
            return $this->getShowView($group);
        } else {
            return redirect(route('group.show', [$group, 'title' => $correctOldestProductTitleSlug]), 301);
        }
    }
}
