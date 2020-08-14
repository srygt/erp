<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mukellef extends Model
{
    protected $table = 'mukellefler';
    public $timestamps = false;

    const COLUMN_VERGI_NO = 'vergi_no';
    const COLUMN_TC_KIMLIK_NO = 'tc_kimlik_no';
    const COLUMN_UNVAN = 'unvan';
    const COLUMN_AD_SOYAD = 'ad_soyad';
    const COLUMN_VERGI_DAIRESI_SEHIR = 'vergi_dairesi_sehir';
    const COLUMN_VERGI_DAIRESI_ISMI = 'vergi_dairesi_ismi';
    const COLUMN_EMAIL = 'email';
    const COLUMN_WEBSITE = 'website';
    const COLUMN_ULKE = 'ulke';
    const COLUMN_IL = 'il';
    const COLUMN_ILCE = 'ilce';
    const COLUMN_ADRES = 'adres';
    const COLUMN_TELEFON = 'telefon';
    const COLUMN_URN = 'urn';

    public function abonelikler(){
        $this->hasMany(Abone::class);
    }

}
