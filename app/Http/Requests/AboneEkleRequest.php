<?php

namespace App\Http\Requests;

use App\Helpers\Utils;
use App\Models\Abone;
use App\Rules\UniqueWithAdditionalColumnsRule;
use App\Rules\UrnRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AboneEkleRequest extends FormRequest
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
            'id'                            => 'nullable|numeric|exists:App\Models\Abone,id',
            'tur'                           => ['required', Rule::in(array_keys(Abone::TUR_LIST))],
            'mukellef_id'                   => 'required|numeric|exists:App\Models\Mukellef,id',
            'baslik'                        => 'required',
            'abone_no'                      => [
                                                'nullable',
                                                'numeric',
                                                new UniqueWithAdditionalColumnsRule(
                                                    Abone::class,
                                                    Abone::COLUMN_ABONE_NO,
                                                    $this->id,
                                                    'id',
                                                    Abone::COLUMN_TUR,
                                                    $this->{Abone::COLUMN_TUR}
                                                )
                                                ],
            'sayac_no'                      => [
                                                'nullable',
                                                'numeric',
                                                new UniqueWithAdditionalColumnsRule(
                                                    Abone::class,
                                                    Abone::COLUMN_SAYAC_NO,
                                                    $this->id,
                                                    'id',
                                                    Abone::COLUMN_TUR,
                                                    $this->{Abone::COLUMN_TUR}
                                                )
                                            ],
            Abone::COLUMN_SONDAJ_MI         => 'nullable|required_if:tur,' . Abone::COLUMN_TUR_SU . '|boolean',
            'trt_payi'                      => 'nullable|required_if:tur,' . Abone::COLUMN_TUR_ELEKTRIK . '|boolean',
            Abone::COLUMN_ENDUKTIF_BEDEL    => 'nullable|required_if:tur,' . Abone::COLUMN_TUR_ELEKTRIK . '|boolean',
            Abone::COLUMN_KAPASITIF_BEDEL   => 'nullable|required_if:tur,' . Abone::COLUMN_TUR_ELEKTRIK . '|boolean',
            'email'                         => 'nullable|email',
            'telefon'                       => 'nullable',
            'website'                       => 'nullable|url',
            'ulke'                          => 'required',
            'il'                            => 'required',
            'ilce'                          => 'required',
            'urn'                           => ['nullable', new UrnRule],
            'adres'                         => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'tur'                   => 'Abonelik T??r??',
            'mukellef_id'           => 'M??kellef',
            'baslik'                => 'Abonelik Ad??',
            'abone_no'              => 'Abone No',
            'sayac_no'              => 'Saya?? No',
            Abone::COLUMN_SONDAJ_MI => 'Sondaj Hatt?? M???',
            'trt_payi'              => 'TRT Pay?? Uygulanacak',
            'email'                 => 'E-Posta',
            'telefon'               => 'Telefon Numaras??',
            'website'               => 'Website Adresi',
            'ulke'                  => '??lke',
            'il'                    => '??l',
            'ilce'                  => '??l??e',
            'urn'                   => 'Urn',
            'adres'                 => 'Adres',
        ];
    }

    protected function prepareForValidation()
    {
        $parameters = [];

        // abone no
        // unique validatation rule'unun d??zg??n ??al????mas?? i??in
        // eloquent mutators'dan ??nce str_pad() left yapmam??z gerekiyor
        if ( isset($this->{Abone::COLUMN_ABONE_NO}) ) {
            $parameters[Abone::COLUMN_ABONE_NO] = Utils::getFormattedAboneNo($this->{Abone::COLUMN_ABONE_NO});
        }

        // telefon
        if ( isset($this->telefon) ) {
            $parameters['telefon'] = preg_replace('~\D~i', '', $this->telefon);
        }

        // website
        if ( isset($this->website) && !Str::startsWith($this->website, 'http') ) {
            $parameters['website'] = 'http://' . $this->website;
        }

        if ( isset($this->tur) && $this->tur !== Abone::COLUMN_TUR_ELEKTRIK ) {
            $parameters[Abone::COLUMN_TRT_PAYI]         = null;
            $parameters[Abone::COLUMN_KAPASITIF_BEDEL]  = null;
            $parameters[Abone::COLUMN_ENDUKTIF_BEDEL]   = null;
        }

        // aktif_mi
        if ( isset($this->aktif_mi) ) {
            $parameters['aktif_mi'] = null;
        }

        $this->merge($parameters);
    }
}
