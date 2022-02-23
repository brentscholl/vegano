<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('country');
            $table->timestamps();
        });
        DB::table('countries')->insert([
            ['id' => '1', 'code' => 'cad', 'country' => 'Canada'],
            ['id' => '2', 'code' => 'usa', 'country' => 'United States'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
