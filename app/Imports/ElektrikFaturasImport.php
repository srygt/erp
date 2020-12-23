<?php

namespace App\Imports;

use App\Models\Abone;
use App\Models\ImportedFatura;
use App\Models\ImportedFaturaElektrik;
use App\Services\Import\Fatura\Elektrik\Models\Row;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ElektrikFaturasImport implements toModel, WithCustomCsvSettings, WithValidation, WithStartRow
{
    use Importable;

    const START_ROW = 2;

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
        $importedFatura->{ImportedFatura::COLUMN_BIRIM_FIYAT_TUKETIM}   = $faturaElektrikRow->getCalcBirimTuketimUcreti();
        $importedFatura->{ImportedFatura::COLUMN_IP_NO}                 = Request::ip();

        $importedFatura->save();

        /** @var ImportedFaturaElektrik $importedFaturaElektrik */
        $importedFaturaElektrik = $importedFatura->elektrik()->make();

        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_GUNDUZ_TUKETIM}        = $faturaElektrikRow->getGunduzTuketim();
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_PUAND_TUKETIM}         = $faturaElektrikRow->getPuandTuketim();
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_GECE_TUKETIM}          = $faturaElektrikRow->getGeceTuketim();
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_KAPASITIF_TUKETIM}     = $faturaElektrikRow->getKapasitifTuketim();
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_ENDUKTIF_TUKETIM}      = $faturaElektrikRow->getReaktifTuketim();
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_KAPASITIF_BIRIM_FIYAT} = $faturaElektrikRow->getCalcBirimKapasitifTuketimUcreti();
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_ENDUKTIF_BIRIM_FIYAT}  = $faturaElektrikRow->getCalcBirimReaktifTuketimUcreti();
        $importedFaturaElektrik->{ImportedFaturaElektrik::COLUMN_IS_TRT_PAYI}           = $faturaElektrikRow->getTrtPayi() > 0;

        $importedFaturaElektrik->save();

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
            // TODO: elektrik exists
            '*.0' => ['required', 'abone_exists:' . Abone::COLUMN_TUR_ELEKTRIK],
            '*.1' => ['string'],
            '*.2' => ['required', 'numeric'],
            '*.3' => ['required', 'numeric'],
            '*.4' => ['required', 'numeric'],
            '*.5' => ['required', 'numeric'],
            '*.6' => ['required', 'numeric'],
            '*.7' => ['required', 'numeric'],
            '*.8' => ['numeric', 'abone_activation:*.0,' . Abone::COLUMN_TUR_ELEKTRIK . ',' . Abone::COLUMN_ENDUKTIF_BEDEL],
            '*.9' => ['numeric', 'abone_activation:*.0,' . Abone::COLUMN_TUR_ELEKTRIK . ',' . Abone::COLUMN_KAPASITIF_BEDEL],
            '*.10' => ['numeric'],
            '*.11' => ['numeric'],
            '*.12' => ['numeric', 'abone_activation:*.0,' . Abone::COLUMN_TUR_ELEKTRIK . ',' . Abone::COLUMN_TRT_PAYI],
            '*.13' => ['numeric'],
            '*.14' => ['numeric'],
            '*.15' => ['numeric'],
            '*.16' => ['numeric'],
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $data[0]    = substr(trim($data[0]), -3);

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
