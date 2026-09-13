<?php

declare(strict_types=1);

namespace App\Scraping;

use App\Models\Shop;

class RedetailPolicyResolver
{
    public function resolve(Shop $shop): RedetailPolicy
    {
        $perShop = config('scrapers.redetail_policies_per_shop', []);
        $policyClass = $perShop[$shop->name] ?? config('scrapers.redetail_policy', RedetailPolicy::class);

        return app($policyClass);
    }
}
