<?php

namespace App\Http\Requests;

use App\Helpers\Utils;
use App\Models\AyarEkKalem;
use App\Models\Fatura;
use App\Models\FaturaTaslagi;
use App\Services\Fatura\FaturaFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaturaEkleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            Fatura::COLUMN_UUID                 => 'required|uuid|exists:App\Models\FaturaTaslagi,uuid|unique:App\Models\Fatura,uuid',
            'ek_kalemler'                       => 'nullable|array',
            'ek_kalemler.*'                     => 'nullable|array',
            'ek_kalemler.*.*.id'                => 'required|numeric|exists:App\Models\AyarEkKalem,id',
            'ek_kalemler.*.*.ucret_tur'         => ['required', Rule::in(array_keys(AyarEkKalem::LIST_UCRET_TUR))],
            'ek_kalemler.*.*.deger'             => 'required|numeric',
        ];

        $dataSourceString = FaturaTaslagi::where(
                    Fatura::COLUMN_UUID,
                    $this->{Fatura::COLUMN_UUID}
                )
                ->value(Fatura::COLUMN_DATA_SOURCE);

        $dataSource = FaturaFactory::createDataSource(
            $dataSourceString
        );

        return array_merge(
            $rules,
            $dataSource->getValidation()
        );
    }

    public function attributes()
    {
        return [
            Fatura::COLUMN_UUID                 => 'Fatura Taslağı',
            'ek_kalemler'                       => 'Ek Kalem Türleri',
            'ek_kalemler.*'                     => 'Ek Kalemler',
            'ek_kalemler.*.*'                   => 'Ek Kalem',
            'ek_kalemler.*.*.id'                => 'Ek Kalem Idsi',
            'ek_kalemler.*.*.ucret_tur'         => 'Ek Kalem Ücret Türü',
            'ek_kalemler.*.*.deger'             => 'Ek Kalem Tutarı',
        ];
    }

    protected function prepareForValidation()
    {
        $payload['ek_kalemler']             = $this->convertPointsToDots();

        $this->merge($payload);
    }

    /**
     * @return array
     */
    protected function convertPointsToDots() : array
    {
        $turler             = $this->ek_kalemler ?? [];
        $ekKalemList        = [];

        foreach ($turler as $tur => $ek_kalemler)
        {
            foreach ($ek_kalemler as $key => $ek_kalem)
            {
                if (empty($ek_kalem['id'])) {
                    continue;
                }

                if ($ek_kalem['deger'] ?? '') {
                    $ek_kalem['deger']      = Utils::getFloatValue($ek_kalem['deger']);
                }

                $ekKalemList[$tur][$key]    = $ek_kalem;
            }
        }

        return $ekKalemList;
    }
}
