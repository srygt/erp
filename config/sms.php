<?php

return [
    'log' => [
        'path' => 'logs/sms/',
    ],
    'vizyonmesaj' => [
        'username' => env('VIZYONMESAJ_USERNAME'),
        'password' => env('VIZYONMESAJ_PASSWORD'),
        'origin' => env('VIZYONMESAJ_ORIGIN'),
    ],
];
