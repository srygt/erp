<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GelenFaturaRequest extends FormRequest
{
    const GELEN_FATURA_DAY_LIST = [7, 30, 60, 90];
    const SINCE_DEFAULT         = 7;

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
            'since'   => Rule::in(self::GELEN_FATURA_DAY_LIST)
        ];
    }
}
