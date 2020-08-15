<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abone extends Model
{
    use SoftDeletes;

    protected $table = 'abonelikler';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $fillable = [
        Abone::COLUMN_MUKELLEF_ID,
        Abone::COLUMN_TUR,
        Abone::COLUMN_BASLIK,
        Abone::COLUMN_ABONE_NO,
        Abone::COLUMN_SAYAC_NO,
        Mukellef::COLUMN_EMAIL,
        Mukellef::COLUMN_WEBSITE,
        Mukellef::COLUMN_ULKE,
        Mukellef::COLUMN_IL,
        Mukellef::COLUMN_ILCE,
        Mukellef::COLUMN_ADRES,
        Mukellef::COLUMN_TELEFON,
        Mukellef::COLUMN_URN,
    ];

    const COLUMN_MUKELLEF_ID    = 'mukellef_id';
    const COLUMN_TUR            = 'tur';
    const COLUMN_TUR_SU         = 'su';
    const COLUMN_TUR_ELEKTRIK   = 'elektrik';
    const COLUMN_TUR_DOGALGAZ   = 'dogalgaz';
    const COLUMN_BASLIK         = 'baslik';
    const COLUMN_ABONE_NO       = 'abone_no';
    const COLUMN_SAYAC_NO       = 'sayac_no';

    const TUR_LIST              = [
        self::COLUMN_TUR_ELEKTRIK   => 'Elektrik',
        self::COLUMN_TUR_SU         => 'Su',
        self::COLUMN_TUR_DOGALGAZ   => 'Doğalgaz',
    ];

    public function mukellef(){
        return $this->belongsTo(Mukellef::class,'mukellef_id','id');
    }
}
