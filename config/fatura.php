<?php

return [
    'ulke'          => 'TÜRKİYE',
    'il'            => 'ADANA',
    'ilce'          => 'SEYHAN',
    'adres'         => 'ADRES',
    'email'         => 'tunahan@hizliteknoloji.com.tr',
    'unvan'         => 'HIZLI BİLİŞİM TEKNOLOJİLERİ ANONİM ŞİRKETİ WS',
    'vergiNo'       => '4620553774',
    'vergiDairesi'  => 'VERGİ DARESİ',
    'telefon'       => \App\Helpers\Utils::getFormattedTelephoneNumber('905554443322'),

    'urn'           => 'urn:mail:defaultgb@hizlibilisimteknolojileri.net',
    'faturaNoPrefix'=> env('FATURA_CODE_PREFIX'),
    'faturaNoStart' => env('FATURA_CODE_START'),

];
