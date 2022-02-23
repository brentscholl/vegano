<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllergenMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergen_meal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('allergen_id');
            $table->unsignedBigInteger('meal_id');
            $table->timestamps();
        });
        Schema::table('allergen_meal', function (Blueprint $table) {
            $table->foreign('allergen_id')->references('id')->on('allergens')->onDelete('cascade');// Delete allergen_meal record if allergen is deleted
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');// Delete allergen_meal record if meal is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('allergen_meal', function (Blueprint $table) {
            $table->dropForeign(['allergen_id']);
            $table->dropForeign(['meal_id']);
        });
        Schema::dropIfExists('allergen_meal');
    }
}
