<?php

namespace App\Http\Requests;

use App\Models\Abone;
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
            Fatura::COLUMN_BIRIM_FIYAT_DAGITIM  => 'required_if:tur,' . Abone::COLUMN_TUR_ELEKTRIK . '|numeric',
            Fatura::COLUMN_BIRIM_FIYAT_SISTEM   => 'required_if:tur,' . Abone::COLUMN_TUR_ELEKTRIK . '|numeric',
            Fatura::COLUMN_SON_ODEME_TARIHI     => 'required|date_format:d.m.Y',
            Fatura::COLUMN_ENDEKS_ILK           => 'required|numeric',
            Fatura::COLUMN_ENDEKS_SON           => 'required|numeric|gte:' . Fatura::COLUMN_ENDEKS_ILK,
            Fatura::COLUMN_NOT                  => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'abone_id'                          => 'Abone',
            'tur'                               => 'Abonelik Türü',
            Fatura::COLUMN_BIRIM_FIYAT_TUKETIM  => 'Birim Tüketim Fiyatı',
            Fatura::COLUMN_BIRIM_FIYAT_DAGITIM  => 'Birim Dağıtım Fiyatı',
            Fatura::COLUMN_BIRIM_FIYAT_SISTEM   => 'Birim Sistem Fiyatı',
            Fatura::COLUMN_SON_ODEME_TARIHI     => 'Son Ödeme Tarihi',
            Fatura::COLUMN_ENDEKS_ILK           => 'İlk Endeks',
            Fatura::COLUMN_ENDEKS_SON           => 'Son Endeks',
            Fatura::COLUMN_NOT                  => 'Fatura Açıklaması',
        ];
    }

    protected function prepareForValidation()
    {
        $payload = [
            Fatura::COLUMN_BIRIM_FIYAT_TUKETIM  => str_replace(',', '.', $this->{Fatura::COLUMN_BIRIM_FIYAT_TUKETIM}),
            Fatura::COLUMN_ENDEKS_ILK           => str_replace(',', '.', $this->{Fatura::COLUMN_ENDEKS_ILK}),
            Fatura::COLUMN_ENDEKS_SON           => str_replace(',', '.', $this->{Fatura::COLUMN_ENDEKS_SON}),
        ];

        if (isset($this->{Fatura::COLUMN_BIRIM_FIYAT_DAGITIM})) {
            $payload[Fatura::COLUMN_BIRIM_FIYAT_DAGITIM]  = str_replace(',', '.', $this->{Fatura::COLUMN_BIRIM_FIYAT_DAGITIM});
        }
        if (isset($this->{Fatura::COLUMN_BIRIM_FIYAT_SISTEM})) {
            $payload[Fatura::COLUMN_BIRIM_FIYAT_SISTEM]  = str_replace(',', '.', $this->{Fatura::COLUMN_BIRIM_FIYAT_SISTEM});
        }

        $this->merge($payload);
    }
}
