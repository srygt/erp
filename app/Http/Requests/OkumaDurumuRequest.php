<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OkumaDurumuRequest extends FormRequest
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
            'uuid' => 'required|uuid',
            'isMarkReaded' => ['required', Rule::in(['0', '1'])]
        ];
    }

    public function attributes()
    {
        return [
            'uuid' => 'UUID',
            'isMarkReaded' => 'isMarkReaded'
        ];
    }
}
