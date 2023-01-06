<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory;
    //use SoftDeletes;



   /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['name','url'];


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
}
