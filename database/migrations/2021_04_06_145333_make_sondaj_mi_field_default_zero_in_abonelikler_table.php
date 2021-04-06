<?php

use App\Models\Abone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeSondajMiFieldDefaultZeroInAboneliklerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abonelikler', function (Blueprint $table) {
            $table->boolean(Abone::COLUMN_SONDAJ_MI)->default('0')
                ->change();
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
            $table->boolean(Abone::COLUMN_SONDAJ_MI)->default(false)
                ->change();
        });
    }
}
