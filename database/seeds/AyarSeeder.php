<?php

use App\Models\Ayar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AyarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            Ayar::FIELD_ELEKTRIK_SON_ODEME_GUN          => 15,
            Ayar::FIELD_ELEKTRIK_TUKETIM_BIRIM_FIYAT    => 0.451779,
            Ayar::FIELD_ELEKTRIK_DAGITIM_BIRIM_FIYAT    => 0.0251,
            Ayar::FIELD_ELEKTRIK_SISTEM_BIRIM_FIYAT     => 0.0362,
            Ayar::FIELD_SU_SON_ODEME_GUN                => 16,
            Ayar::FIELD_SU_TUKETIM_BIRIM_FIYAT          => 0.054321,
            Ayar::FIELD_DOGALGAZ_SON_ODEME_GUN          => 17,
            Ayar::FIELD_DOGALGAZ_TUKETIM_BIRIM_FIYAT    => 0.152195,
        ];

        $data = collect($data)->map(function($value, $key){
            return [
                Ayar::COLUMN_BASLIK     => $key,
                Ayar::COLUMN_DEGER      => $value,
            ];
        })->sort();

        DB::table((new Ayar)->getTable())->insert($data->toArray());
    }
}
