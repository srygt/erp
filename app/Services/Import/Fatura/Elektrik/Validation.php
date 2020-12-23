<?php


namespace App\Services\Import\Fatura\Elektrik;


use App\Models\AyarEkKalem;
use App\Services\Import\Fatura\Contracts\IFaturaValidation;

class Validation implements IFaturaValidation
{
    public function rules() : array
    {
        return [
            'params'                    => 'required|array',
            'params.gecikme_kalemi_id'  => 'required|numeric|ek_kalem_exists:' . AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR,
            'params.sistem_kullanim_id' => 'required|numeric|ek_kalem_exists:' . AyarEkKalem::FIELD_UCRET_BIRIM_FIYAT,
            'params.dagitim_id'         => 'required|numeric|ek_kalem_exists:' . AyarEkKalem::FIELD_UCRET_BIRIM_FIYAT,
        ];
    }

    public function attributes(): array
    {
        return [
            'params'                    => 'Parametreler',
            'params.gecikme_kalemi_id'  => 'Devreden Borç',
            'params.sistem_kullanim_id' => 'Sistem Kullanım Bedeli',
            'params.dagitim_id'         => 'Dağıtım Bedeli',
        ];
    }
}
