<?php

namespace App\Http\Requests;

use App\Models\Abone;
use App\Models\AyarEkKalem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AyarEkKalemRequest extends FormRequest
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
        return [
            'id'                        => 'nullable|exists:App\Models\AyarEkKalem,id',
            AyarEkKalem::COLUMN_TUR     => ['required', Rule::in(array_keys(Abone::TUR_LIST))],
            AyarEkKalem::COLUMN_BASLIK  => 'required|min:3',
            AyarEkKalem::COLUMN_DEGER   => 'required|numeric|min:0.000000001|max:999.999999999',
        ];
    }

    public function attributes()
    {
        return [
            AyarEkKalem::COLUMN_TUR     => 'Tür',
            AyarEkKalem::COLUMN_BASLIK  => 'Başlık',
            AyarEkKalem::COLUMN_DEGER   => 'Oran',
        ];
    }

    protected function prepareForValidation()
    {
        $data = [
            AyarEkKalem::COLUMN_TUR     => $this->{AyarEkKalem::COLUMN_TUR}     ?? null,
            AyarEkKalem::COLUMN_BASLIK  => $this->{AyarEkKalem::COLUMN_BASLIK}  ?? null,
            AyarEkKalem::COLUMN_DEGER   => $this->{AyarEkKalem::COLUMN_DEGER}   ?? null,
        ];

        foreach ($data as $key => $item) {
            $data[$key] = str_replace(',', '.', $item);
        }

        $this->merge($data);
    }

    protected function convertPointsToDots($tabName, $fieldName)
    {
        return str_replace(',', '.', $this->{$tabName}[$fieldName]);
    }
}
