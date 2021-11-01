<?php

use App\Models\Abone;
use App\Models\Ayar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSondajMiFieldToAboneliklerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function up()
    {
        Schema::table('abonelikler', function (Blueprint $table) {
            $table->boolean(Abone::COLUMN_SONDAJ_MI)->default(false);
        });

        \Illuminate\Support\Facades\DB::transaction(function() {
            $birimFiyat = Ayar::where('baslik', 'su.tuketim_birim_fiyat')
                ->first();
            
            if (is_null($birimFiyat)) {
                return;
            }
            
            $birimFiyat->{Ayar::COLUMN_BASLIK} = Ayar::FIELD_SU_SEBEKE_TUKETIM_BIRIM_FIYAT;
            $birimFiyat->save();

            $sondajBirimFiyat = new Ayar();
            $sondajBirimFiyat->{Ayar::COLUMN_BASLIK} = Ayar::FIELD_SU_SONDAJ_TUKETIM_BIRIM_FIYAT;
            $sondajBirimFiyat->{Ayar::COLUMN_DEGER} = '0.00001';
            $sondajBirimFiyat->save();
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
            $table->dropColumn(Abone::COLUMN_SONDAJ_MI);
        });

        \Illuminate\Support\Facades\DB::transaction(function() {
            $birimFiyat = Ayar::where('baslik', Ayar::FIELD_SU_SEBEKE_TUKETIM_BIRIM_FIYAT)
                ->first();
            
            if (is_null($birimFiyat)) {
                return;
            }
            
            $birimFiyat->{Ayar::COLUMN_BASLIK} = 'su.tuketim_birim_fiyat';
            $birimFiyat->save();

            $sondajBirimFiyat = Ayar::where('baslik', Ayar::FIELD_SU_SONDAJ_TUKETIM_BIRIM_FIYAT)
                ->first();
            $sondajBirimFiyat->delete();
        });
    }
}
