<?php

namespace App\Models;

use App\Helpers\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mukellef extends Model
{
    use SoftDeletes;

    protected $table = 'mukellefler';
    protected $fillable = [
        self::COLUMN_AKTIF_MI,
        self::COLUMN_VERGI_NO,
        self::COLUMN_TC_KIMLIK_NO,
        self::COLUMN_UNVAN,
        self::COLUMN_AD,
        self::COLUMN_SOYAD,
        self::COLUMN_VERGI_DAIRESI_SEHIR,
        self::COLUMN_VERGI_DAIRESI,
        self::COLUMN_EMAIL,
        self::COLUMN_WEBSITE,
        self::COLUMN_ULKE,
        self::COLUMN_IL,
        self::COLUMN_ILCE,
        self::COLUMN_ADRES,
        self::COLUMN_TELEFON,
        self::COLUMN_URN,
        self::COLUMN_IBAN,
    ];

    const COLUMN_ID                     = 'id';
    const COLUMN_AKTIF_MI               = 'aktif_mi';
    const COLUMN_VERGI_NO               = 'vergi_no';
    const COLUMN_TC_KIMLIK_NO           = 'tc_kimlik_no';
    const COLUMN_UNVAN                  = 'unvan';
    const COLUMN_AD                     = 'ad';
    const COLUMN_SOYAD                  = 'soyad';
    const COLUMN_VERGI_DAIRESI_SEHIR    = 'vergi_dairesi_sehir';
    const COLUMN_VERGI_DAIRESI          = 'vergi_dairesi';
    const COLUMN_EMAIL                  = 'email';
    const COLUMN_WEBSITE                = 'website';
    const COLUMN_ULKE                   = 'ulke';
    const COLUMN_IL                     = 'il';
    const COLUMN_ILCE                   = 'ilce';
    const COLUMN_ADRES                  = 'adres';
    const COLUMN_TELEFON                = 'telefon';
    const COLUMN_URN                    = 'urn';
    const COLUMN_IBAN                   = 'iban';

    public function abonelikler()
    {
        return $this->hasMany(Abone::class);
    }

    public function getIdentificationId() : string
    {
        return $this->{Mukellef::COLUMN_TC_KIMLIK_NO} ?? $this->{Mukellef::COLUMN_VERGI_NO};
    }

    public function getFormattedTelephone() : string
    {
        return Utils::getFormattedTelephoneNumber($this->{self::COLUMN_TELEFON});
    }
}
