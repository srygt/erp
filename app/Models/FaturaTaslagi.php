<?php

namespace App\Models;

use App\Contracts\FaturaInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FaturaTaslagi
 * @package App\Models
 *
 * @property Abone $abone
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class FaturaTaslagi extends Model implements FaturaInterface
{
    use SoftDeletes;

    protected $table = 'fatura_taslaklari';

    protected $fillable = [
        Fatura::COLUMN_UUID,
        Fatura::COLUMN_INVOICE_ID,
        Fatura::COLUMN_TUR,
        Fatura::COLUMN_FATURA_TARIH,
        Fatura::COLUMN_SON_ODEME_TARIHI,
        Fatura::COLUMN_ENDEKS_ILK,
        Fatura::COLUMN_ENDEKS_SON,
        Fatura::COLUMN_BIRIM_FIYAT_TUKETIM,
        Fatura::COLUMN_GUNDUZ_TUKETIM,
        Fatura::COLUMN_PUAND_TUKETIM,
        Fatura::COLUMN_GECE_TUKETIM,
        Fatura::COLUMN_ENDUKTIF_TUKETIM,
        Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT,
        Fatura::COLUMN_KAPASITIF_TUKETIM,
        Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT,
        Fatura::COLUMN_TOPLAM_ODENECEK_UCRET,
        Fatura::COLUMN_NOT,
        Fatura::COLUMN_DATA_SOURCE,
    ];

    protected $casts = [
        Fatura::COLUMN_FATURA_TARIH         => 'datetime',
        Fatura::COLUMN_SON_ODEME_TARIHI     => 'date',
    ];

    public function fatura()
    {
        return $this->hasOne(Fatura::class);
    }

    public function abone()
    {
        return $this->belongsTo(Abone::class,Fatura::COLUMN_ABONE_ID,'id');
    }

    public function faturalastir()
    {
        return $this->fatura()
            ->create([
                Fatura::COLUMN_UUID                 => $this->{Fatura::COLUMN_UUID},
                Fatura::COLUMN_INVOICE_ID           => $this->{Fatura::COLUMN_INVOICE_ID},
                Fatura::COLUMN_FATURA_TARIH         => $this->{Fatura::COLUMN_FATURA_TARIH},
                Fatura::COLUMN_SON_ODEME_TARIHI     => $this->{Fatura::COLUMN_SON_ODEME_TARIHI},
                Fatura::COLUMN_ENDEKS_ILK           => $this->{Fatura::COLUMN_ENDEKS_ILK},
                Fatura::COLUMN_ENDEKS_SON           => $this->{Fatura::COLUMN_ENDEKS_SON},
                Fatura::COLUMN_BIRIM_FIYAT_TUKETIM  => $this->{Fatura::COLUMN_BIRIM_FIYAT_TUKETIM},
                Fatura::COLUMN_ENDUKTIF_TUKETIM     => $this->{Fatura::COLUMN_ENDUKTIF_TUKETIM},
                Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT => $this->{Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT},
                Fatura::COLUMN_KAPASITIF_TUKETIM    => $this->{Fatura::COLUMN_KAPASITIF_TUKETIM},
                Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT=> $this->{Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT},
                Fatura::COLUMN_NOT                  => $this->{Fatura::COLUMN_NOT},
                Fatura::COLUMN_ABONE_ID             => $this->{Fatura::COLUMN_ABONE_ID},
            ]);
    }
}
