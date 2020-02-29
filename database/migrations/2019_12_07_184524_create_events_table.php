<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('wagon_id');
            $table->integer('user_id');
            $table->integer('station_id')->nullable();
            $table->integer('train_id')->nullable();
            $table->date('date');
            $table->string('comment')->nullable();
            $table->timestamps();

            /*$table->foreign('wagon_id')->references('id')->on('wagons');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('station_id')->references('id')->on('stations');
            $table->foreign('train_id')->references('id')->on('trains');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
