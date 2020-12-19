<?php

namespace App\Imports;

use App\Models\Abone;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FaturasImport implements ToCollection, WithCustomCsvSettings, WithValidation, WithStartRow
{
    use Importable;

    /**
     * @param Collection $collection
     * @return Collection
     */
    public function collection(Collection $collection)
    {
        return $collection->flatten();
    }

    public function model(array $array)
    {
        return $array;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ";"
        ];
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '*.0' => ['required', 'exists:' . Abone::class . ',' . Abone::COLUMN_ABONE_NO],
            '*.1' => ['string'],
            '*.2' => ['required', 'numeric'],
            '*.3' => ['required', 'numeric'],
            '*.4' => ['required', 'numeric'],
            '*.5' => ['required', 'numeric'],
            '*.6' => ['required', 'numeric'],
            '*.7' => ['required', 'numeric'],
            '*.8' => ['numeric', 'activation:*.0,' . Abone::class . ',' . Abone::COLUMN_ABONE_NO . ',' . Abone::COLUMN_ENDUKTIF_BEDEL],
            '*.9' => ['numeric', 'activation:*.0,' . Abone::class . ',' . Abone::COLUMN_ABONE_NO . ',' . Abone::COLUMN_KAPASITIF_BEDEL],
            '*.10' => ['numeric'],
            '*.11' => ['numeric'],
            '*.12' => ['numeric', 'activation:*.0,' . Abone::class . ',' . Abone::COLUMN_ABONE_NO . ',' . Abone::COLUMN_TRT_PAYI],
            '*.13' => ['numeric'],
            '*.14' => ['numeric'],
            '*.15' => ['numeric'],
            '*.16' => ['numeric'],
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $data[0]    = substr($data[0], -3);

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
