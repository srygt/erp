<?php


namespace App\Services\Import\Fatura\Elektrik;


class EkKalem
{
    const ID_GECIKME_BEDELI             = 'gecikme_bedeli_id';
    const ID_SISTEM_KULLANIM            = 'sistem_kullanim_id';
    const ID_DAGITIM_BEDELI             = 'dagitim_bedeli_id';
    const BIRIM_FIYAT_SISTEM_KULLANIM   = 'birim_fiyat_sistem';
    const BIRIM_FIYAT_DAGITIM_BEDELI    = 'birim_fiyat_dagitim';

    const LIST = [
        self::ID_GECIKME_BEDELI,
        self::ID_SISTEM_KULLANIM,
        self::ID_DAGITIM_BEDELI,
    ];
}
