<?php

return [
    'ulke'                  => 'Türkiye',
    'il'                    => 'Diyarbakır',
    'ilce'                  => 'Yenişehir',
    'adres'                 => 'Elazığ Karayolu 22.KM OSB İdari Bina YENİŞEHİR/DİYARBAKIR OSB ',
    'email'                 => 'info@diyarbakirosb.org.tr',
    'unvan'                 => 'Diyarbakır Organize Sanayi Bölgesi Müteşebbis Heyet Başkanlığı',
    'vergiNo'               => env('FATURA_VERGI_NO', '3010074708'),
    'vergiDairesi'          => 'Gökalp',
    'telefon'               => \App\Helpers\Utils::getFormattedTelephoneNumber('904123450021'),

    'urn'                   => 'urn:mail:defaultgb@diyarbakirosb.org.tr',
    'eFaturaNoPrefix'       => env('EFATURA_CODE_PREFIX'),
    'eArsivNoPrefix'        => env('EARSIV_CODE_PREFIX'),
    'eXNoDatePrefix'        => env('EX_DATE_PREFIX'), // eFatura and eArsiv date prefix
    'aboneNoPadLength'      => 3,
    'aboneNoPadString'      => '0',
    'aboneNoPadDirection'   => STR_PAD_LEFT,

    // Fatura kesildikten sonra mail gönderilsin mi?
    'emailActive'           => env('FATURA_EMAIL_ACTIVE', true),

    'importPath'            => 'import/fatura',
    'logPaths'              => [
        'error'                 => 'FaturaRRE/:yil/:ay/:gun/:id_:type_error.log',
        'request'               => 'FaturaRRE/:yil/:ay/:gun/:id_:type_request.log',
        'response'              => 'FaturaRRE/:yil/:ay/:gun/:id_:type_response.log',
    ],
];
