<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealToolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_tool', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meal_id');
            $table->unsignedBigInteger('tool_id');
            $table->timestamps();
        });
        Schema::table('meal_tool', function (Blueprint $table) {
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');// Delete meal_tool record if meal is deleted
            $table->foreign('tool_id')->references('id')->on('tools')->onDelete('cascade');// Delete meal_tool record if tool is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meal_tool', function (Blueprint $table) {
            $table->dropForeign(['meal_id']);
            $table->dropForeign(['tool_id']);
        });
        Schema::dropIfExists('meal_tool');
    }
}
