<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainWagontypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_wagon_type', function (Blueprint $table) {
            $table->unsignedBigInteger('train_id');
            $table->unsignedBigInteger('wagon_type_id');
            $table->integer('position');
            $table->foreign('train_id')->references('id')->on('trains')->onDelete('cascade');
            $table->foreign('wagon_type_id')->references('id')->on('wagon_types')->onDelete('cascade');

            $table->primary(['train_id', 'wagon_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('train_wagon_type');
    }
}
