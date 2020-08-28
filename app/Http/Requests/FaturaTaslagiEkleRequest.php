<?php

namespace App\Http\Requests;

use App\Models\Abone;
use App\Models\AyarEkKalem;
use App\Models\Fatura;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class FaturaTaslagiEkleRequest
 * @package App\Http\Requests
 *
 * @property int $id
 * @property int $abone_id
 * @property float $birim_fiyat
 * @property float $dagitim_birim_fiyat
 * @property float $sistem_birim_fiyat
 * @property string $son_odeme_tarihi
 * @property float $ilk_endeks
 * @property float $son_endeks
 * @property string $not
 * @property float $tuketim
 */
class FaturaTaslagiEkleRequest extends FormRequest
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
            'id'                                => 'nullable|numeric|exists:App\Models\FaturaTaslagi,id',
            'abone_id'                          => 'required|numeric|exists:App\Models\Abone,id',
            'tur'                               => ['required', Rule::in(array_keys(Abone::TUR_LIST))],
            Fatura::COLUMN_BIRIM_FIYAT_TUKETIM  => 'required|numeric',
            Fatura::COLUMN_SON_ODEME_TARIHI     => 'required|date_format:d.m.Y',
            Fatura::COLUMN_ENDEKS_ILK           => 'required|numeric',
            Fatura::COLUMN_ENDEKS_SON           => 'required|numeric|gte:' . Fatura::COLUMN_ENDEKS_ILK,
            Fatura::COLUMN_NOT                  => 'nullable',
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
            'abone_id'                          => 'Abone',
            'tur'                               => 'Abonelik Türü',
            Fatura::COLUMN_BIRIM_FIYAT_TUKETIM  => 'Birim Tüketim Fiyatı',
            Fatura::COLUMN_SON_ODEME_TARIHI     => 'Son Ödeme Tarihi',
            Fatura::COLUMN_ENDEKS_ILK           => 'İlk Endeks',
            Fatura::COLUMN_ENDEKS_SON           => 'Son Endeks',
            Fatura::COLUMN_NOT                  => 'Fatura Açıklaması',
            'ek_kalemler'                       => 'Ek Kalemler',
            'ek_kalemler.*'                     => 'Ek Kalem',
            'ek_kalemler.*.id'                  => 'Ek Kalem Idsi',
            'ek_kalemler.*.ucret_tur'           => 'Ek Kalem Ücret Türü',
            'ek_kalemler.*.deger'               => 'Ek Kalem Tutarı',
        ];
    }

    protected function prepareForValidation()
    {
        $payload = [
            Fatura::COLUMN_BIRIM_FIYAT_TUKETIM  => str_replace(',', '.', $this->{Fatura::COLUMN_BIRIM_FIYAT_TUKETIM}),
            Fatura::COLUMN_ENDEKS_ILK           => str_replace(',', '.', $this->{Fatura::COLUMN_ENDEKS_ILK}),
            Fatura::COLUMN_ENDEKS_SON           => str_replace(',', '.', $this->{Fatura::COLUMN_ENDEKS_SON}),
        ];

        $payload['ek_kalemler']             = $this->uygulanmayacakEkKalemleriKaldir();

        $this->merge($payload);
    }

    /**
     * @return array
     */
    protected function uygulanmayacakEkKalemleriKaldir() : array
    {
        $ek_kalemler            = [];

        foreach ($this->ek_kalemler ?? [] as $ek_kalem)
        {
            $status             = AyarEkKalem::where([
                                        'id'                    => $ek_kalem['id'] ?? '',
                                        AyarEkKalem::COLUMN_TUR => $this->{Fatura::COLUMN_TUR} ?? '',
                                    ])->exists();

            if ($status) {
                $ek_kalemler[]   = $ek_kalem;
            }
        }

        return $ek_kalemler;
    }
}
