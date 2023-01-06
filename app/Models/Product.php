<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected  $fillable = ['shop_id', 'group_id', 'title', 'url'];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['title','url','shop','group','images','categories','created_now','posted_images','price'];


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

}
