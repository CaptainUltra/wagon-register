<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInteriorTypeIdForeignKeyConstraintToWagonTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wagon_types', function (Blueprint $table) {
            $table->unsignedBigInteger('interior_type_id')->change();
            $table->foreign('interior_type_id')->references('id')->on('interior_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wagon_types', function (Blueprint $table) {
            $table->dropForeign('wagon_types_interior_type_id_foreign');
        });
    }
}
