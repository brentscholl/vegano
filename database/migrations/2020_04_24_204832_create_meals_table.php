<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->text('description')->nullable();
            $table->integer('time')->nullable()->comment('time in minutes');
            $table->integer('calories')->nullable();
            $table->integer('fat')->nullable();
            $table->integer('carbs')->nullable();
            $table->integer('protein')->nullable();
            $table->integer('servings')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->integer('inventory')->default('0')->nullable();
            $table->string('sku')->nullable();
            $table->boolean('premium')->default('0');
            $table->boolean('published')->default('0')->comment('1 = published, 0 = not published');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('chef_id')->nullable();
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('meals', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('images');
            $table->foreign('chef_id')->references('id')->on('chefs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meals');
    }
}
