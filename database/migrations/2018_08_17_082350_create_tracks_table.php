<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('code');
            $table->string('from');
            $table->string('to');
            $table->string('dimansions')->nullable();//            additional fields, not required
            $table->dateTime('start_time');
//            additional fields, not required
            $table->string('at_origin')->nullable();
            $table->string('freight_loaded')->nullable();
            $table->string('current_location')->nullable();
            $table->dateTime('end_time');//at destination
            $table->string('delivered')->nullable();
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
