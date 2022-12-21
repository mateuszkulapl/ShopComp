<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use HasFactory;
    //use SoftDeletes;

    /**
     * Get the product that the price belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
