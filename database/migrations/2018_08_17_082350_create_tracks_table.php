<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            //load information
            $table->string('code');
            $table->string('from');
            $table->string('to');

            $table->string('load_pc')->nullable();
            $table->string('load_lbs')->nullable();

            $table->string('dims')->nullable();

            //load status

            $table->string('at_origin')->nullable();
            $table->dateTime('at_origin_date')->nullable();

            $table->string('current_location')->nullable();
            $table->dateTime('current_location_date')->nullable();

            $table->string('at_distination')->nullable();
            $table->dateTime('at_distination_date')->nullable();

            $table->dateTime('delivered')->nullable();

            //Load summary

            $table->enum('status', [0, 1, 2, 3, 4])->nullable();

            $table->string('pod')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}
