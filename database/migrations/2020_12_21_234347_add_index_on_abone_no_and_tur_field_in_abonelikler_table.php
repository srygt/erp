<?php

use App\Models\Abone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexOnAboneNoAndTurFieldInAboneliklerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abonelikler', function (Blueprint $table) {
            $table->index(Abone::COLUMN_ABONE_NO);
            $table->index(Abone::COLUMN_TUR);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abonelikler', function (Blueprint $table) {
            $table->dropIndex([Abone::COLUMN_ABONE_NO]);
            $table->dropIndex([Abone::COLUMN_TUR]);
        });
    }
}
