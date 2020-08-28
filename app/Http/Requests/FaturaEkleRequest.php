<?php

namespace App\Http\Requests;

use App\Models\AyarEkKalem;
use App\Models\Fatura;
use App\Models\FaturaTaslagi;
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
        return [
            Fatura::COLUMN_UUID                 => 'required|uuid|exists:App\Models\FaturaTaslagi,uuid',
            'ek_kalemler'                       => 'nullable|array',
            'ek_kalemler.*.id'                  => 'required|numeric|exists:App\Models\AyarEkKalem,id',
            'ek_kalemler.*.ucret_tur'           => ['required', Rule::in(array_keys(AyarEkKalem::LIST_UCRET_TUR))],
            'ek_kalemler.*.deger'               => 'required_if:ek_kalemler.*.ucret_tur,'
                                                    . AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR
                                                    . '|numeric'
        ];
    }

    public function attributes()
    {
        return [
            Fatura::COLUMN_UUID                 => 'Fatura Taslağı',
            'ek_kalemler'                       => 'Ek Kalemler',
            'ek_kalemler.*'                     => 'Ek Kalem',
            'ek_kalemler.*.id'                  => 'Ek Kalem Idsi',
            'ek_kalemler.*.ucret_tur'           => 'Ek Kalem Ücret Türü',
            'ek_kalemler.*.deger'               => 'Ek Kalem Tutarı',
        ];
    }

    protected function prepareForValidation()
    {

        $payload['ek_kalemler']             = $this->uygulanmayacakEkKalemleriKaldir();

        $this->merge($payload);
    }

    /**
     * @return array
     */
    protected function uygulanmayacakEkKalemleriKaldir() : array
    {
        $ek_kalemler                = [];

        $faturaTaslak               = FaturaTaslagi::where('uuid', $this->{Fatura::COLUMN_UUID} ?? '')
                                                    ->first();

        if (!$faturaTaslak) {
            return [];
        }

        foreach ($this->ek_kalemler ?? [] as $ek_kalem)
        {
            $status             = AyarEkKalem::where([
                                        'id'                    => $ek_kalem['id'] ?? '',
                                        AyarEkKalem::COLUMN_TUR => $faturaTaslak->{Fatura::COLUMN_TUR},
                                    ])->exists();

            if ($status) {
                $ek_kalemler[]      = $ek_kalem;
            }
        }

        return $ek_kalemler;
    }
}
