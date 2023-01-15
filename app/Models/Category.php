<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = ['name', 'shop_id', 'parent_id', 'url', 'shop_unique_cat_key', 'created_at', 'updated_at'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['name', 'parent', 'url', 'created_now', 'shop', 'descendant', 'ancestor'];

    // /**
    //  * The products that belong to the category.
    //  */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }


    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    public function descendant()
    {
        return $this->children()->with('descendant');
    }
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    public function ancestor()
    {
        return $this->parent()->with('ancestor');
    }



    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Determine app url
     *
     * @return string
     */
    public function getAppUrlAttribute()
    {
        return route('category.show', ['shop' => $this->shop, 'category' => $this]);
    }

    /**
     * Determine breadcumb element title
     *
     * @return string
     */
    public function getBreadcumbTitleAttribute()
    {
        return $this->name;
    }
}
