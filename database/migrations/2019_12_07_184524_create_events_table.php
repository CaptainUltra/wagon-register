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
            $table->foreign('wagon_id')->references('id')->on('wagons');
            $table->integer('type_id');
            $table->foreign('type_id')->references('id')->on('event_types');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('date');
            //TODO: Add other columns 
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
        Schema::dropIfExists('events');
    }
}
