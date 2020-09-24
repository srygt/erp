<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MukellefPasiflestirRequest extends FormRequest
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
            'id'                    => 'nullable|numeric|exists:App\Models\Mukellef',
        ];
    }

    public function attributes()
    {
        return [];
    }

    protected function prepareForValidation()
    {
        $parameters = [];

        $this->merge($parameters);
    }
}
