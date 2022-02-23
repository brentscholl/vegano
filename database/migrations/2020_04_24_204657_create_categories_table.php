<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug');
            $table->integer('order');
            $table->timestamps();
        });
        DB::table('categories')->insert([
            ['id' => '1', 'title' => 'Dinner', 'slug' => 'dinner', 'order' => '1'],
            ['id' => '2', 'title' => 'Lunch', 'slug' => 'lunch', 'order' => '2'],
            ['id' => '3', 'title' => 'Breakfast', 'slug' => 'breakfast', 'order' => '3'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
