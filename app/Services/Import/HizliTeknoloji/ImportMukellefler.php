<?php


namespace App\Services\Import\HizliTeknoloji;

use App\Models\Mukellef;
use Illuminate\Support\Str;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Statement;


class ImportMukellefler
{
    /** @var string $delimiter */
    protected $delimiter = ';';

    /** @var int $headerOffset */
    protected $headerOffset = 0;

    /**
     * @param string $filePath
     * @param int $offset
     * @param int $limit
     * @throws Exception
     */
    public function import(string $filePath, $offset = 0, $limit = -1)
    {
        //load the CSV document from a stream
        $stream = fopen($filePath, 'r');
        $csv = Reader::createFromStream($stream);

        $csv->setDelimiter($this->getDelimiter());

        if ($this->getHeaderOffset() > 0) {
            $csv->setHeaderOffset($this->getHeaderOffset());
        }

        //build a statement
        $stmt = (new Statement());

        if ($offset > 0) {
            $stmt = $stmt->offset($offset);
        }

        if($limit > 0) {
            $stmt = $stmt->limit($limit);
        }

        //query your records from the document
        $records = $stmt->process($csv);

        foreach ($records as $record)
        {
            list(
                $vkntckn,
                $unvan,
                $ilkAd,
                $ortaAd,
                $soyad,
                $ticaretOdasi,
                $vergiDairesiSehir,
                $vergiDairesi,
                $mersisNo,
                $ticaretSicilNo,
                $musteriTipi,
                $baslangicBakiyesi,
                $musteriRiskLimiti,
                $adresAdi,
                $yetkiliKisi,
                $ulke,
                $il,
                $ilce,
                $website,
                $email,
                $telefon,
                $faks,
                $mahalleCadde,
                ) = $record;

            $payload = [];

            if (mb_strlen($vkntckn) === 11) {
                $payload[Mukellef::COLUMN_TC_KIMLIK_NO]         = $vkntckn;
            }
            else {
                $payload[Mukellef::COLUMN_VERGI_NO]             = $vkntckn;
            }

            $payload[Mukellef::COLUMN_UNVAN]                    = Str::upper($unvan);
            $payload[Mukellef::COLUMN_AD]                       = Str::upper($ilkAd);

            if (Str::upper($ortaAd)) {
                $payload[Mukellef::COLUMN_AD]                   .= ' ' . Str::upper($ortaAd);
            }

            $payload[Mukellef::COLUMN_SOYAD]                    = Str::upper($soyad);

            if ($vergiDairesiSehir) {
                $payload[Mukellef::COLUMN_VERGI_DAIRESI_SEHIR]  = Str::upper($vergiDairesiSehir);
            }

            $payload[Mukellef::COLUMN_VERGI_DAIRESI]            = Str::upper($vergiDairesi);
            $payload[Mukellef::COLUMN_ULKE]                     = Str::upper($ulke);
            $payload[Mukellef::COLUMN_IL]                       = Str::upper($il);
            $payload[Mukellef::COLUMN_ILCE]                     = Str::upper($ilce);

            if ($website) {
                $payload[Mukellef::COLUMN_WEBSITE]              = $website;
            }

            if ($email) {
                $payload[Mukellef::COLUMN_EMAIL]                = $email;
            }

            if ($telefon) {
                $payload[Mukellef::COLUMN_TELEFON]              = $telefon;
            }

            $payload[Mukellef::COLUMN_ADRES]                    = Str::upper($mahalleCadde);

            if ($email) {
                $payload[Mukellef::COLUMN_URN]                  = 'urn:mail:' . $email;
            }

            Mukellef::create($payload);
        }
    }

    /**
     * @return string
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     * @return ImportMukellefler
     */
    public function setDelimiter(string $delimiter): ImportMukellefler
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeaderOffset(): int
    {
        return $this->headerOffset;
    }

    /**
     * @param int $headerOffset
     * @return ImportMukellefler
     */
    public function setHeaderOffset(int $headerOffset): ImportMukellefler
    {
        $this->headerOffset = $headerOffset;
        return $this;
    }
}
