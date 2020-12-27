<?php


namespace App\Services\Fatura;


use App\Models\Abone;
use App\Models\Fatura;
use App\Services\Fatura\DataSources\AbstractDataSource;
use App\Services\Fatura\DataSources\DataSourceImported;
use App\Services\Fatura\DataSources\DataSourceManual;
use Exception;

class FaturaFactory
{
    const DATA_SOURCES = [
        Fatura::COLUMN_DATA_SOURCE_MANUAL    => [
            'class' => DataSourceManual::class,
        ],
        Fatura::COLUMN_DATA_SOURCE_IMPORTED  => [
            'class' => DataSourceImported::class,
        ],
    ];

    /**
     * @param string $type
     *
     * @return AbstractFatura
     * @throws Exception
     */
    public static function createService(string $type) : AbstractFatura
    {
        if ($type === Abone::COLUMN_TUR_SU) {
            return new Su\SuFaturasiService;
        }
        else if ($type === Abone::COLUMN_TUR_DOGALGAZ) {
            return new Dogalgaz\DogalgazFaturasiService;
        }
        else if ($type === Abone::COLUMN_TUR_ELEKTRIK) {
            return new Elektrik\ElektrikFaturasiService;
        }

        throw new Exception('Undefined abone type');
    }

    /**
     * @param string $type
     *
     * @return AbstractDataSource
     * @throws Exception
     */
    public static function createDataSource(string $type) : AbstractDataSource
    {
        if (array_key_exists($type, self::DATA_SOURCES)) {
            return app(self::DATA_SOURCES[$type]['class']);
        }

        throw new Exception('Undefined data source type');
    }
}
