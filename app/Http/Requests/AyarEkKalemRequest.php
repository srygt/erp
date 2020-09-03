<?php

namespace App\Http\Requests;

use App\Helpers\Utils;
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
            'id'                            => 'nullable|exists:App\Models\AyarEkKalem,id',
            AyarEkKalem::COLUMN_TUR         => ['required', Rule::in(array_keys(Abone::TUR_LIST))],
            AyarEkKalem::COLUMN_UCRET_TUR   => ['required', Rule::in(array_keys(AyarEkKalem::LIST_UCRET_TUR))],
            AyarEkKalem::COLUMN_BASLIK      => 'required|min:3',
            AyarEkKalem::COLUMN_DEGER       => 'nullable|required_if:'
                                                . AyarEkKalem::COLUMN_UCRET_TUR . ','
                                                . AyarEkKalem::FIELD_UCRET_BIRIM_FIYAT
                                                .'|numeric|min:0.000000001|max:999.999999999',
        ];
    }

    public function attributes()
    {
        return [
            AyarEkKalem::COLUMN_TUR         => 'Tür',
            AyarEkKalem::COLUMN_UCRET_TUR   => 'Ücret Türü',
            AyarEkKalem::COLUMN_BASLIK      => 'Başlık',
            AyarEkKalem::COLUMN_DEGER       => 'Birim Fiyat',
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->{AyarEkKalem::COLUMN_DEGER} ?? '' || $this->{AyarEkKalem::COLUMN_UCRET_TUR} ?? '' === AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR)
        {
            $data = [
                AyarEkKalem::COLUMN_DEGER   => null,
            ];
        }
        else{
            $data = [
                AyarEkKalem::COLUMN_DEGER   => Utils::getFloatValue($this->{AyarEkKalem::COLUMN_DEGER}),
            ];
        }

        $this->merge($data);
    }
}
