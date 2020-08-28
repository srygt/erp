<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AyarEkKalem extends Model
{
    protected $table = 'ayarlar_ek_kalemler';

    protected $fillable                 = [
        self::COLUMN_BASLIK,
        self::COLUMN_DEGER,
        self::COLUMN_TUR,
        self::COLUMN_UCRET_TUR,
    ];

    const COLUMN_BASLIK                 = 'baslik';
    const COLUMN_DEGER                  = 'deger';
    const COLUMN_TUR                    = 'tur';
    const COLUMN_UCRET_TUR              = 'ucret_tur';

    const FIELD_UCRET_ORAN              = 'oran';
    const FIELD_UCRET_DEGISKEN_TUTAR    = 'degisken_tutar';

    const LIST_UCRET_TUR                = [
        self::FIELD_UCRET_ORAN              => 'Oran',
        self::FIELD_UCRET_DEGISKEN_TUTAR    => 'Değişken Tutar',
    ];
}
