<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->timestamp('detail_scraped_at')->nullable();
            $table->timestamp('listing_scraped_at')->nullable();
        });

        // Before this column existed, every product update came from a full
        // product-page scrape, so updated_at already recorded the last detail
        // scrape. Backfill it so existing products aren't treated as never
        // detail-scraped once the TTL policy starts reading this column.
        DB::table('products')->update(['detail_scraped_at' => DB::raw('updated_at')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['detail_scraped_at', 'listing_scraped_at']);
        });
    }
};
