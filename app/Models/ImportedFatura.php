<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ImportedFatura extends Model
{
    const COLUMN_ABONE_ID               = 'abone_id';
    const COLUMN_TUR                    = 'tur';
    const COLUMN_FATURA_TARIH           = 'fatura_tarih';
    const COLUMN_SON_ODEME_TARIHI       = 'son_odeme_tarihi';
    const COLUMN_ENDEKS_ILK             = 'ilk_endeks';
    const COLUMN_ENDEKS_SON             = 'son_endeks';
    const COLUMN_BIRIM_FIYAT_TUKETIM    = 'birim_fiyat';
    const COLUMN_NOT                    = 'not';
    const COLUMN_OKUYAN_ID              = 'okuyan_id';
    const COLUMN_IP_NO                  = 'ip_no';

    /**
     * @return HasOne
     */
    public function elektrik()
    {
        return $this->hasOne(ImportedFaturaElektrik::class);
    }
}