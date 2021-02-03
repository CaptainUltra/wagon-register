<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageWagonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_wagon', function (Blueprint $table) {
            $table->unsignedBigInteger('image_id');
            $table->unsignedBigInteger('wagon_id');
            $table->boolean('primary')->default(false);
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
            $table->foreign('wagon_id')->references('id')->on('wagons')->onDelete('cascade');

            $table->primary(['image_id', 'wagon_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_wagon');
    }
}
