<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_meal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('meal_id');
            $table->timestamps();
        });
        Schema::table('category_meal', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');// Delete category_meal record if category is deleted
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');// Delete category_meal record if meal is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_meal', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['meal_id']);
        });
        Schema::dropIfExists('category_meal');
    }
}
