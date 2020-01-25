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
            $table->integer('type_id');
            $table->string('letter_index')->nullable();
            $table->integer('v_max')->nullable();
            $table->integer('seats')->nullable();
            $table->integer('depot_id')->nullable();
            $table->integer('revisory_point_id')->nullable();
            $table->date('revision_date')->nullable();
            $table->date('revision_exp_date')->nullable();
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
        Schema::dropIfExists('wagons');
    }
}
