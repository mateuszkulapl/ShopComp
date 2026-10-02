<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    public function index()
    {
        $search = request()->get('search');
        $recent = now()->subDays(30);
        $currentPage = request()->get('page', 1);

        //todo: refactor
        $results = Cache::remember(key: 'promo_page-' . $currentPage . '-' . $search,
            ttl: $search == null ? now()->addHours(1) : now()->addHours(1),
            callback: function () use ($recent, $search) {

                $shopPrices = function () use ($recent) {
                    return DB::table('products as p')
                        ->join('prices as pr', 'pr.product_id', '=', 'p.id')
                        ->where('pr.created_at', '>', $recent)
                        ->whereNotNull('pr.current')
                        ->where('pr.current', '>', 0)
                        ->groupBy('p.group_id', 'p.shop_id')
                        ->select([
                            'p.group_id',
                            'p.shop_id',
                        ])
                        ->selectRaw('MIN(pr.current) as shop_min_price');
                };

                $competitorPrices = DB::query()
                    ->fromSub($shopPrices(), 'sp1')
                    ->joinSub($shopPrices(), 'sp2', function ($join) {
                        $join->on('sp2.group_id', '=', 'sp1.group_id')
                            ->whereColumn('sp2.shop_id', '!=', 'sp1.shop_id');
                    })
                    ->groupBy(
                        'sp1.group_id',
                        'sp1.shop_id'
                    )
                    ->select([
                        'sp1.group_id',
                        'sp1.shop_id',
                    ])
                    ->selectRaw('MIN(sp2.shop_min_price) as competitor_min_price');

                return Product::with([
                    'images',
                    'group:id,ean',

                    'group.products' => function ($query) {
                        $query
                            ->select([
                                'products.id',
                                'products.shop_id',
                                'products.group_id',
                                'products.title',
                            ])
                            ->with([
                                'shop:id,name',
                                'latestPrice',
                            ]);
                    },

                    'group.oldestProduct' => function ($query) {
                        $query->select([
                            'products.id',
                            'products.title',
                            'products.group_id',
                        ]);
                    },
                ])
                    ->when($search, function ($query, $search) {
                        $query->where('products.title', 'like', "%{$search}%");
                    })
                    ->join('prices', 'prices.product_id', '=', 'products.id')
                    ->joinSub($competitorPrices, 'competitors', function ($join) {
                        $join
                            ->on('competitors.group_id', '=', 'products.group_id')
                            ->on('competitors.shop_id', '=', 'products.shop_id');
                    })
                    ->where('prices.created_at', '>', $recent)
                    ->whereNotNull('prices.old')
                    ->where('prices.old', '>', 0)
                    ->whereColumn('prices.current', '<', 'prices.old')

                    //compare to old price in the same shop, or other shop price
                    ->whereRaw(
                        'prices.current < LEAST(prices.old, competitors.competitor_min_price)'
                    )
                    ->select('products.*')
                    ->selectRaw('prices.current as price_current')
                    ->selectRaw('prices.old as price_old')
                    ->selectRaw('competitors.competitor_min_price as competitor_min_price')
                    ->selectRaw('
    LEAST(
        prices.old,
        competitors.competitor_min_price
    ) as promo_reference_price
')
                    ->selectRaw('
    LEAST(
        prices.old,
        competitors.competitor_min_price
    ) - prices.current as promo_pln
')
                    ->selectRaw('
    ROUND(
        (
            1 - prices.current /
            LEAST(prices.old, competitors.competitor_min_price)
        ) * 100
    ) as promo_percent
')
                    //do not use absolute discount or relative discount, use custom indicator
                    ->selectRaw('
    ROUND(
        (
            1 - prices.current /
            LEAST(prices.old, competitors.competitor_min_price)
        )
        *
        SQRT(
            LEAST(prices.old, competitors.competitor_min_price)
            - prices.current
        )
        * 100
    , 2) as promo_score
')
                    ->orderByDesc('promo_score')
                    ->paginate(100);
            });

        return response()->view('promo.index', [
            'products' => $results,
            'breadcumbs' => collect(),
        ]);
    }

}
