<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    const FIELD_ELEKTRIK_BANKA_HESAP_ADI        = 'elektrik.banka_hesap_adi';
    const FIELD_ELEKTRIK_BANKA_IBAN             = 'elektrik.banka_iban';
    const FIELD_ELEKTRIK_FATURA_TARIH           = 'elektrik.fatura_tarih';
    const FIELD_ELEKTRIK_SON_ODEME_GUN          = 'elektrik.son_odeme_gun';
    const FIELD_ELEKTRIK_TUKETIM_BIRIM_FIYAT    = 'elektrik.tuketim_birim_fiyat';
    const FIELD_ELEKTRIK_FATURA_ACIKLAMA        = 'elektrik.fatura_aciklama';
    const FIELD_SU_BANKA_HESAP_ADI              = 'su.banka_hesap_adi';
    const FIELD_SU_BANKA_IBAN                   = 'su.banka_iban';
    const FIELD_SU_FATURA_TARIH                 = 'su.fatura_tarih';
    const FIELD_SU_SON_ODEME_GUN                = 'su.son_odeme_gun';
    const FIELD_SU_TUKETIM_BIRIM_FIYAT          = 'su.tuketim_birim_fiyat';
    const FIELD_SU_FATURA_ACIKLAMA              = 'su.fatura_aciklama';
    const FIELD_DOGALGAZ_BANKA_HESAP_ADI        = 'dogalgaz.banka_hesap_adi';
    const FIELD_DOGALGAZ_BANKA_IBAN             = 'dogalgaz.banka_iban';
    const FIELD_DOGALGAZ_FATURA_TARIH           = 'dogalgaz.fatura_tarih';
    const FIELD_DOGALGAZ_SON_ODEME_GUN          = 'dogalgaz.son_odeme_gun';
    const FIELD_DOGALGAZ_TUKETIM_BIRIM_FIYAT    = 'dogalgaz.tuketim_birim_fiyat';
    const FIELD_DOGALGAZ_FATURA_ACIKLAMA        = 'dogalgaz.fatura_aciklama';

    const LIST_FIELDS   = [
        self::FIELD_ELEKTRIK_BANKA_HESAP_ADI,
        self::FIELD_ELEKTRIK_BANKA_IBAN,
        self::FIELD_ELEKTRIK_FATURA_TARIH,
        self::FIELD_ELEKTRIK_SON_ODEME_GUN,
        self::FIELD_ELEKTRIK_TUKETIM_BIRIM_FIYAT,
        self::FIELD_ELEKTRIK_FATURA_ACIKLAMA,
        self::FIELD_SU_BANKA_HESAP_ADI,
        self::FIELD_SU_BANKA_IBAN,
        self::FIELD_SU_FATURA_TARIH,
        self::FIELD_SU_SON_ODEME_GUN,
        self::FIELD_SU_TUKETIM_BIRIM_FIYAT,
        self::FIELD_SU_FATURA_ACIKLAMA,
        self::FIELD_DOGALGAZ_BANKA_HESAP_ADI,
        self::FIELD_DOGALGAZ_BANKA_IBAN,
        self::FIELD_DOGALGAZ_FATURA_TARIH,
        self::FIELD_DOGALGAZ_SON_ODEME_GUN,
        self::FIELD_DOGALGAZ_TUKETIM_BIRIM_FIYAT,
        self::FIELD_DOGALGAZ_FATURA_ACIKLAMA,
    ];

    public static function allFormatted()
    {
        /** @var Collection $ayarlar */
        $ayarlar = self::get();

        $data = [];

        foreach ($ayarlar as $ayar)
        {
            $data[$ayar->{self::COLUMN_BASLIK}]     = $ayar->{self::COLUMN_DEGER};
        }

        return $data;
    }
}
