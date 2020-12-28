<?php


namespace App\Services\Import\Fatura\Factories;


use App\Models\Abone;
use App\Models\ImportedFatura;
use App\Services\Import\Fatura\Adapters\AbstractImportedFaturaAdapter;
use App\Services\Import\Fatura\Contracts\IFaturaValidation;
use Exception;
use Illuminate\Support\Str;

class FaturaImportFactory
{
    const VALIDATION_CLASS_NAMESPACE    = 'App\Services\Import\Fatura\%s\Validation';

    const TEMPLATE_VALIDATION_TABLE     = 'import.fatura.%s.table';
    const TEMPLATE_EK_KALEM_SELECT      = 'import.fatura.%s.ekKalemSelect';

    const ADAPTER_IMPORTED_FATURA       = 'App\Services\Import\Fatura\%s\Adapters\ImportedFaturaAdapter';

    /**
     * @param ImportedFatura $importedFatura
     *
     * @return AbstractImportedFaturaAdapter
     * @throws Exception
     */
    public static function createFaturaAdapter(ImportedFatura $importedFatura)
    : AbstractImportedFaturaAdapter
    {
        $tur = $importedFatura->{ImportedFatura::COLUMN_TUR};

        self::checkType($tur);

        $className = sprintf(self::ADAPTER_IMPORTED_FATURA, Str::studly($tur));

        return app($className, ['importedFatura' => $importedFatura]);
    }

    /**
     * @param string $type
     *
     * @return string
     * @throws Exception
     */
    public static function getTemplateTable(string $type) : string
    {
        self::checkType($type);

        return sprintf(self::TEMPLATE_VALIDATION_TABLE, Str::slug($type));
    }

    /**
     * @param string $type
     *
     * @return string
     * @throws Exception
     */
    public static function getTemplateEkKalemSelect(string $type) : string
    {
        self::checkType($type);

        return sprintf(self::TEMPLATE_EK_KALEM_SELECT, Str::slug($type));
    }

    /**
     * @param string $type
     *
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
