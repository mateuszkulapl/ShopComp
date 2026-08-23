<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

/**
 * @property int $id
 * @property int $product_id
 * @property numeric $current
 * @property numeric|null $old
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Product $product
 * @method static \Database\Factories\PriceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Price newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Price newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Price query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Price whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Price whereCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Price whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Price whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Price whereOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Price whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Price whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Price extends Model
{
    use HasFactory;

    //use SoftDeletes;

    protected $fillable = ['product_id', 'current', 'old', 'created_at', 'updated_at'];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['current', 'old', 'created_at', 'updated_at', 'created_now', 'updated_now'];

    protected $casts = [
        'current' => 'float',
        'old' => 'float',
    ];

    /**
     * Get the product that the price belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /***
     * Get pair of creation date (miliseconds), and current price e.g. [1665266400000,74.61]
     */
    public function getXYPair(): string
    {
        return '[' . $this->created_at->startOfDay()->valueOf() . ',' . ($this->current) . ']';
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function currentFormatted(): string
    {
        return number_format($this->current, 2, ",", "") . ' zł ';
    }

    public function oldFormatted(): string
    {
        return number_format($this->old, 2, ",", "") . ' zł ';
    }
}
