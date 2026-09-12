<?php

use App\Scraping\RedetailPolicy;

return [
    'detail_ttl_days' => (int) env('SCRAPER_DETAIL_TTL_DAYS', 0), // 0 = bez TTL

    'redetail_policy' => RedetailPolicy::class,

    'redetail_policies_per_shop' => [
        // 'shop.example.com.' => \App\Scraping\ShopExcampleDotComRedetailPolicy::class,
    ],
];
