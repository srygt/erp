<?php

namespace App\Services\Import\Fatura\Dogalgaz\Models;

use App\Contracts\ExcelImportRow;
use Illuminate\Contracts\Support\Arrayable;

class Row implements ExcelImportRow, Arrayable
{
    const PRECISION = 9;

    /** @var string $aboneNo */
    protected $aboneNo;

    /** @var string $aboneAdi */
    protected $aboneAdi;

    /** @var float $basinc */
    protected $basinc;

    /** @var float $ilkEndeks */
    protected $ilkEndeks;

    /** @var float $sonEndeks */
    protected $sonEndeks;

    /** @var float $endeksFark */
    protected $endeksFark;

    /** @var float $geriTuketim */
    protected $geriTuketim;

    /** @var float $duzTuketim */
    protected $duzTuketim;

    /** @var float $toplamTuketim */
    protected $toplamTuketim;

    /** @var float $kwDonusumKatsayi */
    protected $kwDonusumKatsayi;

    /** @var float $duzeltilmisTuketim */
    protected $duzeltilmisTuketim;

    /** @var float $toplamDuzeltilmisTuketim */
    protected $toplamDuzeltilmisTuketim;

    /** @var float $birimFiyat */
    protected $birimFiyat;

    /** @var float $kdvHaricBedel */
    protected $kdvHaricBedel;

    /** @var float $otvBirimFiyat */
    protected $otvBirimFiyat;

    /** @var float $kdvHaricOtv */
    protected $kdvHaricOtv;

    /** @var float $toplamKdv */
    protected $toplamKdv;

    /** @var float $kdvDahilFatura */
    protected $kdvDahilFatura;

    /** @var float $toplamFaturaBedel */
    protected $toplamFaturaBedel;

    /** @var float $gecikmeBedel */
    protected $gecikmeBedel;

    /**
     * Row constructor.
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->setAboneNo($array[0]);
        $this->setAboneAdi($array[1]);
        $this->setBasinc($array[2]);
        $this->setIlkEndeks($array[3]);
        $this->setSonEndeks($array[4]);
        $this->setEndeksFark($array[5]);
        $this->setGeriTuketim($array[6]);
        $this->setDuzTuketim($array[7]);
        $this->setToplamTuketim($array[8]);
        $this->setKwDonusumKatsayi($array[9]);
        $this->setDuzeltilmisTuketim($array[10]);
        $this->setToplamDuzeltilmisTuketim($array[11]);
        $this->setBirimFiyat($array[12]);
        $this->setKdvHaricBedel($array[13]);
        $this->setOtvBirimFiyat($array[14]);
        $this->setKdvHaricOtv($array[15]);
        $this->setToplamKdv($array[16]);
        $this->setKdvDahilFatura($array[17]);
        $this->setToplamFaturaBedel($array[18]);
        $this->setGecikmeBedel($array[19]);
    }

    /**
     * @return string
     */
    public function getAboneNo(): string
    {
        return $this->aboneNo;
    }

    /**
     * @param string $aboneNo
     */
    public function setAboneNo(string $aboneNo): void
    {
        $this->aboneNo = $aboneNo;
    }

    /**
     * @return string
     */
    public function getAboneAdi(): string
    {
        return $this->aboneAdi;
    }

    /**
     * @param string $aboneAdi
     */
    public function setAboneAdi(string $aboneAdi): void
    {
        $this->aboneAdi = $aboneAdi;
    }

    /**
     * @return float
     */
    public function getBasinc(): float
    {
        return $this->basinc;
    }

    /**
     * @param float $basinc
     */
    public function setBasinc(float $basinc): void
    {
        $this->basinc = $basinc;
    }

    /**
     * @return float
     */
    public function getIlkEndeks(): float
    {
        return $this->ilkEndeks;
    }

    /**
     * @param float $ilkEndeks
     */
    public function setIlkEndeks(float $ilkEndeks): void
    {
        $this->ilkEndeks = $ilkEndeks;
    }

    /**
     * @return float
     */
    public function getSonEndeks(): float
    {
        return $this->sonEndeks;
    }

    /**
     * @param float $sonEndeks
     */
    public function setSonEndeks(float $sonEndeks): void
    {
        $this->sonEndeks = $sonEndeks;
    }

    /**
     * @return float
     */
    public function getEndeksFark(): float
    {
        return $this->endeksFark;
    }

    /**
     * @param float $endeksFark
     */
    public function setEndeksFark(float $endeksFark): void
    {
        $this->endeksFark = $endeksFark;
    }

    /**
     * @return float
     */
    public function getGeriTuketim(): float
    {
        return $this->geriTuketim;
    }

    /**
     * @param float $geriTuketim
     */
    public function setGeriTuketim(float $geriTuketim): void
    {
        $this->geriTuketim = $geriTuketim;
    }

    /**
     * @return float
     */
    public function getDuzTuketim(): float
    {
        return $this->duzTuketim;
    }

    /**
     * @param float $duzTuketim
     */
    public function setDuzTuketim(float $duzTuketim): void
    {
        $this->duzTuketim = $duzTuketim;
    }

    /**
     * @return float
     */
    public function getToplamTuketim(): float
    {
        return $this->toplamTuketim;
    }

    /**
     * @param float $toplamTuketim
     */
    public function setToplamTuketim(float $toplamTuketim): void
    {
        $this->toplamTuketim = $toplamTuketim;
    }

    /**
     * @return float
     */
    public function getKwDonusumKatsayi(): float
    {
        return $this->kwDonusumKatsayi;
    }

    /**
     * @param float $kwDonusumKatsayi
     */
    public function setKwDonusumKatsayi(float $kwDonusumKatsayi): void
    {
        $this->kwDonusumKatsayi = $kwDonusumKatsayi;
    }

    /**
     * @return float
     */
    public function getDuzeltilmisTuketim(): float
    {
        return $this->duzeltilmisTuketim;
    }

    /**
     * @param float $duzeltilmisTuketim
     */
    public function setDuzeltilmisTuketim(float $duzeltilmisTuketim): void
    {
        $this->duzeltilmisTuketim = $duzeltilmisTuketim;
    }

    /**
     * @return float
     */
    public function getToplamDuzeltilmisTuketim(): float
    {
        return $this->toplamDuzeltilmisTuketim;
    }

    /**
     * @param float $toplamDuzeltilmisTuketim
     */
    public function setToplamDuzeltilmisTuketim(float $toplamDuzeltilmisTuketim): void
    {
        $this->toplamDuzeltilmisTuketim = $toplamDuzeltilmisTuketim;
    }

    /**
     * @return float
     */
    public function getBirimFiyat(): float
    {
        return $this->birimFiyat;
    }

    /**
     * @param float $birimFiyat
     */
    public function setBirimFiyat(float $birimFiyat): void
    {
        $this->birimFiyat = $birimFiyat;
    }

    /**
     * @return float
     */
    public function getKdvHaricBedel(): float
    {
        return $this->kdvHaricBedel;
    }

    /**
     * @param float $kdvHaricBedel
     */
    public function setKdvHaricBedel(float $kdvHaricBedel): void
    {
        $this->kdvHaricBedel = $kdvHaricBedel;
    }

    /**
     * @return float
     */
    public function getOtvBirimFiyat(): float
    {
        return $this->otvBirimFiyat;
    }

    /**
     * @param float $otvBirimFiyat
     */
    public function setOtvBirimFiyat(float $otvBirimFiyat): void
    {
        $this->otvBirimFiyat = $otvBirimFiyat;
    }

    /**
     * @return float
     */
    public function getKdvHaricOtv(): float
    {
        return $this->kdvHaricOtv;
    }

    /**
     * @param float $kdvHaricOtv
     */
    public function setKdvHaricOtv(float $kdvHaricOtv): void
    {
        $this->kdvHaricOtv = $kdvHaricOtv;
    }

    /**
     * @return float
     */
    public function getToplamKdv(): float
    {
        return $this->toplamKdv;
    }

    /**
     * @param float $toplamKdv
     */
    public function setToplamKdv(float $toplamKdv): void
    {
        $this->toplamKdv = $toplamKdv;
    }

    /**
     * @return float
     */
    public function getKdvDahilFatura(): float
    {
        return $this->kdvDahilFatura;
    }

    /**
     * @param float $kdvDahilFatura
     */
    public function setKdvDahilFatura(float $kdvDahilFatura): void
    {
        $this->kdvDahilFatura = $kdvDahilFatura;
    }

    /**
     * @return float
     */
    public function getToplamFaturaBedel(): float
    {
        return $this->toplamFaturaBedel;
    }

    /**
     * @param float $toplamFaturaBedel
     */
    public function setToplamFaturaBedel(float $toplamFaturaBedel): void
    {
        $this->toplamFaturaBedel = $toplamFaturaBedel;
    }

    /**
     * @return float
     */
    public function getGecikmeBedel(): float
    {
        return $this->gecikmeBedel;
    }

    /**
     * @param float $gecikmeBedel
     */
    public function setGecikmeBedel(float $gecikmeBedel): void
    {
        $this->gecikmeBedel = $gecikmeBedel;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            $this->getAboneNo(),
            $this->getAboneAdi(),
            $this->getBasinc(),
            $this->getIlkEndeks(),
            $this->getSonEndeks(),
            $this->getEndeksFark(),
            $this->getGeriTuketim(),
            $this->getDuzTuketim(),
            $this->getToplamTuketim(),
            $this->getKwDonusumKatsayi(),
            $this->getDuzeltilmisTuketim(),
            $this->getToplamDuzeltilmisTuketim(),
            $this->getBirimFiyat(),
            $this->getKdvHaricBedel(),
            $this->getOtvBirimFiyat(),
            $this->getKdvHaricOtv(),
            $this->getToplamKdv(),
            $this->getKdvDahilFatura(),
            $this->getToplamFaturaBedel(),
            $this->getGecikmeBedel(),
        ];
    }
}
