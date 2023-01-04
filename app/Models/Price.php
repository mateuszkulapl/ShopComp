<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = ['product_id', 'current', 'old', 'created_at'];
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
    public function getXYPair()
    {
        return '[' . $this->created_at->startOfDay()->valueOf() . ',' . ($this->current) . ']';
    }
}
