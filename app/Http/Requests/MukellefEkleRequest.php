<?php

namespace App\Http\Requests;

use App\Rules\TcknRule;
use App\Rules\UrnRule;
use App\Rules\VergiNoRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class MukellefEkleRequest extends FormRequest
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
            'id'                    => 'nullable|numeric|exists:App\Models\Mukellef',
            'vkntckn'               => 'required|digits_between:10,11',
            'vergi_no'              => ['nullable', new VergiNoRule, 'unique:App\Models\Mukellef,vergi_no,' . $this->id],
            'tc_kimlik_no'          => ['nullable', new TcknRule, 'unique:App\Models\Mukellef,tc_kimlik_no,' . $this->id],
            'ad'                    => 'required_if:tur,TC Kimlik No',
            'soyad'                 => 'required_if:tur,TC Kimlik No',
            'unvan'                 => 'required|unique:App\Models\Mukellef,unvan,' . $this->id,
            'vergi_dairesi_sehir'   => 'nullable',
            'vergi_dairesi'         => 'required',
            'urn'                   => ['nullable', new UrnRule],
            'email'                 => 'nullable|email',
            'telefon'               => 'nullable',
            'website'               => 'nullable|url',
            'ulke'                  => 'required',
            'il'                    => 'required',
            'ilce'                  => 'required',
            'adres'                 => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'vkntckn'               => 'VKN/TCKN',
            'vergi_no'              => 'VKN/TCKN',
            'tc_kimlik_no'          => 'VKN/TCKN',
            'tur'                   => 'Kimlik Numarası Türü',
            'ad'                    => 'Ad',
            'soyad'                 => 'Soyad',
            'unvan'                 => 'Ünvan',
            'vergi_dairesi_sehir'   => 'Vergi Dairesi Şehir',
            'vergi_dairesi'         => 'Vergi Dairesi',
            'urn'                   => 'Urn',
            'email'                 => 'E-Posta',
            'telefon'               => 'Telefon Numarası',
            'website'               => 'Website Adresi',
            'ulke'                  => 'Ülke',
            'il'                    => 'İl',
            'ilce'                  => 'İlçe',
            'adres'                 => 'Adres',
        ];
    }

    protected function prepareForValidation()
    {
        $parameters = [];

        // vkntckn
        if ( isset($this->vkntckn) ) {

            if ( strlen($this->vkntckn) == 11 ) {
                $parameters['tc_kimlik_no'] = $this->vkntckn;
                $parameters['tur'] = 'TC Kimlik No';
            }
            else if ( strlen($this->vkntckn) == 10 ) {
                $parameters['vergi_no'] = $this->vkntckn;
                $parameters['tur'] = 'Vergi No';
            }
        }

        // telefon
        if ( isset($this->telefon) ) {
            $parameters['telefon'] = preg_replace('~\D~i', '', $this->telefon);
        }

        // website
        if ( isset($this->website) && !Str::startsWith($this->website, 'http') ) {
            $parameters['website'] = 'http://' . $this->website;
        }

        $this->merge($parameters);
    }

    /**
     * @return array
     */
    public function allFormatted()
    {
        $parameters = $this->all();

        return $this->formatParameters($parameters);
    }

    /**
     * @param array|mixed $parameters
     * @return array
     */
    public function onlyFormatted($parameters)
    {
        $parameters = $this->only($parameters);

        return $this->formatParameters($parameters);
    }

    /**
     * @param array $parameters
     * @return array
     */
    protected function formatParameters($parameters)
    {
        if (isset($parameters['website'])) {
            $parameters['website'] = explode('://', $parameters['website']);
            $parameters['website'] = $parameters['website'][1];
        }

        return $parameters;
    }
}
