<?php

namespace App\Http\Requests\Import;

use App\Models\ImportedFaturaFile;
use App\Services\Import\Fatura\Factories\FaturaFactory;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class FaturaValidationRequest extends FormRequest
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
     * @throws Exception
     */
    public function rules()
    {
        $validationClass = FaturaFactory::createValidation(
            Request::route()
                ->parameter('fatura_file')
                ->{ImportedFaturaFile::COLUMN_TYPE}
        );

        return $validationClass->rules();
    }

    public function attributes()
    {
        $validationClass = FaturaFactory::createValidation(
            Request::route()
                ->parameter('fatura_file')
                ->{ImportedFaturaFile::COLUMN_TYPE}
        );

        return $validationClass->attributes();
    }
}
