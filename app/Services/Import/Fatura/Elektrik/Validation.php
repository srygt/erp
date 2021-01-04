<?php


namespace App\Services\Import\Fatura\Elektrik;


use App\Models\AyarEkKalem;
use App\Models\Fatura;
use App\Services\Import\Fatura\Contracts\IFaturaValidation;

class Validation implements IFaturaValidation
{
    public function rules() : array
    {
        return [
            'params.' . EkKalem::ID_DEVREDEN_BORC   => 'required|numeric|ek_kalem_exists:' . AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR,
            'params.' . EkKalem::ID_SISTEM_KULLANIM => 'required|numeric|ek_kalem_exists:' . AyarEkKalem::FIELD_UCRET_BIRIM_FIYAT,
            'params.' . EkKalem::ID_DAGITIM_BEDELI  => 'required|numeric|ek_kalem_exists:' . AyarEkKalem::FIELD_UCRET_BIRIM_FIYAT,
            'params.' . Fatura::COLUMN_BIRIM_FIYAT_TUKETIM => 'required|numeric|min:0',
            'params.' . Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT => 'required|numeric|min:0',
            'params.' . Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT => 'required|numeric|min:0',
            'params.' . EkKalem::BIRIM_FIYAT_SISTEM_KULLANIM => 'required|numeric|min:0',
            'params.' . EkKalem::BIRIM_FIYAT_DAGITIM_BEDELI => 'required|numeric|min:0',
        ];
    }

    public function attributes(): array
    {
        return [
            'params.' . EkKalem::ID_DEVREDEN_BORC   => 'Devreden Borç',
            'params.' . EkKalem::ID_SISTEM_KULLANIM => 'Sistem Kullanım Bedeli',
            'params.' . EkKalem::ID_DAGITIM_BEDELI  => 'Dağıtım Bedeli',
            'params.' . Fatura::COLUMN_BIRIM_FIYAT_TUKETIM => 'Birim Tüketim Fiyat',
            'params.' . Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT => 'Endüktif Birim Fiyat',
            'params.' . Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT => 'Kapasitif Birim Fiyat',
            'params.' . EkKalem::BIRIM_FIYAT_SISTEM_KULLANIM => 'Sistem Birim Fiyat',
            'params.' . EkKalem::BIRIM_FIYAT_DAGITIM_BEDELI => 'Dağıtım Birim Fiyat',
        ];
    }
}
