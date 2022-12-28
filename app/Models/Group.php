<?php

namespace App\Models;

use Illuminate\Support\Str;
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
        return $this->prices()->whereDate('prices.created_at', '>',  Carbon::now()->subDays(7)); //it gets all the prices from the selected period, not the latest ones
    }

    /*
    * Get the latest price of each product in the group, price can not be older then 7 days
    */
    public function latestPriceWeekRange()
    {
        // return $users = DB::table('prices')->groupBy('prices.product_id')->whereDate('prices.created_at', '>',  Carbon::now()->subDays(7))->get();
        return $this->priceWeekRange()->latest('prices.created_at')->groupBy('product_id');
    }

    public function displayLatestPriceWeekRange()
    {

        if (count($this->latestPriceWeekRange) > 0) {
            return 'Cena od ' . number_format($this->latestPriceWeekRange->min('current'), 2, ",", "") . ' zł do ' . number_format($this->latestPriceWeekRange->max('current'), 2, ",", "") . " zł";
        } else
            return '';
    }
    public function getUrl()
    {

        return route('group.show', ['group' => $this->ean, 'title' => Str::slug($this->oldestProduct->title)]);
    }
}
