<?php

use App\Models\AyarEkKalem;
use App\Models\Abone;
use Illuminate\Database\Seeder;

class AyarEkKalemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                AyarEkKalem::COLUMN_TUR         => Abone::COLUMN_TUR_ELEKTRIK,
                AyarEkKalem::COLUMN_UCRET_TUR   => AyarEkKalem::FIELD_UCRET_ORAN,
                AyarEkKalem::COLUMN_BASLIK      => 'Dağıtım Bedeli',
                AyarEkKalem::COLUMN_DEGER       => 0.0251
            ],
            [
                AyarEkKalem::COLUMN_TUR         => Abone::COLUMN_TUR_ELEKTRIK,
                AyarEkKalem::COLUMN_UCRET_TUR   => AyarEkKalem::FIELD_UCRET_ORAN,
                AyarEkKalem::COLUMN_BASLIK      => 'Sistem Kullanım Bedeli',
                AyarEkKalem::COLUMN_DEGER       => 0.0362
            ],
            [
                AyarEkKalem::COLUMN_TUR         => Abone::COLUMN_TUR_ELEKTRIK,
                AyarEkKalem::COLUMN_UCRET_TUR   => AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR,
                AyarEkKalem::COLUMN_BASLIK      => 'Devreden Borç',
                AyarEkKalem::COLUMN_DEGER       => null,
            ],
            [
                AyarEkKalem::COLUMN_TUR         => Abone::COLUMN_TUR_SU,
                AyarEkKalem::COLUMN_UCRET_TUR   => AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR,
                AyarEkKalem::COLUMN_BASLIK      => 'Devreden Borç',
                AyarEkKalem::COLUMN_DEGER       => null,
            ],
            [
                AyarEkKalem::COLUMN_TUR         => Abone::COLUMN_TUR_DOGALGAZ,
                AyarEkKalem::COLUMN_UCRET_TUR   => AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR,
                AyarEkKalem::COLUMN_BASLIK      => 'Devreden Borç',
                AyarEkKalem::COLUMN_DEGER       => null,
            ],
        ];

        collect($data)->each(function($ayarEkKalem){
            AyarEkKalem::create($ayarEkKalem);
        });
    }
}
