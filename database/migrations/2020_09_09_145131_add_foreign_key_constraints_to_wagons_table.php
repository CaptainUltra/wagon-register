<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyConstraintsToWagonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wagons', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->change();
            $table->foreign('type_id')->references('id')->on('wagon_types')->onDelete('cascade');
            $table->unsignedBigInteger('depot_id')->change();
            $table->foreign('depot_id')->references('id')->on('depots')->onDelete('set null');
            $table->unsignedBigInteger('revisory_point_id')->change();
            $table->foreign('revisory_point_id')->references('id')->on('revisory_points')->onDelete('set null');
            $table->unsignedBigInteger('status_id')->change();
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wagons', function (Blueprint $table) {
            $table->dropForeign('wagons_type_id_foreign');
            $table->dropForeign('wagons_depot_id_foreign');
            $table->dropForeign('wagons_revisory_point_id_foreign');
            $table->dropForeign('wagons_status_id_foreign');
        });
    }
}
