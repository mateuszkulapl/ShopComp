<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use App\Models\Image;
use App\Models\Price;
use App\Models\Product;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ApiController extends Controller
{

    public function storeMultiply(Request $request)
    {
        $tokenValidationResponse = $this->isApiTokenValid($request);
        if ($tokenValidationResponse !== true) {
            return response()->json(
                [
                    'status_code' => 401,
                    'description' => $tokenValidationResponse,
                ],
                401
            );
        }

        $responses = collect();
        if (!is_array($request->input('product'))) {
            return response()->json(
                [
                    'status_code' => 404,
                    'description' => 'Product must be an array',
                ],
                404
            );
        }
        foreach ($request->input('product') as $key => $requestProduct) {

            $r = null;

            try {
                $r = $this->storeOne($requestProduct);
            } catch (Throwable $e) {
                $r = [
                    'status_code' => 500,
                    //'description' => 'Internal Server Error'
                    'description' => $e->getMessage() //TODO: remove
                ];
            }

            $responses->put($key, $r);
        }

        return response()->json(
            $responses,
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tokenValidationResponse = $this->isApiTokenValid($request);
        if ($tokenValidationResponse !== true) {
            return response()->json(
                [
                    'status_code' => 401,
                    'description' => $tokenValidationResponse,
                ],
                401
            );
        }

        $resp = $this->storeOne($request->input());
        return response()->json(
            $resp,
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function storeOne($p)
    {
        /*note: ISO-8601 dates - UTC */
        $response = DB::transaction(function () use ($p) {
            //$creation_date = Carbon::parse($p['creation_date'])->toDateTimeString();
            $creation_date = Carbon::now()->toDateTimeString();
            $validator = Validator::make($p, [
                'shop_name' => 'required|exists:App\Models\Shop,name',
                'ean' => 'required|string',
                'title' => 'required|string',
                'price_current' => 'required|numeric|max:999999.99|min:0.01',
                'price_old' => 'nullable|numeric|gte:price_current|max:999999.99|min:0.01',
                'url' => 'url',
                'images' => 'sometimes|array|distinct',
                'images.*' => 'sometimes|distinct',
                'categories' => 'sometimes|array',
                'categories.*.id' => 'required',
                'categories.*.name' => 'required',
                'categories.*.url' => 'nullable|url',
            ]);
            if ($validator->fails()) {
                return
                    [
                        'status_code' => 422, //Unprocessable Entity
                        'description' => 'Wrong input data.',
                        'errors' => $validator->errors()
                    ];
            }


            $shop = Shop::where('name', $p['shop_name'])->first();


            $group = Group::firstOrCreate(
                ['ean' => $p['ean']]
            );
            if ($group->wasRecentlyCreated) {
                $group->created_at = $creation_date;
                $group->updated_at = $creation_date;
                $group->save(['timestamps' => false]);
            }
            $group->created_now = $group->wasRecentlyCreated;


            $url = isset($p['url']) ? $p['url'] : null;
            $product = Product::updateOrCreate(
                ['shop_id' => $shop->id, 'group_id' => $group->id],
                ['title' => $p['title'], 'url' => $url]
            );
            if ($product->wasRecentlyCreated) {
                $product->created_at = $creation_date;
            }

            $product->updated_at = $creation_date;
            $product->save(['timestamps' => false]);
            $product->created_now = $product->wasRecentlyCreated;


            $priceOld = isset($p['price_old']) ? $p['price_old'] : null;
            $price = $this->processPostedPrice($p['price_current'], $priceOld, $product, $creation_date);
            if (isset($p['images'])) {
                $postedImages = $this->processPostedImages($p['images'], $product->id, $creation_date);
            } else {
                $postedImages = [];
            }

            $categories = [];

            if (isset($p['categories'])) {
                $categories = $this->processPostedCategories($p['categories'], $shop->id, $creation_date);
                $categories_dates = array_fill(0, $categories->count(), ['updated_at' => $creation_date, 'created_at' => $creation_date]);
                $product->categories()->sync($categories->pluck('id'), $categories_dates);
            }

            $product->group = $group;
            $product->shop = $shop;
            $product->price = $price;
            $product->images = $postedImages;
            $product->categories = $categories;

            $product->group->append('app_url');
            return
                [
                    'status_code' => 200,
                    'description' => 'OK',
                    'product' => $product
                ];
        });
        return $response;
    }



    /**
     * Add new images to product, delete old images
     *
     * @param array $postUrls
     * @param int $productId
     * @param string $creation_date
     * @return Illuminate\Support\Collection collection of posted images with created_now property
     */
    private function processPostedImages($postUrls, $productId, $creation_date)
    {
        $postedImages = collect();
        foreach ($postUrls as $postUrl) {
            $image = Image::firstOrCreate(
                [
                    'product_id' => $productId,
                    'url' => $postUrl
                ],
                [
                    'created_at' => $creation_date,
                    'updated_at' => $creation_date
                ]
            );

            $image->created_now = $image->wasRecentlyCreated;
            $postedImages->push($image);
        }
        Image::where('product_id', $productId)->whereNotIn('id', $postedImages->pluck('id'))->delete(); //delete all imagex except posted ones
        return $postedImages;
    }

    /**
     * Add new price to the product if not exist, or update current one
     *
     * @param float $postPriceCurrent
     * @param float $postPriceOld
     * @param App\Models\Product $product
     * @return App\Models\Price price with created_now and updated_now properties
     */
    private function processPostedPrice($postPriceCurrent, $postPriceOld, $product, $creation_date)
    {
        $newPrice = new Price();

        $newPrice->product_id = $product->id;
        $newPrice->current = $postPriceCurrent;
        $newPrice->old = $postPriceOld <= $postPriceCurrent ? null : $postPriceOld;

        $existingPrice = $product->prices()->whereDate('created_at', Carbon::parse($creation_date)->startOfDay()->toDateTimeString())->first();
        if ($existingPrice) {

            $existingPrice->current = $newPrice->current;
            $existingPrice->old = $newPrice->old;

            if ($existingPrice->isDirty()) {
                $existingPrice->updated_at = $creation_date;
                $existingPrice->save(['timestamps' => false]);

                $existingPrice->updated_now = true;
            } else {
                $existingPrice->updated_now = false;
            }

            $price = $existingPrice;
            $price->created_now = false;
        } else {
            $newPrice->created_at = $creation_date;
            $newPrice->updated_at = $creation_date;
            $newPrice->save(['timestamps' => false]);
            $price = $newPrice;
            $price->created_now = true;
        }
        return $price;
    }
    /**
     * Add categories to product
     *
     * @param array $categories
     * @param int $shopId
     * @param string $creation_date
     * @return Illuminate\Support\Collection collection of posted categories with created_now property
     */
    private function processPostedCategories($postCategories, $shopId, $creation_date)
    {
        //TODO: prevent recursion
        $categories = collect();
        foreach ($postCategories as $postCategory) {
            if (!empty($postCategory['id'])) {
                $category = $this->processPostedCategory($postCategory, $shopId, $creation_date);
                $categories->push($category);
            }
        }
        return $categories;
    }

    private function processPostedCategory($postCategory, $shopId, $creation_date)
    {
        $parent_id = null;
        if (isset($postCategory['parent'])) {
            $parent = $this->processPostedCategory($postCategory['parent'], $shopId, $creation_date);
            $parent_id = $parent->id;
        }

        $category = Category::firstOrCreate(
            [
                'shop_unique_cat_key' => $postCategory['id'],
                'shop_id' => $shopId
            ],
            [
                'created_at' => $creation_date,
                'updated_at' => $creation_date,
                'name' => $postCategory['name']
            ]
        );
        $category->parent_id = $parent_id;
        if (isset($postCategory['url'])) {
            $category->url = $postCategory['url'];
        }
        $category->name = $postCategory['name'];

        if ($category->isDirty()) {
            $category->updated_at = $creation_date;
            $category->save(['timestamps' => false]);
        }
        $category->created_now = $category->wasRecentlyCreated;
        $category->load('ancestor');
        return $category;
    }


    private function isApiTokenValid(Request $request)
    {
        //TODO: move to middleware
        $token = $request->header('Authorization');
        if ($token == null) {
            return 'Token is missing.';
        }
        $apiToken = env('API_TOKEN', null);
        if ($apiToken != null && $token == $apiToken)
            return true;

        return "Ivalid token.";
    }
}
