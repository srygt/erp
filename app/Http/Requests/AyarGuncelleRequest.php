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
            'banka_hesap_adi'   => 'required',
            'iban'              => 'required',
            'birim_fiyat'       => 'required|numeric|min:0.000001',
            'son_odeme_gun'     => 'required|digits_between:1,29',
            'fatura_aciklama'   => 'nullable'
        ];

        return [
            Ayar::FIELD_ELEKTRIK_BANKA_HESAP_ADI        => $rules['banka_hesap_adi'],
            Ayar::FIELD_ELEKTRIK_BANKA_IBAN             => $rules['iban'],
            Ayar::FIELD_ELEKTRIK_SON_ODEME_GUN          => $rules['son_odeme_gun'],
            Ayar::FIELD_ELEKTRIK_TUKETIM_BIRIM_FIYAT    => $rules['birim_fiyat'],
            Ayar::FIELD_ELEKTRIK_FATURA_ACIKLAMA        => $rules['fatura_aciklama'],
            Ayar::FIELD_SU_BANKA_HESAP_ADI              => $rules['banka_hesap_adi'],
            Ayar::FIELD_SU_BANKA_IBAN                   => $rules['iban'],
            Ayar::FIELD_SU_SON_ODEME_GUN                => $rules['son_odeme_gun'],
            Ayar::FIELD_SU_TUKETIM_BIRIM_FIYAT          => $rules['birim_fiyat'],
            Ayar::FIELD_SU_FATURA_ACIKLAMA              => $rules['fatura_aciklama'],
            Ayar::FIELD_DOGALGAZ_BANKA_HESAP_ADI        => $rules['banka_hesap_adi'],
            Ayar::FIELD_DOGALGAZ_BANKA_IBAN             => $rules['iban'],
            Ayar::FIELD_DOGALGAZ_SON_ODEME_GUN          => $rules['son_odeme_gun'],
            Ayar::FIELD_DOGALGAZ_TUKETIM_BIRIM_FIYAT    => $rules['birim_fiyat'],
            Ayar::FIELD_DOGALGAZ_FATURA_ACIKLAMA        => $rules['fatura_aciklama'],
        ];
    }

    public function attributes()
    {
        return [
            Ayar::FIELD_ELEKTRIK_BANKA_HESAP_ADI        => 'Elektrik Faturası Banka Hesap Adı',
            Ayar::FIELD_ELEKTRIK_BANKA_IBAN             => 'Elektrik Faturası Banka IBAN',
            Ayar::FIELD_ELEKTRIK_SON_ODEME_GUN          => 'Elektrik Faturası Son Ödeme Günü',
            Ayar::FIELD_ELEKTRIK_TUKETIM_BIRIM_FIYAT    => 'Elektrik Faturası Birim Tüketim Fiyatı',
            Ayar::FIELD_ELEKTRIK_FATURA_ACIKLAMA        => 'Elektrik Faturası Açıklama',
            Ayar::FIELD_SU_BANKA_HESAP_ADI              => 'Su Faturası Banka Hesap Adı',
            Ayar::FIELD_SU_BANKA_IBAN                   => 'Su Faturası Banka IBAN',
            Ayar::FIELD_SU_SON_ODEME_GUN                => 'Su Faturası Son Ödeme Günü',
            Ayar::FIELD_SU_TUKETIM_BIRIM_FIYAT          => 'Su Faturası Birim Tüketim Fiyatı',
            Ayar::FIELD_SU_FATURA_ACIKLAMA              => 'Su Faturası Açıklama',
            Ayar::FIELD_DOGALGAZ_BANKA_HESAP_ADI        => 'Doğalgaz Faturası Banka Hesap Adı',
            Ayar::FIELD_DOGALGAZ_BANKA_IBAN             => 'Doğalgaz Faturası Banka IBAN',
            Ayar::FIELD_DOGALGAZ_SON_ODEME_GUN          => 'Doğalgaz Faturası Son Ödeme Günü',
            Ayar::FIELD_DOGALGAZ_TUKETIM_BIRIM_FIYAT    => 'Doğalgaz Faturası Birim Tüketim Fiyatı',
            Ayar::FIELD_DOGALGAZ_FATURA_ACIKLAMA        => 'Doğalgaz Faturası Açıklama',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'elektrik'  => [
                'banka_hesap_adi'                   => $this->elektrik['banka_hesap_adi'] ?? null,
                'banka_iban'                        => $this->elektrik['banka_iban'] ?? null,
                'son_odeme_gun'                     => $this->elektrik['son_odeme_gun'] ?? null,
                'tuketim_birim_fiyat'               => $this->convertPointsToDots('elektrik', 'tuketim_birim_fiyat') ?? null,
                'fatura_aciklama'                   => $this->elektrik['fatura_aciklama'] ?? null,
            ],
            'su' => [
                'banka_hesap_adi'                   => $this->su['banka_hesap_adi'] ?? null,
                'banka_iban'                        => $this->su['banka_iban'] ?? null,
                'son_odeme_gun'                     => $this->su['son_odeme_gun'] ?? null,
                'tuketim_birim_fiyat'               => $this->convertPointsToDots('su', 'tuketim_birim_fiyat') ?? null,
                'fatura_aciklama'                   => $this->su['fatura_aciklama'] ?? null,
            ],
            'dogalgaz' => [
                'banka_hesap_adi'                   => $this->dogalgaz['banka_hesap_adi'] ?? null,
                'banka_iban'                        => $this->dogalgaz['banka_iban'] ?? null,
                'son_odeme_gun'                     => $this->dogalgaz['son_odeme_gun'] ?? null,
                'tuketim_birim_fiyat'               => $this->convertPointsToDots('dogalgaz', 'tuketim_birim_fiyat') ?? null,
                'fatura_aciklama'                   => $this->dogalgaz['fatura_aciklama'] ?? null,
            ]
        ]);
    }

    protected function convertPointsToDots($tabName, $fieldName) : ?string
    {
        if ( ! $this->{$tabName}[$fieldName] ?? null ) {
            return null;
        }

        return str_replace(',', '.', $this->{$tabName}[$fieldName]);
    }
}
