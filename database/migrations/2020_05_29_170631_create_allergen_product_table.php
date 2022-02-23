<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllergenProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergen_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('allergen_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
        });
        Schema::table('allergen_product', function (Blueprint $table) {
            $table->foreign('allergen_id')->references('id')->on('allergens')->onDelete('cascade');// Delete allergen_product record if allergen is deleted
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');// Delete allergen_meal record if meal is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allergen_product');
    }
}
