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
        $tur    = Abone::find($this->{Fatura::COLUMN_ABONE_ID} ?? '')->{Fatura::COLUMN_TUR} ?? '';

        return [
            'id'                                    => 'nullable|numeric|exists:App\Models\FaturaTaslagi,id',
            'abone_id'                              => 'required|numeric|exists:App\Models\Abone,id',
            'tur'                                   => ['required', Rule::in(array_keys(Abone::TUR_LIST))],
            Fatura::COLUMN_BIRIM_FIYAT_TUKETIM      => 'required|numeric',
            Fatura::COLUMN_SON_ODEME_TARIHI         => 'required|date_format:d.m.Y',
            Fatura::COLUMN_ENDEKS_ILK               => 'required_if:tur,' . Abone::COLUMN_TUR_SU . '|numeric',
            Fatura::COLUMN_ENDEKS_SON               => 'required|numeric|gte:' . Fatura::COLUMN_ENDEKS_ILK,
            Fatura::COLUMN_NOT                      => 'nullable',
            'ek_kalemler'                           => 'required|array',
            'ek_kalemler.' . $tur                   => 'nullable|array',
            'ek_kalemler.' . $tur . '.*.id'         => 'required|numeric|exists:App\Models\AyarEkKalem,id',
            'ek_kalemler.' . $tur . '.*.ucret_tur'  => ['required', Rule::in(array_keys(AyarEkKalem::LIST_UCRET_TUR))],
            'ek_kalemler.' . $tur . '.*.deger'      => 'required_if:ek_kalemler.*.ucret_tur,'
                                                    . AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR
                                                    . '|numeric'
        ];
    }

    public function attributes()
    {
        $tur    = Abone::find($this->{Fatura::COLUMN_ABONE_ID} ?? '')->{Fatura::COLUMN_TUR} ?? '';

        return [
            'abone_id'                              => 'Abone',
            'tur'                                   => 'Abonelik Türü',
            Fatura::COLUMN_BIRIM_FIYAT_TUKETIM      => 'Birim Tüketim Fiyatı',
            Fatura::COLUMN_SON_ODEME_TARIHI         => 'Son Ödeme Tarihi',
            Fatura::COLUMN_ENDEKS_ILK               => 'İlk Endeks',
            Fatura::COLUMN_ENDEKS_SON               => 'Son Endeks',
            Fatura::COLUMN_NOT                      => 'Fatura Açıklaması',
            'ek_kalemler'                           => 'Ek Kalem Türleri',
            'ek_kalemler.' . $tur                   => 'Ek Kalemler',
            'ek_kalemler.' . $tur . '.*'            => 'Ek Kalem',
            'ek_kalemler.' . $tur . '.*.id'         => 'Ek Kalem Idsi',
            'ek_kalemler.' . $tur . '.*.ucret_tur'  => 'Ek Kalem Ücret Türü',
            'ek_kalemler.' . $tur . '.*.deger'      => 'Ek Kalem Tutarı',
        ];
    }

    protected function prepareForValidation()
    {
        $payload = [
            Fatura::COLUMN_BIRIM_FIYAT_TUKETIM  => str_replace(',', '.', $this->{Fatura::COLUMN_BIRIM_FIYAT_TUKETIM}),
            Fatura::COLUMN_ENDEKS_ILK           => str_replace(',', '.', $this->{Fatura::COLUMN_ENDEKS_ILK ?? null}),
            Fatura::COLUMN_ENDEKS_SON           => str_replace(',', '.', $this->{Fatura::COLUMN_ENDEKS_SON}),
        ];

        $payload['ek_kalemler']             = $this->convertPointsToDots();

        $this->merge($payload);
    }

    /**
     * @return array
     */
    protected function convertPointsToDots() : array
    {
        $turler             = $this->ek_kalemler ?? [];
        $ekKalemList        = [];

        foreach ($turler as $tur => $ek_kalemler)
        {
            foreach ($ek_kalemler as $key => $ek_kalem)
            {
                if (empty($ek_kalem['id'])) {
                    continue;
                }

                if ($ek_kalem['deger'] ?? '') {
                    $ek_kalem['deger']      = str_replace(',', '.', $ek_kalem['deger']);
                }

                $ekKalemList[$tur][$key]    = $ek_kalem;
            }
        }

        return $ekKalemList;
    }
}
