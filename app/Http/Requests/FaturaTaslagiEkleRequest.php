<?php

namespace App\Http\Requests;

use App\Helpers\Utils;
use App\Models\Abone;
use App\Models\AyarEkKalem;
use App\Models\Fatura;
use App\Services\Fatura\FaturaFactory;
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
    /** @var string  */
    const ENDUKTIF_STATUS   = 'enduktif_status';

    /** @var string  */
    const KAPASITIF_STATUS  = 'kapasitif_status';

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

        $rules  = [
            'id'                                    => 'nullable|numeric|exists:App\Models\FaturaTaslagi,id',
            'abone_id'                              => [
                                                            'required',
                                                            'numeric',
                                                            Rule::exists('App\Models\Abone', 'id')
                                                                ->where('aktif_mi', true),
                                                        ],
            'tur'                                   => ['required', Rule::in(array_keys(Abone::TUR_LIST))],
            Fatura::COLUMN_FATURA_TARIH             => 'required|date_format:' . config('common.time.format'),
            Fatura::COLUMN_SON_ODEME_TARIHI         => 'required|date_format:' . config('common.date.format'),
            Fatura::COLUMN_ENDEKS_ILK               => 'nullable|required_if:tur,' . Abone::COLUMN_TUR_SU . '|numeric|min:0|lte:' . Fatura::COLUMN_ENDEKS_SON,
            Fatura::COLUMN_ENDEKS_SON               => 'required|numeric|min:0',
            Fatura::COLUMN_BIRIM_FIYAT_TUKETIM      => 'required|numeric|min:0.000000001',
            Fatura::COLUMN_GUNDUZ_TUKETIM           => 'nullable|required_if:tur,' . Abone::COLUMN_TUR_ELEKTRIK . '|numeric|min:0',
            Fatura::COLUMN_PUAND_TUKETIM            => 'nullable|required_if:tur,' . Abone::COLUMN_TUR_ELEKTRIK . '|numeric|min:0',
            Fatura::COLUMN_GECE_TUKETIM             => 'nullable|required_if:tur,' . Abone::COLUMN_TUR_ELEKTRIK . '|numeric|min:0',
            Fatura::COLUMN_ENDUKTIF_TUKETIM         => 'nullable|required_if:' . self::ENDUKTIF_STATUS . ',true|numeric|min:0',
            Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT     => 'nullable|required_if:' . self::ENDUKTIF_STATUS . ',true|numeric|min:0.000000001',
            Fatura::COLUMN_KAPASITIF_TUKETIM        => 'nullable|required_if:' . self::KAPASITIF_STATUS . ',true|numeric|min:0',
            Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT    => 'nullable|required_if:' . self::KAPASITIF_STATUS . ',true|numeric|min:0.000000001',
            Fatura::COLUMN_NOT                      => 'nullable',
            Fatura::COLUMN_DATA_SOURCE              => ['required', Rule::in(array_keys(FaturaFactory::DATA_SOURCES))],
            'ek_kalemler'                           => 'nullable|array',
            'ek_kalemler.' . $tur                   => 'nullable|array',
            'ek_kalemler.' . $tur . '.*.id'         => 'required|numeric|exists:App\Models\AyarEkKalem,id',
            'ek_kalemler.' . $tur . '.*.ucret_tur'  => ['required', Rule::in(array_keys(AyarEkKalem::LIST_UCRET_TUR))],
            'ek_kalemler.' . $tur . '.*.deger'      => 'required|numeric',

            self::ENDUKTIF_STATUS                   => 'required|boolean',
            self::KAPASITIF_STATUS                  => 'required|boolean',
        ];

        $dataSource = FaturaFactory::createDataSource(
                $this->{Fatura::COLUMN_DATA_SOURCE}
            );

        return array_merge(
            $rules,
            $dataSource->getValidation()
        );

    }

    public function attributes()
    {
        $tur    = Abone::find($this->{Fatura::COLUMN_ABONE_ID} ?? '')->{Fatura::COLUMN_TUR} ?? '';

        return [
            'abone_id'                              => 'Abone',
            'tur'                                   => 'Abonelik T??r??',
            Fatura::COLUMN_FATURA_TARIH             => 'Fatura Tarihi',
            Fatura::COLUMN_SON_ODEME_TARIHI         => 'Son ??deme Tarihi',
            Fatura::COLUMN_ENDEKS_ILK               => '??lk Endeks',
            Fatura::COLUMN_ENDEKS_SON               => '(Son Endeks / Toplam T??ketim)',
            Fatura::COLUMN_BIRIM_FIYAT_TUKETIM      => 'Birim T??ketim Fiyat??',
            Fatura::COLUMN_GUNDUZ_TUKETIM           => 'G??nd??z T??ketim',
            Fatura::COLUMN_PUAND_TUKETIM            => 'Puand T??ketim',
            Fatura::COLUMN_GECE_TUKETIM             => 'Gece T??ketim',
            Fatura::COLUMN_ENDUKTIF_TUKETIM         => 'End??ktif Toplam T??ketim',
            Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT     => 'End??ktif Birim Fiyat',
            Fatura::COLUMN_KAPASITIF_TUKETIM        => 'Kapasitif Toplam T??ketim',
            Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT    => 'Kapasitif Birim Fiyat',
            Fatura::COLUMN_NOT                      => 'Fatura A????klamas??',
            'ek_kalemler'                           => 'Ek Kalem T??rleri',
            'ek_kalemler.' . $tur                   => 'Ek Kalemler',
            'ek_kalemler.' . $tur . '.*'            => 'Ek Kalem',
            'ek_kalemler.' . $tur . '.*.id'         => 'Ek Kalem Idsi',
            'ek_kalemler.' . $tur . '.*.ucret_tur'  => 'Ek Kalem ??cret T??r??',
            'ek_kalemler.' . $tur . '.*.deger'      => 'Ek Kalem Tutar??',

            self::ENDUKTIF_STATUS                   => 'End??ktif Durumu',
            self::KAPASITIF_STATUS                  => 'Kapasitif Durumu',
        ];
    }

    protected function prepareForValidation()
    {
        $payload = [];

        $payload[Fatura::COLUMN_BIRIM_FIYAT_TUKETIM]    = Utils::getFloatValue($this->{Fatura::COLUMN_BIRIM_FIYAT_TUKETIM} ?? null);
        $payload[Fatura::COLUMN_ENDEKS_ILK]             = Utils::getFloatValue($this->{Fatura::COLUMN_ENDEKS_ILK} ?? null) ?? 0;
        $payload[Fatura::COLUMN_ENDEKS_SON]             = Utils::getFloatValue($this->{Fatura::COLUMN_ENDEKS_SON} ?? null);
        $payload[Fatura::COLUMN_GUNDUZ_TUKETIM]         = Utils::getFloatValue($this->{Fatura::COLUMN_GUNDUZ_TUKETIM} ?? null);
        $payload[Fatura::COLUMN_PUAND_TUKETIM]          = Utils::getFloatValue($this->{Fatura::COLUMN_PUAND_TUKETIM} ?? null);
        $payload[Fatura::COLUMN_GECE_TUKETIM]           = Utils::getFloatValue($this->{Fatura::COLUMN_GECE_TUKETIM} ?? null);
        $payload[Fatura::COLUMN_ENDUKTIF_TUKETIM]       = Utils::getFloatValue($this->{Fatura::COLUMN_ENDUKTIF_TUKETIM} ?? null) ?? null;
        $payload[Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT]   = Utils::getFloatValue($this->{Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT} ?? null) ?? null;
        $payload[Fatura::COLUMN_KAPASITIF_TUKETIM]      = Utils::getFloatValue($this->{Fatura::COLUMN_KAPASITIF_TUKETIM} ?? null) ?? null;
        $payload[Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT]  = Utils::getFloatValue($this->{Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT} ?? null) ?? null;
        $payload[self::ENDUKTIF_STATUS]                 = true;
        $payload[self::KAPASITIF_STATUS]                = true;


        $payload['ek_kalemler']                         = $this->convertPointsToDots();

        // clear enduktif and kapasitif values on the conditions are meet
        $abone = Abone::find((int)($this->{Fatura::COLUMN_ABONE_ID} ?? 0));

        if ( !$abone || $abone->{Abone::COLUMN_TUR} !== Abone::COLUMN_TUR_ELEKTRIK)
        {
            $payload[Fatura::COLUMN_GUNDUZ_TUKETIM]         = null;
            $payload[Fatura::COLUMN_PUAND_TUKETIM]          = null;
            $payload[Fatura::COLUMN_GECE_TUKETIM]           = null;
        }
        if ( !$abone || $abone->{Abone::COLUMN_TUR} !== Abone::COLUMN_TUR_ELEKTRIK || !$abone->{Abone::COLUMN_ENDUKTIF_BEDEL} )
        {
            $payload[Fatura::COLUMN_ENDUKTIF_TUKETIM]       = null;
            $payload[Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT]   = null;
            $payload[self::ENDUKTIF_STATUS]                 = false;
        }
        if ( !$abone || $abone->{Abone::COLUMN_TUR} !== Abone::COLUMN_TUR_ELEKTRIK || !$abone->{Abone::COLUMN_KAPASITIF_BEDEL} )
        {
            $payload[Fatura::COLUMN_KAPASITIF_TUKETIM]      = null;
            $payload[Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT]  = null;
            $payload[self::KAPASITIF_STATUS]                = false;
        }

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
                    $ek_kalem['deger']      = Utils::getFloatValue($ek_kalem['deger']);
                }

                $ekKalemList[$tur][$key]    = $ek_kalem;
            }
        }

        return $ekKalemList;
    }
}
