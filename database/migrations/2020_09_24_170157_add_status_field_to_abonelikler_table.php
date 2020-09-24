<?php

use App\Models\Abone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusFieldToAboneliklerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abonelikler', function (Blueprint $table) {
            $table->boolean(Abone::COLUMN_AKTIF_MI)->after('id')->index();
        });

        Abone::query()->update([
            Abone::COLUMN_AKTIF_MI  => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abonelikler', function (Blueprint $table) {
            $table->dropColumn(Abone::COLUMN_AKTIF_MI);
        });
    }
}
