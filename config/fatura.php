<?php

return [
    'ulke'                  => 'Türkiye',
    'il'                    => 'Diyarbakır',
    'ilce'                  => 'Yenişehir',
    'adres'                 => 'Elazığ Karayolu 22.KM OSB İdari Bina YENİŞEHİR/DİYARBAKIR OSB ',
    'email'                 => 'info@diyarbakirosb.org.tr',
    'unvan'                 => 'Diyarbakır Organize Sanayi Bölgesi Teşebbüs Teşvik Başkanlığı',
    'vergiNo'               => '3010074708',
    'vergiDairesi'          => 'Gökalp',
    'telefon'               => \App\Helpers\Utils::getFormattedTelephoneNumber('904123450021'),

    'urn'                   => 'urn:mail:info@diyarbakirosb.org.tr',
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
