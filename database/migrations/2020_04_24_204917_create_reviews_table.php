<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('meal_id');
            $table->integer('star_rating');
            $table->string('body');
            $table->timestamps();
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Delete review record if user is deleted
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade'); // Delete review record if meal is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
