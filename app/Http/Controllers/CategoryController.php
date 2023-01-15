<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Shop;
use Illuminate\Http\Request;
use stdClass;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Shop $shop)
    {
        $categories = $shop->categories()->where('parent_id', null)->with('children')->withCount('products')->orderBy('name', 'asc')->get();
        foreach ($categories as $cat) {
            $cat->shop = $shop; //prevent additional query
        }
        $breadcumbs = $this->getCategoryBreadcumbs($shop);

        return view('category.index', [
            'shop' => $shop,
            'categories' => $categories,
            'breadcumbs' => $breadcumbs,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop, Category $category)
    {
        if ($category->shop != $shop)
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;

        $category->load('ancestor', 'products', 'products.group', 'products.group.oldestProduct', 'products.latestPrice', 'products.oldestImage');
        $categories = $category->children()->with('children')->withCount('products')->orderBy('name', 'asc')->get();
        foreach ($categories as $cat) {
            $cat->shop = $shop; //prevent additional query
        }

        $products = $category->products()->latest()->paginate(30)->fragment('produkty');

        $breadcumbs = $this->getCategoryBreadcumbs($shop, $category);


        if (!$products->onFirstPage()) {
            $pageBreadcumb = new stdClass();
            $pageBreadcumb->appUrl = '';
            $pageBreadcumb->breadcumbTitle = "Strona " . $products->currentPage();
            $breadcumbs->push($pageBreadcumb);
        }


        return view('category.show', [
            'shop' => $shop,
            'category' => $category,
            'categories' => $categories,
            'breadcumbs' => $breadcumbs,
            'products' => $products
        ]);
    }

    private function getCategoryBreadcumbs($shop, $category = null)
    {
        $breadcumbs = collect();

        $allShops = new stdClass();
        $allShops->appUrl = route('shop.index');
        $allShops->breadcumbTitle = "Sklepy";
        $breadcumbs->push($allShops);

        $breadcumbs->push($shop);


        $allCats = new stdClass();
        $allCats->appUrl = route('category.index', ['shop' => $shop]);
        $allCats->breadcumbTitle = "Kategorie";
        $breadcumbs->push($allCats);

        $categoriesBreadcumbs = collect();
        if ($category) {
            $currentLevel = $category;
            $categoriesBreadcumbs->push($currentLevel);
            while ($currentLevel->ancestor) {
                $currentLevel = $currentLevel->ancestor;
                $categoriesBreadcumbs->push($currentLevel);
            }
            $breadcumbs = $breadcumbs->concat($categoriesBreadcumbs->reverse());
        }
        return $breadcumbs;
    }
}
