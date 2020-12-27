<?php

namespace App\Models;

use App\Contracts\FaturaInterface;
use App\Exceptions\UnsupportedAppTypeException;
use App\Helpers\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Onrslu\HtEfatura\Types\Enums\AppType\BaseAppType;

class Fatura extends Model implements FaturaInterface
{
    use SoftDeletes;

    protected $table = 'faturalar';

    protected $fillable = [
        self::COLUMN_UUID,
        self::COLUMN_DURUM,
        self::COLUMN_TUR,
        self::COLUMN_INVOICE_ID,
        self::COLUMN_FATURA_TARIH,
        self::COLUMN_SON_ODEME_TARIHI,
        self::COLUMN_ENDEKS_ILK,
        self::COLUMN_ENDEKS_SON,
        self::COLUMN_BIRIM_FIYAT_TUKETIM,
        self::COLUMN_ENDUKTIF_TUKETIM,
        self::COLUMN_ENDUKTIF_BIRIM_FIYAT,
        self::COLUMN_KAPASITIF_TUKETIM,
        self::COLUMN_KAPASITIF_BIRIM_FIYAT,
        self::COLUMN_NOT,
        self::COLUMN_TOPLAM_ODENECEK_UCRET,
        self::COLUMN_ABONE_ID,
        self::COLUMN_DATA_SOURCE,
    ];

    protected $casts = [
        self::COLUMN_FATURA_TARIH       => 'datetime',
        self::COLUMN_SON_ODEME_TARIHI   => 'date',
    ];

    const COLUMN_ID                     = 'id';
    const COLUMN_UUID                   = 'uuid';
    const COLUMN_APP_TYPE               = 'app_type';
    const COLUMN_DURUM                  = 'durum';
    const COLUMN_DURUM_BEKLEMEDE        = 'beklemede';
    const COLUMN_DURUM_HATA             = 'hata';
    const COLUMN_DURUM_BASARILI         = 'basarili';
    const COLUMN_INVOICE_ID             = 'fatura_no';
    const COLUMN_TUR                    = 'tur';
    const COLUMN_FATURA_TARIH           = 'fatura_tarih';
    const COLUMN_SON_ODEME_TARIHI       = 'son_odeme_tarihi';
    const COLUMN_ENDEKS_ILK             = 'ilk_endeks';
    const COLUMN_ENDEKS_SON             = 'son_endeks';
    const COLUMN_BIRIM_FIYAT_TUKETIM    = 'birim_fiyat';
    const COLUMN_ENDUKTIF_TUKETIM       = 'enduktif_tuketim';
    const COLUMN_ENDUKTIF_BIRIM_FIYAT   = 'enduktif_birim_fiyat';
    const COLUMN_KAPASITIF_TUKETIM      = 'kapasitif_tuketim';
    const COLUMN_KAPASITIF_BIRIM_FIYAT  = 'kapasitif_birim_fiyat';
    const COLUMN_NOT                    = 'not';
    const COLUMN_TOPLAM_ODENECEK_UCRET  = 'toplam_odenecek_ucret';
    const COLUMN_ABONE_ID               = 'abone_id';
    const COLUMN_DATA_SOURCE            = 'data_source';
    const COLUMN_DATA_SOURCE_MANUAL     = 'manual';
    const COLUMN_DATA_SOURCE_IMPORTED   = 'imported';

    const LIST_DURUM = [
        self::COLUMN_DURUM_BEKLEMEDE,
        self::COLUMN_DURUM_HATA,
        self::COLUMN_DURUM_BASARILI,
    ];

    const LIST_DATA_SOURCES = [
        self::COLUMN_DATA_SOURCE_MANUAL,
        self::COLUMN_DATA_SOURCE_IMPORTED,
    ];

    const COLUMN_FATURA_TASLAGI_ID  = 'fatura_taslagi_id';

    public function faturaTaslagi()
    {
        $this->belongsTo(FaturaTaslagi::class);
    }

    public function abone()
    {
        return $this->belongsTo(Abone::class,self::COLUMN_ABONE_ID,'id');
    }
}
