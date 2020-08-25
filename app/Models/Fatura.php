<?php

namespace App\Models;

use App\Contracts\FaturaInterface;
use App\Helpers\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fatura extends Model implements FaturaInterface
{
    use SoftDeletes;

    protected $table = 'faturalar';

    protected $fillable = [
        self::COLUMN_UUID,
        self::COLUMN_DURUM,
        self::COLUMN_TUR,
        self::COLUMN_INVOICE_ID,
        self::COLUMN_BIRIM_FIYAT_TUKETIM,
        self::COLUMN_SON_ODEME_TARIHI,
        self::COLUMN_ENDEKS_ILK,
        self::COLUMN_ENDEKS_SON,
        self::COLUMN_NOT,
        self::COLUMN_TOPLAM_ODENECEK_UCRET,
        self::COLUMN_ABONE_ID,
    ];

    protected $casts = [
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
    const COLUMN_BIRIM_FIYAT_TUKETIM    = 'birim_fiyat';
    const COLUMN_SON_ODEME_TARIHI       = 'son_odeme_tarihi';
    const COLUMN_ENDEKS_ILK             = 'ilk_endeks';
    const COLUMN_ENDEKS_SON             = 'son_endeks';
    const COLUMN_NOT                    = 'not';
    const COLUMN_TOPLAM_ODENECEK_UCRET  = 'toplam_odenecek_ucret';
    const COLUMN_ABONE_ID               = 'abone_id';

    const LIST_DURUM = [
        self::COLUMN_DURUM_BEKLEMEDE,
        self::COLUMN_DURUM_HATA,
        self::COLUMN_DURUM_BASARILI,
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

    public static function getNextInvoiceId() : string
    {
        $lastFatura = self::orderBy('id', 'desc')
            ->where(self::COLUMN_DURUM, self::COLUMN_DURUM_BASARILI)
            ->where(
                self::COLUMN_INVOICE_ID,
                'LIKE',
                config('fatura.faturaNoPrefix') . date('Y') . '%'
            )
            ->first();

        $nextInvoiceId  = Utils::getInvoiceId($lastFatura->{self::COLUMN_INVOICE_ID} ?? null);

        return $nextInvoiceId;
    }
}
