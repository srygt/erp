<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Abone;
use App\Models\Mukellef;
use Faker\Generator as Faker;

$factory->define(Abone::class, function (Faker $faker) {
    $sehir      = $faker->city;
    $email      = $faker->email;

    return [
        Abone::COLUMN_BASLIK        => $sehir . ' Şubesi',
        Abone::COLUMN_ABONE_NO      => $faker->numerify('###############'),
        Abone::COLUMN_SAYAC_NO      => $faker->numerify('###############'),
        Mukellef::COLUMN_EMAIL      => $email,
        Mukellef::COLUMN_ULKE       => 'Türkiye',
        Mukellef::COLUMN_IL         => $sehir,
        Mukellef::COLUMN_ILCE       => $faker->streetName,
        Mukellef::COLUMN_ADRES      => $faker->address,
        Mukellef::COLUMN_TELEFON    => mb_substr($faker->e164PhoneNumber, 1),
        Mukellef::COLUMN_URN        => 'urn:mail:' . $email,
    ];
});

$factory->state(Abone::class, Abone::COLUMN_TUR_ELEKTRIK, function () {
    return [
        Abone::COLUMN_TUR       => Abone::COLUMN_TUR_ELEKTRIK,
    ];
});

$factory->state(Abone::class, Abone::COLUMN_TUR_SU, function () {
    return [
        Abone::COLUMN_TUR       => Abone::COLUMN_TUR_SU,
    ];
});

$factory->state(Abone::class, Abone::COLUMN_TUR_DOGALGAZ, function () {
    return [
        Abone::COLUMN_TUR       => Abone::COLUMN_TUR_DOGALGAZ,
    ];
});
