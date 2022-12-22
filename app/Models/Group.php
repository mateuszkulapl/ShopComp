<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    //use SoftDeletes;

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
     * Get all of the images for the shop.
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
        return $this->hasManyThrough(Price::class, Product::class)->where('prices.current','>', 32)->whereDate('prices.created_at', '>',  Carbon::now()->subDays(7));
    }

}
