<?php

use App\AyarEkKalem;
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
                AyarEkKalem::COLUMN_TUR     => Abone::COLUMN_TUR_ELEKTRIK,
                AyarEkKalem::COLUMN_BASLIK  => 'Dağıtım Bedeli',
                AyarEkKalem::COLUMN_DEGER   => 0.0251
            ],
            [
                AyarEkKalem::COLUMN_TUR     => Abone::COLUMN_TUR_ELEKTRIK,
                AyarEkKalem::COLUMN_BASLIK  => 'Sistem Kullanım Bedeli',
                AyarEkKalem::COLUMN_DEGER   => 0.0362
            ],
        ];

        collect($data)->each(function($ayarEkKalem){
            AyarEkKalem::create($ayarEkKalem);
        });
    }
}
