<?php

namespace App\Http\Requests;

use App\Models\Ayar;
use Illuminate\Foundation\Http\FormRequest;

class AyarGuncelleRequest extends FormRequest
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
        $rules  = [
            'birim_fiyat'   => 'required|numeric|min:0.000001',
            'son_odeme_gun' => 'required|digits_between:1,29',
        ];

        return [
            Ayar::FIELD_ELEKTRIK_SON_ODEME_GUN          => $rules['son_odeme_gun'],
            Ayar::FIELD_ELEKTRIK_TUKETIM_BIRIM_FIYAT    => $rules['birim_fiyat'],
            Ayar::FIELD_SU_SON_ODEME_GUN                => $rules['son_odeme_gun'],
            Ayar::FIELD_SU_TUKETIM_BIRIM_FIYAT          => $rules['birim_fiyat'],
            Ayar::FIELD_DOGALGAZ_SON_ODEME_GUN          => $rules['son_odeme_gun'],
            Ayar::FIELD_DOGALGAZ_TUKETIM_BIRIM_FIYAT    => $rules['birim_fiyat'],
        ];
    }

    public function attributes()
    {
        return [
            Ayar::FIELD_ELEKTRIK_SON_ODEME_GUN          => 'Elektrik Faturası Son Ödeme Günü',
            Ayar::FIELD_ELEKTRIK_TUKETIM_BIRIM_FIYAT    => 'Elektrik Faturası Birim Tüketim Fiyatı',
            Ayar::FIELD_SU_SON_ODEME_GUN                => 'Su Faturası Son Ödeme Günü',
            Ayar::FIELD_SU_TUKETIM_BIRIM_FIYAT          => 'Su Faturası Birim Tüketim Fiyatı',
            Ayar::FIELD_DOGALGAZ_SON_ODEME_GUN          => 'Doğalgaz Faturası Son Ödeme Günü',
            Ayar::FIELD_DOGALGAZ_TUKETIM_BIRIM_FIYAT    => 'Doğalgaz Faturası Birim Tüketim Fiyatı',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'elektrik'  => [
                'son_odeme_gun'                     => $this->elektrik['son_odeme_gun'],
                'tuketim_birim_fiyat'               => $this->convertPointsToDots('elektrik', 'tuketim_birim_fiyat'),
            ],
            'su' => [
                'son_odeme_gun'                     => $this->su['son_odeme_gun'],
                'tuketim_birim_fiyat'               => $this->convertPointsToDots('su', 'tuketim_birim_fiyat'),
            ],
            'dogalgaz' => [
                'son_odeme_gun'                     => $this->dogalgaz['son_odeme_gun'],
                'tuketim_birim_fiyat'               => $this->convertPointsToDots('dogalgaz', 'tuketim_birim_fiyat'),
            ]
        ]);
    }

    protected function convertPointsToDots($tabName, $fieldName)
    {
        return str_replace(',', '.', $this->{$tabName}[$fieldName]);
    }
}
