<?php

namespace App\Http\Requests;

use App\Models\Fatura;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FaturaTaslagiEkleRequest
 * @package App\Http\Requests
 *
 * @property int $id
 * @property int $abone_id
 * @property float $birim_fiyat
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
            'id'                            => 'nullable|numeric|exists:App\Models\FaturaTaslagi,id',
            'abone_id'                      => 'required|numeric|exists:App\Models\Abone,id',
            Fatura::COLUMN_BIRIM_FIYAT      => 'required|numeric',
            Fatura::COLUMN_SON_ODEME_TARIHI => 'required|date_format:d.m.Y',
            Fatura::COLUMN_ENDEKS_ILK       => 'required|numeric',
            Fatura::COLUMN_ENDEKS_SON       => 'required|numeric|gte:' . Fatura::COLUMN_ENDEKS_ILK,
            Fatura::COLUMN_NOT              => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'abone_id'                      => 'Abone',
            Fatura::COLUMN_BIRIM_FIYAT      => 'Birim Tüketim Fiyatı',
            Fatura::COLUMN_SON_ODEME_TARIHI => 'Son Ödeme Tarihi',
            Fatura::COLUMN_ENDEKS_ILK       => 'İlk Endeks',
            Fatura::COLUMN_ENDEKS_SON       => 'Son Endeks',
            Fatura::COLUMN_NOT              => 'Fatura Açıklaması',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            Fatura::COLUMN_BIRIM_FIYAT      => str_replace(',', '.', $this->{Fatura::COLUMN_BIRIM_FIYAT}),
            Fatura::COLUMN_ENDEKS_ILK       => str_replace(',', '.', $this->{Fatura::COLUMN_ENDEKS_ILK}),
            Fatura::COLUMN_ENDEKS_SON       => str_replace(',', '.', $this->{Fatura::COLUMN_ENDEKS_SON}),
        ]);
    }
}
