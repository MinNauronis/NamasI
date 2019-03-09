<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curtain_id');
            $table->unsignedInteger('owner_id');
            $table->string('title');
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('curtain_id')->references('id')->on('curtains');
            $table->foreign('owner_id')->references('id')->on('users');
        });

        Schema::table('curtains', function (Blueprint $table) {
            $table->unsignedInteger('select_schedule_id')->nullable()->default(null);

            $table->foreign('select_schedule_id')->references('id')->on('schedules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curtains', function (Blueprint $table) {
            $table->dropForeign('curtains_select_schedule_id_foreign');
            $table->dropColumn('select_schedule_id');
        });

        Schema::dropIfExists('schedules');
    }
}
