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
        self::COLUMN_VARSAYILAN_DURUM,
    ];

    protected $casts = [
        self::COLUMN_VARSAYILAN_DURUM   => 'boolean',
    ];

    const COLUMN_ID                     = 'id';
    const COLUMN_BASLIK                 = 'baslik';
    const COLUMN_DEGER                  = 'deger';
    const COLUMN_TUR                    = 'tur';
    const COLUMN_UCRET_TUR              = 'ucret_tur';
    const COLUMN_VARSAYILAN_DURUM       = 'varsayilan_durum';

    const FIELD_UCRET_BIRIM_FIYAT       = 'birim_fiyat';
    const FIELD_UCRET_DEGISKEN_TUTAR    = 'degisken_tutar';

    const LIST_UCRET_TUR                = [
        self::FIELD_UCRET_BIRIM_FIYAT       => 'Birim Fiyat',
        self::FIELD_UCRET_DEGISKEN_TUTAR    => 'Değişken Tutar',
    ];
}
