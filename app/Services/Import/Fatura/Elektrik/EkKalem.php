<?php


namespace App\Services\Import\Fatura\Elektrik;


class EkKalem
{
    const ID_DEVREDEN_BORC     = 'devreden_borc_id';
    const ID_SISTEM_KULLANIM   = 'sistem_kullanim_id';
    const ID_DAGITIM_BEDELI    = 'dagitim_bedeli_id';

    const LIST = [
        self::ID_DEVREDEN_BORC,
        self::ID_SISTEM_KULLANIM,
        self::ID_DAGITIM_BEDELI,
    ];
}
