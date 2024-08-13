<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('pettype_id');
            $table->unsignedBigInteger('breed_id')->nullable();
            $table->string('size')->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->double('weight')->nullable();
            $table->double('height')->nullable();
            $table->string('weight_unit')->nullable();
            $table->string('height_unit')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->longText('additional_info')->nullable();
            $table->boolean('status')->default(1);

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('pettype_id')
            ->references('id')
            ->on('pets_type')
            ->onDelete('cascade');
          
            $table->foreign('breed_id')
            ->references('id')
            ->on('breeds')
            ->onDelete('cascade');


            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
};
