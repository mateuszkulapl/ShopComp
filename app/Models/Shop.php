<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string|null $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
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
 * @method static \Database\Factories\ShopFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereUrl($value)
 * @mixin \Eloquent
 */
class Shop extends Model
{
    use HasFactory;

    //use SoftDeletes;


    protected $fillable = ['name', 'url', 'url', 'created_at', 'updated_at'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['name', 'url'];


    /**
     * Get all of the products for the shop.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all of the prices for the shop.
     */
    public function prices()
    {
        return $this->hasManyThrough(Price::class, Product::class);
    }

    /**
     * Get all of the images for the shop.
     */
    public function images()
    {
        return $this->hasManyThrough(Image::class, Product::class);
    }


    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the shop's most recent product.
     */
    public function latestProduct()
    {
        return $this->hasOne(Product::class)->latestOfMany();
    }

    /**
     * Get the shop's oldest product.
     */
    public function oldestProduct()
    {
        return $this->hasOne(Product::class)->oldestOfMany();
    }

    /**
     * Determine app url
     */
    public function getAppUrlAttribute(): string
    {
        return route('shop.show', ['shop' => $this->id]);
    }

    /**
     * Determine breadcumb element title
     */
    public function getBreadcumbTitleAttribute(): string
    {
        return ucfirst($this->name);
    }
}
