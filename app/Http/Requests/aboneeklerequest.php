<?php

namespace App\Http\Requests;

use App\Rules\ForSelectBoxs;
use Dotenv\Validator;
use Illuminate\Foundation\Http\FormRequest;

class aboneeklerequest extends FormRequest
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
            'vkn_tckn' => 'required|numeric|digits_between:10,11',
            'unvan'=>'required',
            'abonetipi'=>'required',
            'mersisno'=>'nullable|numeric',
            'eposta'=>'required|email',
            'ulke'=>'required',
            'il'=>'required',
            'ilce'=>'required',
            'postakodu'=>'nullable|numeric|size:5',
            'telno'=>'nullable|numeric|size:11'

        ];

    }
}
