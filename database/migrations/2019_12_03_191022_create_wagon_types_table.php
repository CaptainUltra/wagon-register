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
            $table->string('name');
            $table->unique('name');
            $table->boolean('conditioned');
            $table->integer('interior_type_id');
            $table->integer('index_image_id')->nullable();
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
