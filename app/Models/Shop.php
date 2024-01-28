<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use \Illuminate\Support\Str;
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
     *
     * @return string
     */
    public function getAppUrlAttribute()
    {
        return route('shop.show', ['shop' => $this]);
    }

    /**
     * Determine breadcumb element title
     *
     * @return string
     */
    public function getBreadcumbTitleAttribute()
    {
        return ucfirst($this->name);
    }

    public function makeSlug(): string
    {
        $slug=Str::slug(
            Str::replace('.', '-', $this->name),
            '-',
            'pl'
        );
        return Str::of($slug)->whenEndsWith('-pl', function (\Illuminate\Support\Stringable $stringable) {
            return $stringable->replaceLast('-pl', '');
        });
    }
}
