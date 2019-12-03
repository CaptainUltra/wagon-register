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
            $table->primary('wagon_type');
            $table->string('wagon_type');
            $table->boolean('conditioned');
            $table->string('interior_type'); //TODO: Should this be in a separate table?
            $table->string('index_image');
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
