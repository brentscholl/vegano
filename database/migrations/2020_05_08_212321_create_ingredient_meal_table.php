<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_meal', function (Blueprint $table) {
            $table->id();
            $table->string('measurement')->nullable();
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('meal_id');
            $table->timestamps();
        });
        Schema::table('ingredient_meal', function (Blueprint $table) {
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');// Delete meal_tool record if meal is deleted
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');// Delete meal_ingredient record if ingredient is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingredient_meal', function (Blueprint $table) {
            $table->dropForeign(['meal_id']);
            $table->dropForeign(['ingredient_id']);
        });
        Schema::dropIfExists('ingredient_meal');
    }
}
