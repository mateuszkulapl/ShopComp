<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    //use SoftDeletes;

    // /**
    //  * The products that belong to the category.
    //  */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
