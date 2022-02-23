<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->text('description')->nullable();
            $table->integer('calories')->nullable();
            $table->integer('fat')->nullable();
            $table->integer('carbs')->nullable();
            $table->integer('protein')->nullable();
            $table->string('weight')->nullable()->comment('in grams');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->integer('inventory')->default('0')->nullable();
            $table->string('sku')->nullable();
            $table->integer('price')->nullable()->comment('price in cents');
            $table->boolean('published')->default('0')->comment('1 = published, 0 = not published');
            $table->string('type')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
