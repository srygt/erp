<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Mukellef;
use Faker\Generator as Faker;

$factory->define(Mukellef::class, function (Faker $faker) {
    $sehir      = $faker->city;
    $email      = $faker->email;

    return [
        Mukellef::COLUMN_VERGI_DAIRESI_SEHIR    => $sehir,
        Mukellef::COLUMN_VERGI_DAIRESI          => $sehir . ' Vergi Dairesi',
        Mukellef::COLUMN_EMAIL                  => $email,
        Mukellef::COLUMN_ULKE                   => 'Türkiye',
        Mukellef::COLUMN_IL                     => $sehir,
        Mukellef::COLUMN_ILCE                   => $faker->streetName,
        Mukellef::COLUMN_ADRES                  => $faker->address,
        Mukellef::COLUMN_TELEFON                => mb_substr($faker->e164PhoneNumber, 1),
        Mukellef::COLUMN_URN                    => 'urn:mail:' . $email,
    ];
});

$factory->state(Mukellef::class, Mukellef::COLUMN_VERGI_NO, function (Faker $faker) {
    return [
        Mukellef::COLUMN_VERGI_NO       => $faker->numerify('##########'),
        'unvan'                         => $faker->company()
    ];
});
$factory->state(Mukellef::class, Mukellef::COLUMN_TC_KIMLIK_NO, function (Faker $faker) {
    return [
        Mukellef::COLUMN_TC_KIMLIK_NO   => $faker->tcNo(),
        'unvan'                         => $faker->name()
    ];
});
