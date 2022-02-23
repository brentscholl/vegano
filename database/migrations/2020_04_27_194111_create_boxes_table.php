<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('status')->nullable()->comment('skipped, ordered, open, completed');
            $table->string('order_status')->nullable()->comment('pending, in-pep, ready-for-shipping, shipped, delivered');
            $table->date('start_date')->nullable()->comment('starts on a sunday');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('boxes', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boxes');
    }
}
