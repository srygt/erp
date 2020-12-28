<?php

namespace App\Http\Requests\Import;

use App\Models\Abone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaturaListRequest extends FormRequest
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
            'tur'   => ['nullable', Rule::in(array_keys(Abone::TUR_LIST))],
        ];
    }
}
