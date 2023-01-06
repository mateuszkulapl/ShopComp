<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    //use SoftDeletes;


    protected  $fillable = ['product_id','url'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['url','created_now'];

    /**
     * Get the product that the image belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
