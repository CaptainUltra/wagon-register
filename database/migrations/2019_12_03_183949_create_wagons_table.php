<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWagonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wagons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->integer('type');
            $table->foreign('type')->references('id')->on('wagon_types');
            $table->string('letter_index')->nullable();
            $table->integer('v_max')->nullable();
            $table->integer('seats')->nullable();
            $table->integer('depot');
            $table->foreign('depot')->references('id')->on('depots');
            $table->integer('revision_point')->nullable();
            $table->foreign('revisory_point')->references('id')->on('revisory_points');
            $table->date('revision_date')->nullable();
            $table->date('revision_exp_date')->nullable();
            $table->int('index_image')->nullable();  
            $table->foreign('index_image')->references('id')->on('images');
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
        Schema::dropIfExists('wagons');
    }
}
