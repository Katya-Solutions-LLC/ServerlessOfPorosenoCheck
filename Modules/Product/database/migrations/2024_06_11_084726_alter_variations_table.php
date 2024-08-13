<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Product\Models\Variations;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Variations::whereNull('created_by')->update(['created_by' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    
};
