<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AyarEkKalem extends Model
{
    protected $table = 'ayarlar_ek_kalemler';

    const COLUMN_BASLIK     = 'baslik';
    const COLUMN_DEGER      = 'deger';
    const COLUMN_TUR        = 'tur';

    protected $fillable     = [
        self::COLUMN_BASLIK,
        self::COLUMN_DEGER,
        self::COLUMN_TUR,
    ];
}
