<?php

namespace App\Imports;

use App\Contracts\ExcelImportInterface;
use App\Models\Abone;
use App\Models\AyarEkKalem;
use App\Models\Fatura;
use App\Models\ImportedFatura;
use App\Models\ImportedFaturaEkKalem;
use App\Services\Import\Fatura\Dogalgaz\EkKalem;
use App\Services\Import\Fatura\Dogalgaz\Models\Row;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DogalgazFaturasImport implements ExcelImportInterface, toModel
    , WithCustomCsvSettings, WithValidation, WithStartRow
{
    use Importable;

    const START_ROW = 2;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * DogalgazFaturasImport constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function model(array $array)
    {
        /** @var Row $faturaDogalgazRow */
        $faturaDogalgazRow = app(Row::class, ['array' => $array]);

        /** @var Abone $abone */
        $abone = Abone::where(Abone::COLUMN_ABONE_NO, $faturaDogalgazRow->getAboneNo())
            ->where(Abone::COLUMN_TUR, Abone::COLUMN_TUR_DOGALGAZ)
            ->first();

        /** @var ImportedFatura $importedFatura */
        $importedFatura = $abone->importedFaturalar()->make();

        $importedFatura->{ImportedFatura::COLUMN_TUR}                   = Abone::COLUMN_TUR_DOGALGAZ;
        $importedFatura->{ImportedFatura::COLUMN_ENDEKS_ILK}            = '0';
        $importedFatura->{ImportedFatura::COLUMN_ENDEKS_SON}            = $faturaDogalgazRow->getToplamDuzeltilmisTuketim();
        $importedFatura->{ImportedFatura::COLUMN_BIRIM_FIYAT_TUKETIM}   = $this->params[Fatura::COLUMN_BIRIM_FIYAT_TUKETIM];
        $importedFatura->{ImportedFatura::COLUMN_IP_NO}                 = Request::ip();

        $importedFatura->save();

        $importedFatura = $this->saveEkKalemGecikmeZammi($importedFatura, $faturaDogalgazRow);

        return $importedFatura;
    }

    /**
     * @param ImportedFatura $importedFatura
     * @param Row $faturaDogalgazRow
     *
     * @return ImportedFatura
     */
    protected function saveEkKalemGecikmeZammi(ImportedFatura $importedFatura, Row $faturaDogalgazRow) : ImportedFatura
    {
        if ($faturaDogalgazRow->getGecikmeBedel() === 0.0) {
            return $importedFatura;
        }

        /** @var ImportedFaturaEkKalem $importedFaturaEkKalemGecikme */
        $importedFaturaEkKalemGecikme = $importedFatura->ekKalemler()->make();

        $gecikmeKalemi = AyarEkKalem::find($this->params[EkKalem::ID_GECIKME_BEDELI]);

        $importedFaturaEkKalemGecikme->{ImportedFaturaEkKalem::RELATION_EK_KALEM}()
            ->associate($gecikmeKalemi);
        $importedFaturaEkKalemGecikme->{ImportedFaturaEkKalem::COLUMN_DEGER}    = $faturaDogalgazRow->getGecikmeBedel();
        $importedFaturaEkKalemGecikme->save();

        return $importedFatura;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ";"
        ];
    }

    public function startRow(): int
    {
        return self::START_ROW;
    }

    public function rules(): array
    {
        return [
            '*.0' => ['required', 'abone_exists:' . Abone::COLUMN_TUR_DOGALGAZ],
            '*.1' => ['string'],
            '*.2' => ['numeric', 'gte:0'],
            '*.3' => ['numeric', 'gte:0'],
            '*.4' => ['numeric', 'gte:0'],
            '*.5' => ['numeric', 'gte:0'],
            '*.6' => ['numeric', 'gte:0'],
            '*.7' => ['numeric', 'gte:0'],
            '*.8' => ['numeric', 'gte:0'],
            '*.9' => ['numeric', 'gte:0'],
            '*.10' => ['numeric', 'gte:0'],
            '*.11' => ['required', 'numeric', 'gte:0'],
            '*.12' => ['numeric', 'gte:0'],
            '*.13' => ['numeric', 'gte:0'],
            '*.14' => ['numeric', 'gte:0'],
            '*.15' => ['numeric', 'gte:0'],
            '*.16' => ['numeric', 'gte:0'],
            '*.17' => ['numeric', 'gte:0'],
            '*.18' => ['numeric', 'gte:0'],
            '*.19' => ['numeric', 'gte:0'],
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $data[0] = preg_replace('~[^0-9]+~', '', (string) $data[0]);
        $data[0] = substr(trim($data[0]), -3);

        $data[1] = (string) $data[1];
        $data[2] = (float) $data[2];
        $data[3] = (float) $data[3];
        $data[4] = (float) $data[4];
        $data[5] = (float) $data[5];
        $data[6] = (float) $data[6];
        $data[7] = (float) $data[7];
        $data[8] = (float) $data[8];
        $data[9] = (float) $data[9];
        $data[10] = (float) $data[10];
        $data[11] = (float) $data[11];
        $data[12] = (float) $data[12];
        $data[13] = (float) $data[13];
        $data[14] = (float) $data[14];
        $data[15] = (float) $data[15];
        $data[16] = (float) $data[16];
        $data[17] = (float) $data[17];
        $data[18] = (float) $data[18];
        $data[19] = (float) $data[19];

        return $data;
    }

    public function customValidationAttributes()
    {
        return [
            '0' => '"Abone No" Hücresi',
            '1' => '"Firma Adı" Hücresi',
            '2' => '"Basınç (Bar)" Hücresi',
            '3' => '"İlk Endeks (m³)" Hücresi',
            '4' => '"Son Endeks(m³)" Hücresi',
            '5' => '"Fark(m³)" Hücresi',
            '6' => '"Ger. Tük.(m³)" Hücresi',
            '7' => '"Düz. Tük. (Sm³)" Hücresi',
            '8' => '"Toplam Sm3" Hücresi',
            '9' => '"Kw Dönüşüm Katsayısı" Hücresi',
            '10' => '"Düzeltilmiş Tüketim (Kw)" Hücresi',
            '11' => '"Toplam Düzeltilmiş Tüketim (Kw)" Hücresi',
            '12' => '"Birim Fiyat (TL/Kw)" Hücresi',
            '13' => '"KDV Hariç Bedel (TL)" Hücresi',
            '14' => '"ÖTV Birim Fiyat(TL/Kw)" Hücresi',
            '15' => '"KDV Hariç ÖTV (TL)" Hücresi',
            '16' => '"%18 KDV (TL)" Hücresi',
            '17' => 'KDV Dahil Fat.(TL)',
            '18' => 'Toplam Fat. Bedeli',
            '19' => 'Gecikmeler',
        ];
    }
}
