<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_meal', function (Blueprint $table) {
            $table->id();
            $table->string('country_id');
            $table->unsignedBigInteger('meal_id');
            $table->timestamps();
        });

        Schema::table('country_meal', function (Blueprint $table) {
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_meal');
    }
}
