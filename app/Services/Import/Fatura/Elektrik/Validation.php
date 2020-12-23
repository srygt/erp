<?php


namespace App\Services\Import\Fatura\Elektrik;


use App\Models\AyarEkKalem;
use App\Services\Import\Fatura\Contracts\IFaturaValidation;

class Validation implements IFaturaValidation
{
    public function rules() : array
    {
        return [
            'params.' . EkKalem::ID_DEVREDEN_BORC   => 'required|numeric|ek_kalem_exists:' . AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR,
            'params.' . EkKalem::ID_SISTEM_KULLANIM => 'required|numeric|ek_kalem_exists:' . AyarEkKalem::FIELD_UCRET_BIRIM_FIYAT,
            'params.' . EkKalem::ID_DAGITIM_BEDELI  => 'required|numeric|ek_kalem_exists:' . AyarEkKalem::FIELD_UCRET_BIRIM_FIYAT,
        ];
    }

    public function attributes(): array
    {
        return [
            'params.' . EkKalem::ID_DEVREDEN_BORC   => 'Devreden Borç',
            'params.' . EkKalem::ID_SISTEM_KULLANIM => 'Sistem Kullanım Bedeli',
            'params.' . EkKalem::ID_DAGITIM_BEDELI  => 'Dağıtım Bedeli',
        ];
    }
}
