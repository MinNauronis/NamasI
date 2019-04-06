<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDhtValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dht_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curtain_id');
            $table->float('humidity', 5, 2);
            $table->float('temperature', 5, 2);
            $table->timestamps();

            $table->foreign('curtain_id')->references('id')->on('curtains');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dht_values');
    }
}
