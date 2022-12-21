<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    //use SoftDeletes;

    /**
     * Get the product that the image belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
