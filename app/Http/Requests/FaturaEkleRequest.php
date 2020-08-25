<?php

namespace App\Http\Requests;

use App\Models\Fatura;
use Illuminate\Foundation\Http\FormRequest;

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
        return [
            Fatura::COLUMN_UUID     => 'required|uuid|exists:App\Models\FaturaTaslagi,uuid',
            'ek_kalemler.*'         => 'nullable|numeric|exists:App\Models\AyarEkKalem,id',
        ];
    }

    public function attributes()
    {
        return [
            Fatura::COLUMN_UUID     => 'Fatura Taslağı',
            'ek_kalemler.*'         => 'Ek Kalem',
        ];
    }

    protected function prepareForValidation()
    {
        $payload = [];

        if (!isset($this->ek_kalemler) || is_array($this->ek_kalemler)) {
            $payload['ek_kalemler']              = [];
        }

        $this->merge($payload);
    }
}
