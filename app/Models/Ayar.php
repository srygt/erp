<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayar extends Model
{
    protected $table        = 'ayarlar';
    protected $primaryKey   = self::COLUMN_BASLIK;

    protected $fillable = [
        self::COLUMN_BASLIK,
        self::COLUMN_DEGER,
    ];

    const COLUMN_BASLIK = 'baslik';
    const COLUMN_DEGER  = 'deger';

    public $timestamps  = false;
    public $incrementing= false;

    const FIELD_ELEKTRIK_SON_ODEME_GUN          = 'elektrik.son_odeme_gun';
    const FIELD_ELEKTRIK_TUKETIM_BIRIM_FIYAT    = 'elektrik.tuketim_birim_fiyat';
    const FIELD_ELEKTRIK_DAGITIM_BIRIM_FIYAT    = 'elektrik.dagitim_birim_fiyat';
    const FIELD_ELEKTRIK_SISTEM_BIRIM_FIYAT     = 'elektrik.sistem_birim_fiyat';
    const FIELD_SU_SON_ODEME_GUN                = 'su.son_odeme_gun';
    const FIELD_SU_TUKETIM_BIRIM_FIYAT          = 'su.tuketim_birim_fiyat';
    const FIELD_DOGALGAZ_SON_ODEME_GUN          = 'dogalgaz.son_odeme_gun';
    const FIELD_DOGALGAZ_TUKETIM_BIRIM_FIYAT    = 'dogalgaz.tuketim_birim_fiyat';

    const LIST_FIELDS   = [
        self::FIELD_ELEKTRIK_SON_ODEME_GUN,
        self::FIELD_ELEKTRIK_TUKETIM_BIRIM_FIYAT,
        self::FIELD_ELEKTRIK_DAGITIM_BIRIM_FIYAT,
        self::FIELD_ELEKTRIK_SISTEM_BIRIM_FIYAT,
        self::FIELD_SU_SON_ODEME_GUN,
        self::FIELD_SU_TUKETIM_BIRIM_FIYAT,
        self::FIELD_DOGALGAZ_SON_ODEME_GUN,
        self::FIELD_DOGALGAZ_TUKETIM_BIRIM_FIYAT,
    ];
}
