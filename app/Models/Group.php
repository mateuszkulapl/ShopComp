<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder search search using scout if enabled, or fallback if not
 * @property ?string highlighted_title title from scout search
 */
class Group extends Model
{
    use HasFactory;

    protected $fillable = ['ean', 'created_at', 'updated_at'];
    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['ean', 'app_url', 'created_now'];


    // /**
    //  * The accessors to append to the model's array form.
    //  *
    //  * @var array
    //  */
    // protected $appends = ['url'];

    /**
     * Get all of the products for the group.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all of the price for the group.
     */
    public function prices()
    {
        return $this->hasManyThrough(Price::class, Product::class);
    }

    /**
     * Get all of the images for the group.
     */
    public function images()
    {
        return $this->hasManyThrough(Image::class, Product::class);
    }


    /**
     * Get the group's most recent product.
     */
    public function latestProduct()
    {
        return $this->hasOne(Product::class)->latestOfMany();
    }

    /**
     * Get the group's oldest product.
     */
    public function oldestProduct()
    {

        return $this->hasOne(Product::class)->oldestOfMany();
    }

    //todo: fix

    /**
     * Get the group's price from 7 days
     */
    public function priceWeekRange()
    {
        return $this->prices()->whereDate('prices.created_at', '>', Carbon::now()->subDays(7)); //it gets all the prices from the selected period, not the latest ones
    }

    /*
    * Get the latest price of each product in the group, price can not be older then 7 days
     * //TODO: fix this
    */
    public function latestPriceWeekRange()
    {
        // return $users = DB::table('prices')->groupBy('prices.product_id')->whereDate('prices.created_at', '>',  Carbon::now()->subDays(7))->get();
        return $this->prices()->whereDate('prices.created_at', '>', Carbon::now()->subDays(7))
            ->select('prices.*')
            ->join(DB::raw('(SELECT product_id, MAX(created_at) as latest_date FROM prices WHERE created_at > NOW() - INTERVAL 7 DAY GROUP BY product_id) as latest_prices'), function ($join) {
                $join->on('prices.product_id', '=', 'latest_prices.product_id');
            });
    }

    public function displayLatestPriceWeekRange()
    {

        if (count($this->latestPriceWeekRange) > 0) {
            $min = $this->latestPriceWeekRange->min('current');
            $max = $this->latestPriceWeekRange->max('current');
            if ($min != $max)
                return 'Cena od ' . number_format($min, 2, ",", "") . ' zł do ' . number_format($max, 2, ",", "") . " zł";
            else
                return 'Cena ' . number_format($min, 2, ",", "") . ' zł';
        } else
            return '';
    }

    /**
     * Determine app url
     *
     * @return string
     */
    public function getAppUrlAttribute()
    {
        $this->oldestProduct ? $correctOldestProductTitleSlug = Str::slug($this->oldestProduct->title) : $correctOldestProductTitleSlug = '';
        return route('group.show', ['group' => $this->ean, 'title' => $correctOldestProductTitleSlug]);
    }

    public function getSeoTitle()
    {
        if ($this->oldestProduct)
            return $this->ean . ' - ' . $this->oldestProduct->title;
        else
            return $this->ean;
    }


    /**
     * Search with scout
     */
    public function scopeSearch($query, $searchTerm)
    {

        if (Config::boolean('scout.enabled')) {
            /**@see scopeSearchScout */
            return $query->searchScout($searchTerm);
        }
        /**@see scopeFallbackSearch */
        return $query->fallbackSearch($searchTerm);
    }

    public static function modifyProductSearchMeilisearchOptions(array $options)
    {
        $options['limit'] = 10_000;
        $options['distinct'] = 'group_id';
        $options['attributesToRetrieve'] = ['id', 'group_id', 'title'];
        $options['attributesToHighlight'] = ['title'];
        return $options;
    }

    public function scopeSearchScout(Builder $query, $searchTerm)
    {
        $matchingProducts =
            collect(Product::search($searchTerm,
                function (\Meilisearch\Endpoints\Indexes $index, $searchText, $options) {
                    $options = self::modifyProductSearchMeilisearchOptions($options);
                    return $index->search($searchText, $options);
                }
            )->raw()['hits'] ?? []);

        $groupIds = $matchingProducts->pluck('group_id');
        $this->addScoutAfterSearchQuery($query, $matchingProducts);

        return $query->whereIn('id', $groupIds)
            ->when($groupIds->isNotEmpty(), function ($query) use ($groupIds) {
                //sort first x elements as scout order
                $idOrder = $groupIds->take(10_000)->implode(',');
                $query->orderByRaw('FIELD(id, ' . $idOrder . ')');
            });
    }

    public function scopeFallbackSearch($query, $searchTerm)
    {
        return $query->where('ean', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('products', function (Builder $query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%');
            })
            ->orWhereHas('products.shop', function (Builder $query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            });
    }

    /**
     * Determine breadcumb element title
     *
     * @return string
     */
    public function getBreadcumbTitleAttribute()
    {
        return $this->ean . " - " . $this->oldestProduct->title;
    }


    public function getProductNumberText()
    {
        if ($this->products_count) {
            if ($this->products_count == 1)
                $shopVar = "sklepu";
            else
                $shopVar = "sklepów";
            $output = "Dane z $this->products_count $shopVar";
            return $output;
        }
        return '';
    }

    private function addScoutAfterSearchQuery(Builder $query, \Illuminate\Support\Collection $matchingProducts): void
    {
        $highlightedTitles = $matchingProducts->pluck('_formatted.title', 'group_id');
        $query->afterQuery(function ($groups) use ($highlightedTitles) {
            $groups->each(function ($group) use ($highlightedTitles) {
                $group->highlighted_title = $highlightedTitles[$group->id] ?? null;
            });
        });

    }
}
