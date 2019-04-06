<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id');
            $table->unsignedInteger('curtain_id');
            $table->unsignedTinyInteger('brightness')->default(10);
            $table->string('color')->default('{"red":0,"green":0,"blue":50}');
            $table->string('mode')->default('static');
            $table->unsignedSmallInteger('change_rate')->default(100);
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('curtain_id')->references('id')->on('curtains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leds');
    }
}
