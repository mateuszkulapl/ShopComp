<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $ean
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read string $app_url
 * @property-read string $breadcumb_title
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\Product|null $latestProduct
 * @property-read \App\Models\Product|null $oldestProduct
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Price> $prices
 * @property-read int|null $prices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\GroupFactory factory($count = null, $state = [])
 * @method static Builder<static>|Group fallbackSearch($searchTerm)
 * @method static Builder<static>|Group newModelQuery()
 * @method static Builder<static>|Group newQuery()
 * @method static Builder<static>|Group query()
 * @method static Builder<static>|Group search($searchTerm)
 * @method static Builder<static>|Group searchScout($searchTerm)
 * @method static Builder<static>|Group whereCreatedAt($value)
 * @method static Builder<static>|Group whereDeletedAt($value)
 * @method static Builder<static>|Group whereEan($value)
 * @method static Builder<static>|Group whereId($value)
 * @method static Builder<static>|Group whereUpdatedAt($value)
 * @mixin \Eloquent
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

    /*
    * Get the latest price of each product in the group, price can not be older than x
    */
    public function latestPriceRange($days = 31)
    {
        $cutOff = Carbon::now()->subDays($days);

        return $this->prices()->whereDate('prices.created_at', '>', $cutOff)
            ->select('prices.*')
            ->whereIn('prices.id', function ($query) use ($cutOff) {
                $query->selectRaw('MAX(p2.id)')
                    ->from('prices as p2')
                    ->whereColumn('p2.product_id', 'prices.product_id')
                    ->where('p2.created_at', '>', $cutOff);
            });
    }

    /*
    * Get the latest price of each product in the group, price can not be older then 7 days
    */
    public function latestPriceWeekRange()
    {
        return $this->latestPriceRange(days: 7);
    }

    public function latestPriceMonthRange()
    {
        return $this->latestPriceRange(days: 31);
    }

    public function displayLatestPriceRange($type = 'latestPriceMonthRange'): string
    {
        if (count($this->$type) > 0) {
            $min = (float)$this->$type->min('current');
            $max = (float)$this->$type->max('current');
            if ($min !== $max) {
                return 'Cena od ' . number_format($min, 2, ',', '') . ' zł do ' . number_format($max, 2, ',', '') . ' zł';
            }

            return 'Cena ' . number_format($min, 2, ',', '') . ' zł';
        }

        return '';
    }

    public function displayLatestPriceWeekRange(): string
    {
        return $this->displayLatestPriceRange('latestPriceWeekRange');
    }

    public function displayLatestPriceMonthRange(): string
    {
        return $this->displayLatestPriceRange('latestPriceMonthRange');
    }

    /**
     * Determine app url
     */
    public function getAppUrlAttribute(): string
    {
        $correctOldestProductTitleSlug = $this->oldestProduct ? Str::slug($this->oldestProduct->title) : '';
        return route('group.show', ['group' => $this->ean, 'title' => $correctOldestProductTitleSlug]);
    }

    public function getSeoTitle()
    {
        if ($this->oldestProduct)
            return $this->ean . ' - ' . $this->oldestProduct->title;

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

    public static function modifyProductSearchMeilisearchOptions(array $options): array
    {
        $options['limit'] = 10_000;
        $options['distinct'] = 'group_id';
        $options['attributesToRetrieve'] = ['id', 'group_id', 'title'];
        $options['attributesToHighlight'] = ['title'];
        return $options;
    }

    public function scopeSearchScout(Builder $builder, $searchTerm)
    {
        $matchingProducts =
            collect(Product::search($searchTerm,
                function (\Meilisearch\Endpoints\Indexes $indexes, ?string $searchText, $options) {
                    $options = self::modifyProductSearchMeilisearchOptions($options);
                    return $indexes->search($searchText, $options);
                }
            )->raw()['hits'] ?? []);

        $groupIds = $matchingProducts->pluck('group_id');
        $this->addScoutAfterSearchQuery($builder, $matchingProducts);

        return $builder->whereIn('id', $groupIds)
            ->when($groupIds->isNotEmpty(), function ($query) use ($groupIds) {
                //sort first x elements as scout order
                $idOrder = $groupIds->take(10_000)->implode(',');
                $query->orderByRaw('FIELD(id, ' . $idOrder . ')');
            });
    }

    public function scopeFallbackSearch($query, $searchTerm)
    {
        return $query->where('ean', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('products', function (Builder $builder) use ($searchTerm) {
                $builder->where('title', 'like', '%' . $searchTerm . '%');
            })
            ->orWhereHas('products.shop', function (Builder $builder) use ($searchTerm) {
                $builder->where('name', 'like', '%' . $searchTerm . '%');
            });
    }

    /**
     * Determine breadcumb element title
     */
    public function getBreadcumbTitleAttribute(): string
    {
        return $this->ean . " - " . $this->oldestProduct->title;
    }


    public function getProductNumberText(): string
    {
        if ($this->products_count) {
            $shopVar = $this->products_count == 1 ? "sklepu" : "sklepów";
            return "Dane z $this->products_count $shopVar";
        }

        return '';
    }

    private function addScoutAfterSearchQuery(Builder $builder, \Illuminate\Support\Collection $matchingProducts): void
    {
        $highlightedTitles = $matchingProducts->pluck('_formatted.title', 'group_id');
        $builder->afterQuery(function ($groups) use ($highlightedTitles) {
            $groups->each(function ($group) use ($highlightedTitles) {
                $group->highlighted_title = $highlightedTitles[$group->id] ?? null;
            });
        });

    }
}
