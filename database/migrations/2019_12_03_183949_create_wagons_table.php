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
            $table->string('type');
            $table->string('letter_index');
            $table->integer('v_max');
            $table->integer('seats');
            $table->integer('revision_point');
            $table->date('revision_date');
            $table->date('revision_exp_date');
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
        Schema::dropIfExists('wagons');
    }
}
