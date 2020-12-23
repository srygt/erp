<?php


namespace App\Services\Import\Fatura\Factories;


use App\Models\Abone;
use App\Services\Import\Fatura\Contracts\IFaturaValidation;
use Exception;
use Illuminate\Support\Str;

class FaturaFactory
{
    const VALIDATION_CLASS_NAMESPACE = 'App\Services\Import\Fatura\%s\Validation';

    /**
     * @param string $type
     * @return IFaturaValidation
     * @throws Exception
     */
    public static function createValidation(string $type) : IFaturaValidation
    {
        self::checkType($type);

        $faturaValidationClass = sprintf(self::VALIDATION_CLASS_NAMESPACE, Str::studly($type));

        return app($faturaValidationClass);
    }

    /**
     * @param string $type
     * @throws Exception
     */
    protected static function checkType(string $type) : void
    {
        if (! array_key_exists($type, Abone::TUR_LIST)) {
            throw new Exception('Bilinmeyen abone türü. Kabul edilen türler: '
                . implode(', ', array_values(Abone::TUR_LIST)));
        }
    }
}
