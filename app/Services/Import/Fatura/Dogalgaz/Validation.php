<?php

namespace App\Services\Import\Fatura\Dogalgaz;

use App\Models\AyarEkKalem;
use App\Models\Fatura;
use App\Services\Import\Fatura\Contracts\IFaturaValidation;

class Validation implements IFaturaValidation
{
    public function rules() : array
    {
        return [
            'params.' . EkKalem::ID_GECIKME_BEDELI   => 'required|numeric|ek_kalem_exists:' . AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR,
            'params.' . Fatura::COLUMN_BIRIM_FIYAT_TUKETIM => 'required|numeric|min:0',
        ];
    }

    public function attributes(): array
    {
        return [
            'params.' . EkKalem::ID_GECIKME_BEDELI   => 'Gecikme Bedeli',
            'params.' . Fatura::COLUMN_BIRIM_FIYAT_TUKETIM => 'Birim Tüketim Fiyat',
        ];
    }
}
