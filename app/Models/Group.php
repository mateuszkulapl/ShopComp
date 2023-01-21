<?php

namespace App\Models;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    //use SoftDeletes;

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
     * Search by group ean, group products title, group products shop name 
     */
    public function scopeSearch($query, $searchTerm)
    {
        $query = $query->where('ean', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('products', function (Builder $query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%');
            })
            ->orWhereHas('products.shop', function (Builder $query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            });
        return $query;
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
        if($this->products_count)
        {
            if($this->products_count==1)
            $shopVar="sklepu";
            else
            $shopVar="sklepów";
            $output="Dane z $this->products_count $shopVar";
            return $output;
        }
        return '';
    }
}
