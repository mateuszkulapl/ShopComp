<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeyColumnToCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Schema::table('categories', function (Blueprint $table) {
        //     $table->string('shop_unique_cat_key')->after('url');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('categories', function(Blueprint $table) {
        //     $table->dropColumn('shop_unique_cat_key');
        // });
    }
}
