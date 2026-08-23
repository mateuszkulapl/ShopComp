<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $shop_id
 * @property int $group_id
 * @property int $title tytuł produktu
 * @property string|null $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\Group $group
 * @property-read Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\Price|null $largestOriginalPrice
 * @property-read \App\Models\Price|null $latestPrice
 * @property-read \App\Models\Price|null $lowestOriginalPrice
 * @property-read \App\Models\Image|null $oldestImage
 * @property-read \App\Models\Price|null $oldestPrice
 * @property-read Collection<int, \App\Models\Price> $prices
 * @property-read int|null $prices_count
 * @property-read \App\Models\Shop $shop
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static Builder<static>|Product newModelQuery()
 * @method static Builder<static>|Product newQuery()
 * @method static Builder<static>|Product query()
 * @method static Builder<static>|Product whereCreatedAt($value)
 * @method static Builder<static>|Product whereDeletedAt($value)
 * @method static Builder<static>|Product whereGroupId($value)
 * @method static Builder<static>|Product whereId($value)
 * @method static Builder<static>|Product whereShopId($value)
 * @method static Builder<static>|Product whereTitle($value)
 * @method static Builder<static>|Product whereUpdatedAt($value)
 * @method static Builder<static>|Product whereUrl($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;
    use Searchable;

    //use SoftDeletes;

    protected $fillable = ['shop_id', 'group_id', 'title', 'url', 'created_at', 'updated_at'];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['title', 'url', 'shop', 'group', 'images', 'categories', 'created_now', 'price'];

    private $chartPrices;


    public function toSearchableArray(): array
    {
        return [
            'id' => (int)$this->id,
            'title' => $this->title,
            'shop' => $this->shop->name,
            'url' => $this->url,
            'created_at' => $this->created_at,
            'ean' => $this->group->ean,
            'group_id' => $this->group_id,
        ];
    }

    /**
     * Modify the query used to retrieve models when making all of the models searchable.
     */
    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with([
            'shop' => function ($query) {
                $query->select(['id', 'name']);
            },
            'group' => function ($query) {
                $query->select(['id', 'ean']);
            },
        ]);
    }

    /**
     * Modify the collection of models being made searchable.
     */
    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->loadMissing(['shop:id,name', 'group:id,ean']);
    }

    /**
     * Determine if the model should be searchable.
     */
    public function shouldBeSearchable(): bool
    {
        return true;
    }


    /**
     * Get the shop that the product belongs to.
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Get the group that the product belongs to.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get all of the images for the product.
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get oldest image for the product.
     */
    public function oldestImage()
    {
        return $this->hasOne(Image::class)->oldestOfMany();
    }

    /**
     * Get all of the prices for the product. Order ascending by creation date
     */
    public function prices()
    {
        return $this->hasMany(Price::class)->oldest();
    }

    /**
     * Get the product's most recent price.
     */
    public function latestPrice()
    {
        return $this->hasOne(Price::class)->latestOfMany(); //retrieve the latest or oldest related model based on the model's primary key
    }

    /**
     * Get the product's oldest price.
     */
    public function oldestPrice()
    {
        return $this->hasOne(Price::class)->oldestOfMany(); //retrieve the latest or oldest related model based on the model's primary key
    }

    /**
     * Get the product's largest original price.
     */
    public function largestOriginalPrice()
    {
        return $this->hasOne(Price::class)->ofMany('original_price', 'max');
    }

    /**
     * Get the product's lowest original price.
     */
    public function lowestOriginalPrice()
    {
        return $this->hasOne(Price::class)->ofMany('original_price', 'min');
    }

    /**
     * The categories of product.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }


    public function setChartPrices($chartPrices)
    {
        $this->chartPrices=$chartPrices;
    }

    public function getChartPrices()
    {
        return $this->chartPrices;
    }
}
