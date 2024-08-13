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
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_id')->default(1);
            $table->double('total_shipping_cost')->default('0.00');
            $table->string('delivery_status')->default('order_placed');
            $table->string('payment_status')->default('unpaid');
            $table->dateTime('delivered_date')->nullable();
            $table->double('discount_value')->default(0.00);
            $table->string('discount_type')->nullable();
            $table->date('expected_delivery_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            //
        });
    }
};
