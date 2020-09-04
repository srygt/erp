<?php

return [
    'ulke'                  => 'TÜRKİYE',
    'il'                    => 'ADANA',
    'ilce'                  => 'SEYHAN',
    'adres'                 => 'ADRES',
    'email'                 => 'tunahan@hizliteknoloji.com.tr',
    'unvan'                 => 'HIZLI BİLİŞİM TEKNOLOJİLERİ ANONİM ŞİRKETİ WS',
    'vergiNo'               => '4620553774',
    'vergiDairesi'          => 'VERGİ DARESİ',
    'telefon'               => \App\Helpers\Utils::getFormattedTelephoneNumber('905554443322'),

    'urn'                   => 'urn:mail:defaultgb@hizlibilisimteknolojileri.net',
    'eFaturaNoPrefix'       => env('EFATURA_CODE_PREFIX'),
    'eFaturaNoStart'        => env('EFATURA_CODE_START'),
    'eArsivNoPrefix'        => env('EARSIV_CODE_PREFIX'),
    'eArsivNoStart'         => env('EARSIV_CODE_START'),
    'aboneNoPadLength'      => 3,
    'aboneNoPadString'      => '0',
    'aboneNoPadDirection'   => STR_PAD_LEFT,

    'logPaths'              => [
        'error'                 => 'FaturaRRE/:yil/:ay/:gun/:id_:type_error.log',
        'request'               => 'FaturaRRE/:yil/:ay/:gun/:id_:type_request.log',
        'response'              => 'FaturaRRE/:yil/:ay/:gun/:id_:type_response.log',
    ],
];
