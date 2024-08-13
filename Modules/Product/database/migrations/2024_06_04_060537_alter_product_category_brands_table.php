<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_category_brands', function (Blueprint $table) {
            $table->integer('product_id');
            $table->integer('brand_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_category_brands', function (Blueprint $table) {
            $table->dropColumn('product_id');
            $table->integer('brand_id')->nullable(false)->change();
        });
    }
};
