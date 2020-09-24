<?php

use App\Models\Abone;
use App\Models\Mukellef;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAktifMiFieldToMukelleflerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mukellefler', function (Blueprint $table) {
            $table->boolean(Mukellef::COLUMN_AKTIF_MI)->default(true)->after('id')->index();
        });
        Schema::table('abonelikler', function (Blueprint $table) {
            $table->boolean(Abone::COLUMN_AKTIF_MI)->default(true)->change();
        });

        Mukellef::query()->update([
            Mukellef::COLUMN_AKTIF_MI  => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mukellefler', function (Blueprint $table) {
            $table->dropColumn(Mukellef::COLUMN_AKTIF_MI);
        });

        Schema::table('abonelikler', function (Blueprint $table) {
            $table->boolean(Abone::COLUMN_AKTIF_MI)->nullable(false)->default(null)->change();
        });
    }
}
