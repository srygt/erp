<?php

namespace App\Imports;

use App\Contracts\ExcelImportInterface;
use App\Models\Abone;
use App\Models\AyarEkKalem;
use App\Models\Fatura;
use App\Models\ImportedFatura;
use App\Models\ImportedFaturaEkKalem;
use App\Models\ImportedFaturaElektrik;
use App\Services\Import\Fatura\Elektrik\EkKalem;
use App\Services\Import\Fatura\Elektrik\Models\Row;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ElektrikFaturasImport implements ExcelImportInterface, toModel
    , WithCustomCsvSettings, WithValidation, WithStartRow
{
    use Importable;

    const START_ROW = 2;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * ElektrikFaturasImport constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function model(array $array)
    {
        /** @var Row $faturaElektrikRow */
        $faturaElektrikRow = app(Row::class, ['array' => $array]);

        /** @var Abone $abone */
        $abone = Abone::where(Abone::COLUMN_ABONE_NO, $faturaElektrikRow->getAboneNo())
            ->where(Abone::COLUMN_TUR, Abone::COLUMN_TUR_ELEKTRIK)
            ->first();

        /** @var ImportedFatura $importedFatura */
        $importedFatura = $abone->importedFaturalar()->make();

        $importedFatura->{ImportedFatura::COLUMN_TUR}                   = Abone::COLUMN_TUR_ELEKTRIK;
        $importedFatura->{ImportedFatura::COLUMN_ENDEKS_ILK}            = '0';
        $importedFatura->{ImportedFatura::COLUMN_ENDEKS_SON}            = $faturaElektrikRow->getToplamTuketim();
        $importedFatura->{ImportedFatura::COLUMN_BIRIM_FIYAT_TUKETIM}   = $this->params[Fatura::COLUMN_BIRIM_FIYAT_TUKETIM];
        $importedFatura->{ImportedFatura::COLUMN_IP_NO}                 = Request::ip();

        $importedFatura->save();

        /** @var ImportedFaturaElektrik $importedFaturaElektrik */
        $importedFaturaElektrik = $importedFatura->elektrik()->make();

        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_GUNDUZ_TUKETIM}        = $faturaElektrikRow->getGunduzTuketim();
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_PUAND_TUKETIM}         = $faturaElektrikRow->getPuandTuketim();
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_GECE_TUKETIM}          = $faturaElektrikRow->getGeceTuketim();
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_KAPASITIF_TUKETIM}     = $faturaElektrikRow->getKapasitifTuketim();
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_ENDUKTIF_TUKETIM}      = $faturaElektrikRow->getReaktifTuketim();
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_KAPASITIF_BIRIM_FIYAT} = $this->params[Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT];
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_ENDUKTIF_BIRIM_FIYAT}  = $this->params[Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT];
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_IS_TRT_PAYI}           = $faturaElektrikRow->getTrtPayi() > 0;

        $importedFaturaElektrik->save();

        $importedFatura = $this->saveEkKalemGecikmeZammi($importedFatura, $faturaElektrikRow);
        $importedFatura = $this->saveEkKalemSistemKullanim($importedFatura, $faturaElektrikRow);
        $importedFatura = $this->saveEkKalemDagitimBedeli($importedFatura, $faturaElektrikRow);

        return $importedFatura;
    }

    /**
     * @param ImportedFatura $importedFatura
     * @param Row $faturaElektrikRow
     *
     * @return ImportedFatura
     */
    protected function saveEkKalemGecikmeZammi(ImportedFatura $importedFatura, Row $faturaElektrikRow) : ImportedFatura
    {
        if ($faturaElektrikRow->getGecikmeZammi() === 0.0) {
            return $importedFatura;
        }

        /** @var ImportedFaturaEkKalem $importedFaturaEkKalemGecikme */
        $importedFaturaEkKalemGecikme = $importedFatura->ekKalemler()->make();

        $gecikmeKalemi = AyarEkKalem::find($this->params[EkKalem::ID_GECIKME_BEDELI]);

        $importedFaturaEkKalemGecikme->{ImportedFaturaEkKalem::RELATION_EK_KALEM}()
            ->associate($gecikmeKalemi);
        $importedFaturaEkKalemGecikme->{ImportedFaturaEkKalem::COLUMN_DEGER}    = $faturaElektrikRow->getGecikmeZammi();
        $importedFaturaEkKalemGecikme->save();

        return $importedFatura;
    }

    /**+
     * @param ImportedFatura $importedFatura
     * @param Row $faturaElektrikRow
     *
     * @return ImportedFatura
     */
    protected function saveEkKalemSistemKullanim(ImportedFatura $importedFatura, Row $faturaElektrikRow) : ImportedFatura
    {
        if ($faturaElektrikRow->getSistemKullanimBedel() === 0.0) {
            return $importedFatura;
        }

        /** @var ImportedFaturaEkKalem $importedFaturaEkKalemSistem */
        $importedFaturaEkKalemSistem = $importedFatura->ekKalemler()->make();

        $sistemKullanimKalem = AyarEkKalem::find($this->params[EkKalem::ID_SISTEM_KULLANIM]);

        $importedFaturaEkKalemSistem->{ImportedFaturaEkKalem::RELATION_EK_KALEM}()
            ->associate($sistemKullanimKalem);
        $importedFaturaEkKalemSistem->{ImportedFaturaEkKalem::COLUMN_DEGER}    = $this->params[EkKalem::BIRIM_FIYAT_SISTEM_KULLANIM];;
        $importedFaturaEkKalemSistem->save();

        return $importedFatura;
    }

    /**
     * @param ImportedFatura $importedFatura
     * @param Row $faturaElektrikRow
     *
     * @return ImportedFatura
     */
    protected function saveEkKalemDagitimBedeli(ImportedFatura $importedFatura, Row $faturaElektrikRow) : ImportedFatura
    {
        if ($faturaElektrikRow->getDagitimBedel() === 0.0) {
            return $importedFatura;
        }

        /** @var ImportedFaturaEkKalem $importedFaturaEkKalemDagitim */
        $importedFaturaEkKalemDagitim = $importedFatura->ekKalemler()->make();

        $dagitimKalem = AyarEkKalem::find($this->params[EkKalem::ID_DAGITIM_BEDELI]);

        $importedFaturaEkKalemDagitim->{ImportedFaturaEkKalem::RELATION_EK_KALEM}()
            ->associate($dagitimKalem);
        $importedFaturaEkKalemDagitim->{ImportedFaturaEkKalem::COLUMN_DEGER}    = $this->params[EkKalem::BIRIM_FIYAT_DAGITIM_BEDELI];;
        $importedFaturaEkKalemDagitim->save();

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
            '*.0' => ['required', 'abone_exists:' . Abone::COLUMN_TUR_ELEKTRIK],
            '*.1' => ['string'],
            '*.2' => ['required', 'numeric', 'gte:0'],
            '*.3' => ['required', 'numeric', 'gte:0'],
            '*.4' => ['required', 'numeric', 'gte:0'],
            '*.5' => ['required', 'numeric', 'gte:0'],
            '*.6' => ['required', 'numeric', 'gte:0'],
            '*.7' => ['required', 'numeric', 'gte:0'],
            '*.8' => ['numeric', 'gte:0'],
            '*.9' => ['numeric', 'gte:0'],
            '*.10' => ['numeric', 'gte:0'],
            '*.11' => ['numeric', 'gte:0'],
            '*.12' => ['numeric', 'gte:0'],
            '*.13' => ['numeric', 'gte:0'],
            '*.14' => ['numeric', 'gte:0'],
            '*.15' => ['numeric', 'gte:0'],
            '*.16' => ['numeric', 'gte:0'],
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $data[0]    = substr(trim($data[0]), -3);

        $abone = Abone::where(Abone::COLUMN_TUR, 'elektrik')
            ->where(Abone::COLUMN_ABONE_NO, $data[0])
            ->first();

        if (is_null($abone)) {
            return $data;
        }

        $abone->{Abone::COLUMN_ENDUKTIF_BEDEL} = $data[8] > 0;
        $abone->{Abone::COLUMN_KAPASITIF_BEDEL} = $data[9] > 0;
        $abone->{Abone::COLUMN_TRT_PAYI} = $data[12] > 0;
        $abone->save();

        return $data;
    }

    public function customValidationAttributes()
    {
        return [
            '0' => '"Abone No" Hücresi',
            '1' => '"Abone Adı" Hücresi',
            '2' => '"Toplam Tüketim" Hücresi',
            '3' => '"Gündüz" Hücresi',
            '4' => '"Puand" Hücresi',
            '5' => '"Gece" Hücresi',
            '6' => '"Reaktif Tüketim" Hücresi',
            '7' => '"Kapasitif Tüketim" Hücresi',
            '8' => '"Reaktif Bedel" Hücresi',
            '9' => '"Kapasitif Bedel" Hücresi',
            '10' => '"Sistem Kullanım Bedeli" Hücresi',
            '11' => '"Dağıtım Bedeli" Hücresi',
            '12' => '"Trt Payı" Hücresi',
            '13' => '"Gecikme Zammı" Hücresi',
            '14' => '"KDV Matrahı" Hücresi',
            '15' => '"KDV Bedeli" Hücresi',
            '16' => '"Fatura Toplamı" Hücresi',
        ];
    }
}
