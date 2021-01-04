<?php


namespace App\Services\Import\Fatura\Elektrik\Models;


use Illuminate\Contracts\Support\Arrayable;

class Row implements Arrayable
{
    const PRECISION = 9;

    /** @var string $aboneNo */
    protected $aboneNo;

    /** @var string $aboneAdi */
    protected $aboneAdi;

    /** @var float $toplamTuketim */
    protected $toplamTuketim;

    /** @var float $gunduzTuketim */
    protected $gunduzTuketim;

    /** @var float $puandTuketim */
    protected $puandTuketim;

    /** @var float $geceTuketim */
    protected $geceTuketim;

    /** @var float $reaktifTuketim */
    protected $reaktifTuketim;

    /** @var float $kapasitifTuketim */
    protected $kapasitifTuketim;

    /** @var float $reaktifBedel */
    protected $reaktifBedel;

    /** @var float $kapasitifBedel */
    protected $kapasitifBedel;

    /** @var float $sistemKullanimBedel */
    protected $sistemKullanimBedel;

    /** @var float $dagitimBedel */
    protected $dagitimBedel;

    /** @var float $trtPayi */
    protected $trtPayi;

    /** @var float $gecikmeZammi */
    protected $gecikmeZammi;

    /** @var float $kdvMatrahi */
    protected $kdvMatrahi;

    /** @var float $kdvBedeli */
    protected $kdvBedeli;

    /** @var float $faturaToplami */
    protected $faturaToplami;

    /**
     * Row constructor.
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->setAboneNo($array[0]);
        $this->setAboneAdi($array[1]);
        $this->setToplamTuketim($array[2]);
        $this->setGunduzTuketim($array[3]);
        $this->setPuandTuketim($array[4]);
        $this->setGeceTuketim($array[5]);
        $this->setReaktifTuketim($array[6]);
        $this->setKapasitifTuketim($array[7]);
        $this->setReaktifBedel($array[8]);
        $this->setKapasitifBedel($array[9]);
        $this->setSistemKullanimBedel($array[10]);
        $this->setDagitimBedel($array[11]);
        $this->setTrtPayi($array[12]);
        $this->setGecikmeZammi($array[13]);
        $this->setKdvMatrahi($array[14]);
        $this->setKdvBedeli($array[15]);
        $this->setFaturaToplami($array[16]);
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
     * GeceTuketim + gündüz + puandTuketim her zaman
     * $this->getToplamTuketim'e eşit olmuyor!
     *
     * "Dağıtım ve Sistem Kullanım Birim Ücretleri" getToplamTuketim kullanılarak
     * hesaplanırken
     * "Tüketim Birim Ücreti" getCalcToplamTuketimGunduzPuandGece kullanılarak
     * hesaplanıyor.
     *
     * @return float
     */
    public function getToplamTuketim(): float
    {
        return round($this->toplamTuketim, self::PRECISION);
    }

    /**
     * GeceTuketim + gündüz + puandTuketim her zaman
     * $this->getToplamTuketim'e eşit olmuyor!
     *
     * "Dağıtım ve Sistem Kullanım Birim Ücretleri" getToplamTuketim kullanılarak
     * hesaplanırken
     * "Tüketim Birim Ücreti" getCalcToplamTuketimGunduzPuandGece kullanılarak
     * hesaplanıyor.
     *
     * @return float
     */
    public function getCalcToplamTuketimGunduzPuandGece(): float
    {
        return $this->getGunduzTuketim() + $this->getPuandTuketim()
            + $this->getGeceTuketim();
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
    public function getGunduzTuketim(): float
    {
        return $this->gunduzTuketim;
    }

    /**
     * @param float $gunduzTuketim
     */
    public function setGunduzTuketim(float $gunduzTuketim): void
    {
        $this->gunduzTuketim = $gunduzTuketim;
    }

    /**
     * @return float
     */
    public function getPuandTuketim(): float
    {
        return $this->puandTuketim;
    }

    /**
     * @param float $puandTuketim
     */
    public function setPuandTuketim(float $puandTuketim): void
    {
        $this->puandTuketim = $puandTuketim;
    }

    /**
     * @return float
     */
    public function getGeceTuketim(): float
    {
        return $this->geceTuketim;
    }

    /**
     * @param float $geceTuketim
     */
    public function setGeceTuketim(float $geceTuketim): void
    {
        $this->geceTuketim = $geceTuketim;
    }

    /**
     * @return float
     */
    public function getReaktifTuketim(): float
    {
        return $this->reaktifTuketim;
    }

    /**
     * @param float $reaktifTuketim
     */
    public function setReaktifTuketim(float $reaktifTuketim): void
    {
        $this->reaktifTuketim = $reaktifTuketim;
    }

    /**
     * @return float
     */
    public function getKapasitifTuketim(): float
    {
        return $this->kapasitifTuketim;
    }

    /**
     * @param float $kapasitifTuketim
     */
    public function setKapasitifTuketim(float $kapasitifTuketim): void
    {
        $this->kapasitifTuketim = $kapasitifTuketim;
    }

    /**
     * @return float
     */
    public function getReaktifBedel(): float
    {
        return $this->reaktifBedel;
    }

    /**
     * @param float $reaktifBedel
     */
    public function setReaktifBedel(float $reaktifBedel): void
    {
        $this->reaktifBedel = $reaktifBedel;
    }

    /**
     * @return float
     */
    public function getKapasitifBedel(): float
    {
        return $this->kapasitifBedel;
    }

    /**
     * @param float $kapasitifBedel
     */
    public function setKapasitifBedel(float $kapasitifBedel): void
    {
        $this->kapasitifBedel = $kapasitifBedel;
    }

    /**
     * @return float
     */
    public function getSistemKullanimBedel(): float
    {
        return $this->sistemKullanimBedel;
    }

    /**
     * @param float $sistemKullanimBedel
     */
    public function setSistemKullanimBedel(float $sistemKullanimBedel): void
    {
        $this->sistemKullanimBedel = $sistemKullanimBedel;
    }

    /**
     * @return float
     */
    public function getDagitimBedel(): float
    {
        return $this->dagitimBedel;
    }

    /**
     * @param float $dagitimBedel
     */
    public function setDagitimBedel(float $dagitimBedel): void
    {
        $this->dagitimBedel = $dagitimBedel;
    }

    /**
     * @return float
     */
    public function getCalcBirimDagitimUcreti(): float
    {
        $toplamTuketim = $this->getToplamTuketim();

        if ($toplamTuketim === 0.0) {
            return 0;
        }

        return round($this->getDagitimBedel() / $toplamTuketim, self::PRECISION);
    }

    /**
     * @return float
     */
    public function getTrtPayi(): float
    {
        return $this->trtPayi;
    }

    /**
     * @param float $trtPayi
     */
    public function setTrtPayi(float $trtPayi): void
    {
        $this->trtPayi = $trtPayi;
    }

    /**
     * @return float
     */
    public function getGecikmeZammi(): float
    {
        return $this->gecikmeZammi;
    }

    /**
     * @param float $gecikmeZammi
     */
    public function setGecikmeZammi(float $gecikmeZammi): void
    {
        $this->gecikmeZammi = $gecikmeZammi;
    }

    /**
     * @return float
     */
    public function getKdvMatrahi(): float
    {
        return $this->kdvMatrahi;
    }

    /**
     * @param float $kdvMatrahi
     */
    public function setKdvMatrahi(float $kdvMatrahi): void
    {
        $this->kdvMatrahi = $kdvMatrahi;
    }

    /**
     * @return float
     */
    public function getKdvBedeli(): float
    {
        return $this->kdvBedeli;
    }

    /**
     * @param float $kdvBedeli
     */
    public function setKdvBedeli(float $kdvBedeli): void
    {
        $this->kdvBedeli = $kdvBedeli;
    }

    /**
     * @return float
     */
    public function getFaturaToplami(): float
    {
        return $this->faturaToplami;
    }

    /**
     * @param float $faturaToplami
     */
    public function setFaturaToplami(float $faturaToplami): void
    {
        $this->faturaToplami = $faturaToplami;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            $this->getAboneNo(),
            $this->getAboneAdi(),
            $this->getToplamTuketim(),
            $this->getGunduzTuketim(),
            $this->getPuandTuketim(),
            $this->getGeceTuketim(),
            $this->getReaktifTuketim(),
            $this->getKapasitifTuketim(),
            $this->getReaktifBedel(),
            $this->getKapasitifBedel(),
            $this->getSistemKullanimBedel(),
            $this->getDagitimBedel(),
            $this->getTrtPayi(),
            $this->getGecikmeZammi(),
            $this->getKdvMatrahi(),
            $this->getKdvBedeli(),
            $this->getFaturaToplami(),
        ];
    }
}
