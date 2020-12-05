<?php

use App\Models\AyarEkKalem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVarsayilanDurumFieldToAyarlarEkKalemlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ayarlar_ek_kalemler', function (Blueprint $table) {
            $table->boolean(AyarEkKalem::COLUMN_VARSAYILAN_DURUM);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ayarlar_ek_kalemler', function (Blueprint $table) {
            $table->dropColumn([
                AyarEkKalem::COLUMN_VARSAYILAN_DURUM
            ]);
        });
    }
}
