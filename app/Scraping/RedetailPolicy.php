<?php

declare(strict_types=1);

namespace App\Scraping;

use App\Models\Product;
use Carbon\Carbon;

/**
 * Decides whether a listing update for an already-known product should also
 * trigger a full product-page re-scrape.
 */
class RedetailPolicy
{
    /**
     * @param  array<string, mixed>  $postedProduct
     */
    public function needsRedetail(Product $product, array $postedProduct): bool
    {
        return $this->detailTtlExpired($product);
    }

    protected function detailTtlExpired(Product $product): bool
    {
        $ttlDays = (int) config('scrapers.detail_ttl_days');
        if ($ttlDays <= 0) {
            return false;
        }

        return $product->detail_scraped_at === null
            || $product->detail_scraped_at->lt(Carbon::now()->subDays($ttlDays));
    }
}
