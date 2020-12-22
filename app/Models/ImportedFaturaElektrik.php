<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportedFaturaElektrik extends Model
{
    protected $casts = [
        self::COLUMN_IS_TRT_PAYI    => 'boolean',
    ];

    const COLUMN_GUNDUZ_TUKETIM         = 'gunduz_tuketim';
    const COLUMN_PUAND_TUKETIM          = 'puand_tuketim';
    const COLUMN_GECE_TUKETIM           = 'gece_tuketim';
    const COLUMN_ENDUKTIF_TUKETIM       = 'enduktif_tuketim';
    const COLUMN_ENDUKTIF_BIRIM_FIYAT   = 'enduktif_birim_fiyat';
    const COLUMN_KAPASITIF_TUKETIM      = 'kapasitif_tuketim';
    const COLUMN_KAPASITIF_BIRIM_FIYAT  = 'kapasitif_birim_fiyat';
    const COLUMN_IS_TRT_PAYI            = 'is_trt_payi';
    const COLUMN_IMPORTED_FATURA_ID     = 'imported_fatura_id';
}
