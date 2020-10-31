<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Onrslu\HtEfatura\Types\Enums\AppType\EArsiv;
use Onrslu\HtEfatura\Types\Enums\AppType\EFatura;

class GidenFaturaRequest extends FormRequest
{
    const GIDEN_FATURA_DAY_LIST = [
        7   => 'Son 7 Gün',
        30  => 'Son 30 Gün',
        60  => 'Son 60 Gün',
        90  => 'Son 90 Gün',
        -1  => 'Tümü',
    ];
    const SINCE_DEFAULT         = 30;

    const APP_TYPE_LIST         = [
        EFatura::TYPE       => 'eFatura',
        EArsiv::TYPE        => 'eArşiv',
        -1                  => 'Tümü',
    ];
    const APP_TYPE_DEFAULT      = -1;

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
            'since'     => Rule::in(array_keys(self::GIDEN_FATURA_DAY_LIST)),
            'type'      => Rule::in(array_keys(self::APP_TYPE_LIST)),
        ];
    }
}
