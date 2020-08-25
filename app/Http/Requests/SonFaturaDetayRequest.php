<?php

namespace App\Http\Requests;

use App\Models\Abone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SonFaturaDetayRequest extends FormRequest
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
            'abone_id'  => 'required|exists:App\Models\Abone,id',
        ];
    }

    public function attributes()
    {
        return [
            'abone_id'              => 'Abone',
        ];
    }
}
