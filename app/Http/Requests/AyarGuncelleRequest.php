<?php

namespace App\Http\Requests;

use App\Helpers\Utils;
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
            'birim_fiyat'       => 'required|numeric|min:0.000000001',
            'fatura_tarih'      => 'nullable|date_format:' . config('common.time.format'),
            'son_odeme_gun'     => 'required|digits_between:1,28',
            'fatura_aciklama'   => 'nullable',
        ];

        return [
            Ayar::FIELD_ELEKTRIK_BANKA_HESAP_ADI        => $rules['banka_hesap_adi'],
            Ayar::FIELD_ELEKTRIK_BANKA_IBAN             => $rules['iban'],
            Ayar::FIELD_ELEKTRIK_FATURA_TARIH           => $rules['fatura_tarih'],
            Ayar::FIELD_ELEKTRIK_SON_ODEME_GUN          => $rules['son_odeme_gun'],
            Ayar::FIELD_ELEKTRIK_TUKETIM_BIRIM_FIYAT    => $rules['birim_fiyat'],
            Ayar::FIELD_ELEKTRIK_ENDUKTIF_BIRIM_FIYAT   => $rules['birim_fiyat'],
            Ayar::FIELD_ELEKTRIK_KAPASITIF_BIRIM_FIYAT  => $rules['birim_fiyat'],
            Ayar::FIELD_ELEKTRIK_FATURA_ACIKLAMA        => $rules['fatura_aciklama'],
            Ayar::FIELD_SU_BANKA_HESAP_ADI              => $rules['banka_hesap_adi'],
            Ayar::FIELD_SU_BANKA_IBAN                   => $rules['iban'],
            Ayar::FIELD_SU_FATURA_TARIH                 => $rules['fatura_tarih'],
            Ayar::FIELD_SU_SON_ODEME_GUN                => $rules['son_odeme_gun'],
            Ayar::FIELD_SU_SEBEKE_TUKETIM_BIRIM_FIYAT   => $rules['birim_fiyat'],
            Ayar::FIELD_SU_SONDAJ_TUKETIM_BIRIM_FIYAT   => $rules['birim_fiyat'],
            Ayar::FIELD_SU_FATURA_ACIKLAMA              => $rules['fatura_aciklama'],
            Ayar::FIELD_DOGALGAZ_BANKA_HESAP_ADI        => $rules['banka_hesap_adi'],
            Ayar::FIELD_DOGALGAZ_BANKA_IBAN             => $rules['iban'],
            Ayar::FIELD_DOGALGAZ_FATURA_TARIH           => $rules['fatura_tarih'],
            Ayar::FIELD_DOGALGAZ_SON_ODEME_GUN          => $rules['son_odeme_gun'],
            Ayar::FIELD_DOGALGAZ_TUKETIM_BIRIM_FIYAT    => $rules['birim_fiyat'],
            Ayar::FIELD_DOGALGAZ_FATURA_ACIKLAMA        => $rules['fatura_aciklama'],
        ];
    }

    public function attributes()
    {
        return [
            Ayar::FIELD_ELEKTRIK_BANKA_HESAP_ADI        => 'Elektrik Faturas?? Banka Hesap Ad??',
            Ayar::FIELD_ELEKTRIK_BANKA_IBAN             => 'Elektrik Faturas?? Banka IBAN',
            Ayar::FIELD_ELEKTRIK_FATURA_TARIH           => 'Elektrik Faturas?? Tarihi',
            Ayar::FIELD_ELEKTRIK_SON_ODEME_GUN          => 'Elektrik Faturas?? Son ??deme G??n??',
            Ayar::FIELD_ELEKTRIK_TUKETIM_BIRIM_FIYAT    => 'Elektrik Faturas?? Birim T??ketim Fiyat??',
            Ayar::FIELD_ELEKTRIK_ENDUKTIF_BIRIM_FIYAT   => 'Elektrik End??ktif Bedel Birim T??ketim Fiyat??',
            Ayar::FIELD_ELEKTRIK_KAPASITIF_BIRIM_FIYAT  => 'Elektrik Kapasitif Bedel Birim T??ketim Fiyat??',
            Ayar::FIELD_ELEKTRIK_FATURA_ACIKLAMA        => 'Elektrik Faturas?? A????klama',
            Ayar::FIELD_SU_BANKA_HESAP_ADI              => 'Su Faturas?? Banka Hesap Ad??',
            Ayar::FIELD_SU_BANKA_IBAN                   => 'Su Faturas?? Banka IBAN',
            Ayar::FIELD_SU_FATURA_TARIH                 => 'Su Faturas?? Tarihi',
            Ayar::FIELD_SU_SON_ODEME_GUN                => 'Su Faturas?? Son ??deme G??n??',
            Ayar::FIELD_SU_SEBEKE_TUKETIM_BIRIM_FIYAT   => 'Su Faturas?? ??ebeke Hatt?? Birim T??ketim Fiyat??',
            Ayar::FIELD_SU_SONDAJ_TUKETIM_BIRIM_FIYAT   => 'Su Faturas?? Sondaj Hatt?? Birim T??ketim Fiyat??',
            Ayar::FIELD_SU_FATURA_ACIKLAMA              => 'Su Faturas?? A????klama',
            Ayar::FIELD_DOGALGAZ_BANKA_HESAP_ADI        => 'Do??algaz Faturas?? Banka Hesap Ad??',
            Ayar::FIELD_DOGALGAZ_BANKA_IBAN             => 'Do??algaz Faturas?? Banka IBAN',
            Ayar::FIELD_DOGALGAZ_FATURA_TARIH           => 'Do??algaz Faturas?? Tarihi',
            Ayar::FIELD_DOGALGAZ_SON_ODEME_GUN          => 'Do??algaz Faturas?? Son ??deme G??n??',
            Ayar::FIELD_DOGALGAZ_TUKETIM_BIRIM_FIYAT    => 'Do??algaz Faturas?? Birim T??ketim Fiyat??',
            Ayar::FIELD_DOGALGAZ_FATURA_ACIKLAMA        => 'Do??algaz Faturas?? A????klama',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'elektrik'  => [
                'banka_hesap_adi'                   => $this->elektrik['banka_hesap_adi'] ?? null,
                'banka_iban'                        => $this->elektrik['banka_iban'] ?? null,
                'fatura_tarih'                      => $this->elektrik['fatura_tarih'] ?? null,
                'son_odeme_gun'                     => $this->elektrik['son_odeme_gun'] ?? null,
                'tuketim_birim_fiyat'               => $this->convertPointsToDots('elektrik', 'tuketim_birim_fiyat') ?? null,
                'enduktif_birim_fiyat'              => $this->convertPointsToDots('elektrik', 'enduktif_birim_fiyat') ?? null,
                'kapasitif_birim_fiyat'             => $this->convertPointsToDots('elektrik', 'kapasitif_birim_fiyat') ?? null,
                'fatura_aciklama'                   => $this->elektrik['fatura_aciklama'] ?? null,
            ],
            'su' => [
                'banka_hesap_adi'                   => $this->su['banka_hesap_adi'] ?? null,
                'banka_iban'                        => $this->su['banka_iban'] ?? null,
                'fatura_tarih'                      => $this->su['fatura_tarih'] ?? null,
                'son_odeme_gun'                     => $this->su['son_odeme_gun'] ?? null,
                'sebeke_tuketim_birim_fiyat'        => $this->convertPointsToDots('su', 'sebeke_tuketim_birim_fiyat') ?? null,
                'sondaj_tuketim_birim_fiyat'        => $this->convertPointsToDots('su', 'sondaj_tuketim_birim_fiyat') ?? null,
                'fatura_aciklama'                   => $this->su['fatura_aciklama'] ?? null,
            ],
            'dogalgaz' => [
                'banka_hesap_adi'                   => $this->dogalgaz['banka_hesap_adi'] ?? null,
                'banka_iban'                        => $this->dogalgaz['banka_iban'] ?? null,
                'fatura_tarih'                      => $this->dogalgaz['fatura_tarih'] ?? null,
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

        return Utils::getFloatValue($this->{$tabName}[$fieldName]);
    }
}
