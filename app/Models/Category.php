<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int|null $parent_id
 * @property int $shop_id
 * @property string $name
 * @property string|null $url
 * @property string $shop_unique_cat_key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read string $app_url
 * @property-read string $breadcumb_title
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \App\Models\Shop $shop
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereShopUniqueCatKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUrl($value)
 * @mixin \Eloquent
 */
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
     */
    public function getAppUrlAttribute(): string
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
