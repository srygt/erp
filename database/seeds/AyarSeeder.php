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
            Ayar::FIELD_ELEKTRIK_BANKA_HESAP_ADI        => 'DİYARBAKIR ORGANİZE SANAYİ TEŞEBBÜS TEŞVİK BAŞKANLIĞI',
            Ayar::FIELD_ELEKTRIK_BANKA_IBAN             => 'TR57 0001 2001 7270 0016 1000 04',
            Ayar::FIELD_ELEKTRIK_SON_ODEME_GUN          => 15,
            Ayar::FIELD_ELEKTRIK_TUKETIM_BIRIM_FIYAT    => 0.451779,
            Ayar::FIELD_ELEKTRIK_FATURA_ACIKLAMA        => 'Varsayılan Elektrik Faturası Açıklaması',
            Ayar::FIELD_SU_BANKA_HESAP_ADI              => 'DİYARBAKIR ORGANİZE SANAYİ TEŞEBBÜS TEŞVİK BAŞKANLIĞI',
            Ayar::FIELD_SU_BANKA_IBAN                   => 'TR57 0001 2001 7270 0016 1000 03',
            Ayar::FIELD_SU_SON_ODEME_GUN                => 16,
            Ayar::FIELD_SU_TUKETIM_BIRIM_FIYAT          => 0.054321,
            Ayar::FIELD_SU_FATURA_ACIKLAMA              => 'Varsayılan Su Faturası Açıklaması',
            Ayar::FIELD_DOGALGAZ_BANKA_HESAP_ADI        => 'DİYARBAKIR ORGANİZE SANAYİ TEŞEBBÜS TEŞVİK BAŞKANLIĞI',
            Ayar::FIELD_DOGALGAZ_BANKA_IBAN             => 'TR57 0001 2001 7270 0016 1000 06',
            Ayar::FIELD_DOGALGAZ_SON_ODEME_GUN          => 17,
            Ayar::FIELD_DOGALGAZ_TUKETIM_BIRIM_FIYAT    => 0.152195,
            Ayar::FIELD_DOGALGAZ_FATURA_ACIKLAMA        => 'Varsayılan Doğalgaz Faturası Açıklaması',
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
