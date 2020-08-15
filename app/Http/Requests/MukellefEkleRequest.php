<?php

namespace App\Http\Requests;

use App\Models\Mukellef;
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
        $mukellefModel = new Mukellef;

        return [
            'id'                    => 'nullable|numeric',
            'vkntckn'               => 'required|digits_between:10,11',
            'vergi_no'              => ['nullable', new VergiNoRule, 'unique:' . $mukellefModel->getTable() . ',vergi_no,' . $this->id],
            'tc_kimlik_no'          => ['nullable', new TcknRule, 'unique:' . $mukellefModel->getTable() . ',tc_kimlik_no,' . $this->id],
            'unvan'                 => 'required|unique:' . $mukellefModel->getTable() . ',unvan,' . $this->id,
            'vergi_dairesi_sehir'   => 'required',
            'vergi_dairesi'         => 'required',
            'urn'                   => ['required', new UrnRule],
            'email'                 => 'required|email|unique:' . $mukellefModel->getTable() . ',email,' . $this->id,
            'telefon'               => 'required|digits:12|unique:' . $mukellefModel->getTable() . ',telefon,' . $this->id,
            'website'               => 'nullable|url',
            'ulke'                  => 'required',
            'il'                    => 'required',
            'ilce'                  => 'required',
            'adres'                 => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'vkntckn'               => 'VKN/TCKN',
            'vergi_no'              => 'VKN/TCKN',
            'tc_kimlik_no'          => 'VKN/TCKN',
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
        if ( isset($this->vkntckn) &&  strlen($this->vkntckn) == 11 ) {
            $parameters['tc_kimlik_no'] = $this->vkntckn;
        }
        else if ( isset($this->vkntckn) &&  strlen($this->vkntckn) == 10 ) {
            $parameters['vergi_no'] = $this->vkntckn;
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
