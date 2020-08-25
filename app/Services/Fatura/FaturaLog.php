<?php


namespace App\Services\Fatura;


use App\Contracts\FaturaInterface;
use Storage;

class FaturaLog
{
    /**
     * @param string $configSavePath
     * @param FaturaInterface $fatura
     * @param string $content
     * @return bool
     */
    public static function save(string $configSavePath, FaturaInterface $fatura, string $content)
    {
        $modelName          = substr(strrchr(get_class($fatura), "\\"), 1);

        $responseSavePath   = config($configSavePath);

        $responseSavePath   = str_replace(
            [
                ':yil',
                ':ay',
                ':gun',
                ':id',
                ':type',
            ],
            [
                $fatura->created_at->year,
                $fatura->created_at->month,
                $fatura->created_at->day,
                $fatura->uuid,
                $modelName,
            ],
            $responseSavePath
        );

        return Storage::put($responseSavePath, $content);
    }
}
