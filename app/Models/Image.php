<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;
    //use SoftDeletes;


    protected  $fillable = ['product_id', 'url', 'created_at', 'updated_at'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['url', 'created_now'];

    /**
     * Get the product that the image belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function shop()
    {
        return $this->product->shop();
    }

    public function getUrl($preferredSize = null)
    {
        //todo: https://res.cloudinary.com
        if (!$this->url)
            return '';
        if ($preferredSize == null)
            return $this->url;

        if (Str::startsWith($this->url, 'https://www.carrefour.pl/images/product/')) {
            $re = '/(https?:\/\/www\.carrefour\.pl\/images\/product)\/(\d+)x(\d+)\//';
            return preg_replace($re, "$1/" . $preferredSize . "x" . $preferredSize . "/", $this->url);
        }
        if (Str::startsWith($this->url, 'https://sklep.stokrotka.pl/files/foto')) {
            //fotos - 96px
            //fotom - 460px
            //fotob - 768px
            $size = "s";
            if ($preferredSize > 278)
                $size = "m";

            if ($preferredSize > 614)
                $size = "b";

            $re = '/(https?:\/\/sklep\.stokrotka\.pl\/files\/foto)[sbm]\//';
            return preg_replace($re, "$1" . $size . "/", $this->url);
        }
        if (Str::startsWith($this->url, 'https://leclerc24gliwice.pl/public/upload/sellasist_cache/thumb_page_')) {
            //thumb_page_small - 140px
            //thumb_page - 448px
            $size = "thumb_page_small_";
            if ($preferredSize > 294)
                $size = "thumb_page_";

            $re = '/(https:\/\/leclerc24gliwice\.pl\/public\/upload\/sellasist_cache\/)(thumb_page_small|thumb_page)_/';
            return preg_replace($re, "$1" . $size, $this->url);
        }

        return $this->url;
    }
}
