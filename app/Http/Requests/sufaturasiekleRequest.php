<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sufaturasiekleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'aboneID' => 'required|numeric',
            'ilkEndeks' => 'required|numeric',
            'sonEndeks' => 'required|numeric',
            'tuketim' => 'required|numeric',
            'fiyati' => 'required|numeric',
            'sonOdemeTarihi' => 'required|Date|date_format:Y-m-d'

        ];
    }
}
