<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyConstraintsToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('wagon_id')->change();
            $table->foreign('wagon_id')->references('id')->on('wagons')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('station_id')->change();
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->unsignedBigInteger('train_id')->change();
            $table->foreign('train_id')->references('id')->on('trains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_wagon_id_foreign');
            $table->dropForeign('events_user_id_foreign');
            $table->dropForeign('events_station_id_foreign');
            $table->dropForeign('events_train_id_foreign');
        });
    }
}
