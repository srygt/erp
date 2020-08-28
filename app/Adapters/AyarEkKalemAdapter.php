<?php


namespace App\Adapters;


use App\Models\AyarEkKalem;
use Onrslu\HtEfatura\Types\Enums\QuantityUnitUser;
use Throwable;

class AyarEkKalemAdapter
{
    /** @var AyarEkKalem $ayarEkKalem */
    protected $ayarEkKalem;

    /** @var null|float $birimUcret */
    protected $birimUcret;

    /** @var float $tuketimMiktari */
    protected $tuketimMiktari;

    /** @var QuantityUnitUser $miktarTuru */
    protected $miktarTuru;

    /**
     * AyarEkKalemAdapter constructor.
     *
     * @param AyarEkKalem $ayarEkKalem
     * @param float $tuketimMiktari
     * @param null|float $birimUcret
     * @param QuantityUnitUser|null $miktarTuru
     */
    public function __construct(AyarEkKalem $ayarEkKalem, float $tuketimMiktari, ?float $birimUcret, ?QuantityUnitUser $miktarTuru = null)
    {
        $this->ayarEkKalem      = $ayarEkKalem;
        $this->tuketimMiktari   = $tuketimMiktari;
        $this->birimUcret       = $birimUcret;

        if ($this->ayarEkKalem->{AyarEkKalem::COLUMN_UCRET_TUR} === AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR) {
            $this->miktarTuru   = new QuantityUnitUser('C62');
        }
        else {
            $this->miktarTuru   = $miktarTuru;
        }
    }

    /**
     * @return string
     */
    public function getBaslik() : string
    {
        return $this->ayarEkKalem->{AyarEkKalem::COLUMN_BASLIK};
    }

    /**
     * @return float
     * @throws Throwable
     */
    public function getUcret() : float
    {
        if ($this->ayarEkKalem->{AyarEkKalem::COLUMN_UCRET_TUR} === AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR)
        {
            return $this->birimUcret;
        }

        return $this->ayarEkKalem->{AyarEkKalem::COLUMN_DEGER};
    }

    /**
     * @return float
     */
    public function getMiktar() : float
    {
        if ($this->ayarEkKalem->{AyarEkKalem::COLUMN_UCRET_TUR} === AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR)
        {
            return 1;
        }

        return $this->tuketimMiktari;
    }

    public function getMiktarTuru() : QuantityUnitUser
    {
        return $this->miktarTuru;
    }
}
