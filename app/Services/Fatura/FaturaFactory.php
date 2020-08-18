<?php


namespace App\Services\Fatura;


use App\Models\Abone;
use Exception;

class FaturaFactory
{
    public static function getService(string $type) : AbstractFatura
    {
        if (!in_array($type, array_keys(Abone::TUR_LIST))) {
            throw new Exception('Undefined abone type');
        }

        if ($type === Abone::COLUMN_TUR_SU) {
            return new Su\SuFaturasiService;
        }
        else if ($type === Abone::COLUMN_TUR_DOGALGAZ) {
            return new Dogalgaz\DogalgazFaturasiService;
        }
        else if ($type === Abone::COLUMN_TUR_ELEKTRIK) {
            return new Elektrik\ElektrikFaturasiService;
        }
    }
}
