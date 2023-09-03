<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GroupController extends Controller
{
    public function index($searchTerm = null)
    {
        $searchExamples = collect();
        $groups = Group::with('oldestProduct', 'latestPriceWeekRange', 'oldestProduct.oldestImage');
        if ($searchTerm) {
            $groups = $groups->search($searchTerm);
            $title = $searchTerm . ' - wyniki wyszukiwania';
            $appendTitleSuffix = true;
        } else {
            $title = null;
            $appendTitleSuffix = false;
            $searchExamplesAll = collect();
            //TODO: move to admin panel
            $searchExamplesAll->push("Milka", "Sok pomarańczowy", "Masło", "Lay's", "Mleko", "Dżem", "Parówki", "Actimel", "Herbata", "Kawa ", "Prince Polo", "Dżem", "Makaron", "Płatki śniadaniowe", "Cukier", "Mąka ");
            $searchExamples = $searchExamplesAll->random(3);
        }
        $currentPage = request()->get('page', 1);
        //cache only first page of homepage without search term
        if($currentPage == 1 && $searchTerm == null)
        $groups = Cache::remember('homepageGroups_page-' . $currentPage, ($currentPage == 1 && $searchTerm == null) ? now()->addMinutes(10) : 0, function () use ($groups) {
            return $groups->withCount('products')->orderByDesc('products_count')->orderBy('id', 'desc')->paginate(30);
        });
        else
        $groups = $groups->withCount('products')->orderByDesc('products_count')->orderBy('id', 'desc')->paginate(30);


        if ($searchTerm != null && $groups->total() == 1 && $groups->items()[0]->ean == $searchTerm)
            return redirect($groups->items()[0]->appUrl, 301);

        $groups->total() == 0 ? $httpCode = 404 : $httpCode = 200;
        return response()->view('group.index', [
            'groups' => $groups,
            'searchTerm' => $searchTerm,
            'title' => $title,
            'appendTitleSuffix' => $appendTitleSuffix,
            'breadcumbs' => collect(),
            'searchExamples' => $searchExamples
        ], $httpCode);
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
        $products = $group->products()->with('shop', 'prices', 'images', 'categories', 'categories.shop')->get();
        $products = $products->keyBy('id');
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
            $price->startOfDay = $price->created_at->startOfDay()->getTimestampMs();
            $price->date = $price->created_at->startOfDay()->format('d.m.Y');
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

        $apexchartPalette = ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0']; //TODO: fix colors for more than 5 shops


        $priceTableGroupedByProduct = $priceTable->groupBy('product_id');
        $priceTableGroupedByProduct = $priceTableGroupedByProduct->map(function ($item) {
            return $item->keyBy('startOfDay');
        });

        foreach ($priceTableGroupedByProduct as $product_id => $priceTableProduct) {
            $chartPrices = null;
            $chartPrices = $priceTableProduct->map(function ($price, $key) {
                return [$key, floatval($price->current)];
            });

            $diffDates = $priceTableGroupedByDateTimestamp->diffKeys($chartPrices)->map(function ($price, $key) {
                return [$key, null];
            });

            $products[$product_id]->setChartPrices($chartPrices->values());
        }

        $index = 0;
        $apexchartPaletteSize = count($apexchartPalette);
        foreach ($products as $product_id => $product) {
            $product->color = $apexchartPalette[($index++) % $apexchartPaletteSize] . "";
        }

        $breadcumbs = collect();
        $breadcumbs->push($group);

        return view('group.show', [
            'group' => $group,
            'products' => $products,
            'priceTable' => $priceTableGroupedByDate,
            'breadcumbs' => $breadcumbs,
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
