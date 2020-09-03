<?php


namespace App\Services\Import\Osb;

use App\Helpers\Utils;
use App\Models\Abone;
use App\Models\Mukellef;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Statement;


class ImportElektrikAboneNo
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
                $sira,
                $aboneNo,
                $aboneAdi,
                $adaParsel,
                $tcNo,
                $vergiNo,
                ) = $record;

            preg_match('~.*\s(\d+)$~i', $vergiNo, $output);

            $vergiNo = $output[1] ?? null;

            if (empty($vergiNo)) {
                continue;
            }

            preg_match('~.*=(\d+)$~i', $aboneNo, $output);

            $aboneNo = $output[1] ?? null;

            if (empty($aboneNo)) {
                continue;
            }

            if (mb_strlen($vergiNo) === 11) {
                $payload[Mukellef::COLUMN_TC_KIMLIK_NO]         = $vergiNo;
            }
            else {
                $payload[Mukellef::COLUMN_VERGI_NO]             = $vergiNo;
            }

            $mukellef   = Mukellef::where($payload)->first();

            if (!$mukellef) {
                continue;
            }

            $abone      = [
                Abone::COLUMN_TUR               => Abone::COLUMN_TUR_ELEKTRIK,
                Abone::COLUMN_MUKELLEF_ID       => $mukellef->id,
                Abone::COLUMN_BASLIK            => 'Merkez Şube',
                Abone::COLUMN_ABONE_NO          => Utils::getFormattedAboneNo((int)($aboneNo)),
                Abone::COLUMN_TRT_PAYI          => 0,
                Mukellef::COLUMN_EMAIL          => $mukellef->{Mukellef::COLUMN_EMAIL},
                Mukellef::COLUMN_TELEFON        => $mukellef->{Mukellef::COLUMN_TELEFON},
                Mukellef::COLUMN_WEBSITE        => $mukellef->{Mukellef::COLUMN_WEBSITE},
                Mukellef::COLUMN_ULKE           => $mukellef->{Mukellef::COLUMN_ULKE},
                Mukellef::COLUMN_IL             => $mukellef->{Mukellef::COLUMN_IL},
                Mukellef::COLUMN_ILCE           => $mukellef->{Mukellef::COLUMN_ILCE},
                Mukellef::COLUMN_ADRES          => $mukellef->{Mukellef::COLUMN_ADRES},
                Mukellef::COLUMN_URN            => $mukellef->{Mukellef::COLUMN_URN},
            ];

            Abone::create($abone);
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
     * @return ImportElektrikAboneNo
     */
    public function setDelimiter(string $delimiter): ImportElektrikAboneNo
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
     * @return ImportElektrikAboneNo
     */
    public function setHeaderOffset(int $headerOffset): ImportElektrikAboneNo
    {
        $this->headerOffset = $headerOffset;
        return $this;
    }
}
