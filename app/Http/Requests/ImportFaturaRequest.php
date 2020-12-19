<?php

namespace App\Http\Requests;

use App\Models\Abone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImportFaturaRequest extends FormRequest
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
            'tur'   => ['required', Rule::in(array_keys(Abone::TUR_LIST))],
            'dosya' => [
                'required',
                'mimetypes:text/csv,text/plain,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel',
                'mimes:txt,text,csv,xlsx,xls'
            ],
        ];
    }

    public function attributes()
    {
        return [
            'tur'   => 'Fatura Türü',
            'dosya' => 'Dosya',
        ];
    }
}
