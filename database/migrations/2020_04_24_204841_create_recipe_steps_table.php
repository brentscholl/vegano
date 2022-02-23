<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meal_id');
            $table->integer('step');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::table('recipe_steps', function (Blueprint $table) {
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade'); // Delete recipe_Step record if meal is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_steps');
    }
}
