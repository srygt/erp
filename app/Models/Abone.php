<?php

namespace App\Models;

use App\Helpers\Utils;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Abone
 * @package App\Models
 *
 * @property Mukellef $mukellef
 */
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
        Abone::COLUMN_TRT_PAYI,
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
    const COLUMN_TRT_PAYI       = 'trt_payi';

    const TUR_LIST              = [
        self::COLUMN_TUR_ELEKTRIK   => 'Elektrik',
        self::COLUMN_TUR_SU         => 'Su',
        self::COLUMN_TUR_DOGALGAZ   => 'Doğalgaz',
    ];

    /**
     * @return BelongsTo
     */
    public function mukellef()
    {
        return $this->belongsTo(Mukellef::class,'mukellef_id','id');
    }

    /**
     * @return HasMany
     */
    public function faturalar()
    {
        return $this->hasMany(Fatura::class);
    }

    /**
     * @return HasMany
     */
    public function faturaTaslaklari()
    {
        return $this->hasMany(FaturaTaslagi::class);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getFormattedTelephone() : string
    {
        return Utils::getFormattedTelephoneNumber($this->{Mukellef::COLUMN_TELEFON});
    }

    /**
     * @param $value
     */
    public function setAboneNoAttribute($value)
    {
        if (!$value) {
            return;
        }

        $this->attributes[self::COLUMN_ABONE_NO]    = str_pad(
                                                        $value,
                                                        config('fatura.aboneNoPadLength'),
                                                        config('fatura.aboneNoPadString'),
                                                        config('fatura.aboneNoPadDirection')
                                                    );
    }

    /**
     * @param $value
     * @return bool|null
     */
    public function getTrtPayiAttribute($value) : ?bool
    {
        if (is_null($value)) {
            return null;
        }

        return $value > 0;
    }
}
