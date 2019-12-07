<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWagonTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wagon_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wagon_type');
            $table->unique('wagon_type');
            $table->boolean('conditioned');
            $table->integer('interior_type_id');
            $table->foreign('interior_type_id')->references('id')->on('interior_types');
            $table->integer('index_image_id');
            $table->foreign('index_image_id')->references('id')->on('images');
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
        Schema::dropIfExists('wagon_types');
    }
}
