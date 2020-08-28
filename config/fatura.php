<?php

return [
    'ulke'              => 'TÜRKİYE',
    'il'                => 'ADANA',
    'ilce'              => 'SEYHAN',
    'adres'             => 'ADRES',
    'email'             => 'tunahan@hizliteknoloji.com.tr',
    'unvan'             => 'HIZLI BİLİŞİM TEKNOLOJİLERİ ANONİM ŞİRKETİ WS',
    'vergiNo'           => '4620553774',
    'vergiDairesi'      => 'VERGİ DARESİ',
    'telefon'           => \App\Helpers\Utils::getFormattedTelephoneNumber('905554443322'),
    'iban'              => 'TR00 1111 2222 3333 4444 5555 66',

    'urn'               => 'urn:mail:defaultgb@hizlibilisimteknolojileri.net',
    'faturaNoPrefix'    => env('FATURA_CODE_PREFIX'),
    'faturaNoStart'     => env('FATURA_CODE_START'),

    'logPaths' => [
        'error'         => 'FaturaRRE/:yil/:ay/:gun/:id_:type_error.log',
        'request'       => 'FaturaRRE/:yil/:ay/:gun/:id_:type_request.log',
        'response'      => 'FaturaRRE/:yil/:ay/:gun/:id_:type_response.log',
    ],
];
