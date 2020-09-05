<?php

use App\Models\Abone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnduktifAndKapasitifFieldsToAboneliklerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abonelikler', function (Blueprint $table) {
            $table->boolean(Abone::COLUMN_ENDUKTIF_BEDEL)->nullable();
            $table->boolean(Abone::COLUMN_KAPASITIF_BEDEL)->nullable();
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
            $table->dropColumn([Abone::COLUMN_ENDUKTIF_BEDEL, Abone::COLUMN_KAPASITIF_BEDEL]);
        });
    }
}
