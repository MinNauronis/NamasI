<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLDRValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ldr_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curtain_id');
            $table->float('value');
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
        Schema::dropIfExists('l_d_r_values');
    }
}
