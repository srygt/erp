<?php

namespace App\Http\Requests\Import;

use App\Models\FileImportedFatura;
use App\Services\Import\Fatura\Factories\FaturaImportFactory;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class FaturaImportRequest extends FormRequest
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
        $validationClass = FaturaImportFactory::createValidation(
            Request::route()
                ->parameter('fatura_file')
                ->{FileImportedFatura::COLUMN_TYPE}
        );

        return $validationClass->rules();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function attributes()
    {
        $validationClass = FaturaImportFactory::createValidation(
            Request::route()
                ->parameter('fatura_file')
                ->{FileImportedFatura::COLUMN_TYPE}
        );

        return $validationClass->attributes();
    }
}
