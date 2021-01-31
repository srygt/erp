<?php

/** @var Factory $factory */

use App\Model;
use App\Models\Abone;
use App\Models\ImportedFatura;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ImportedFatura::class, function (Faker $faker) {
    return [
        ImportedFatura::COLUMN_FATURA_TARIH => $faker
            ->dateTimeBetween('-10 days'),
        ImportedFatura::COLUMN_SON_ODEME_TARIHI => $faker
            ->dateTimeBetween('+5 days', '+10 days'),
        ImportedFatura::COLUMN_ENDEKS_ILK => '0',
        ImportedFatura::COLUMN_ENDEKS_SON => $faker->numberBetween(250, 400),
        ImportedFatura::COLUMN_BIRIM_FIYAT_TUKETIM => $faker
            ->randomFloat(4, 0.05, 0.45),
        ImportedFatura::COLUMN_IP_NO => '0.0.0.0',
    ];
})
    ->state(
        ImportedFatura::class,
        Abone::COLUMN_TUR_SU,
        [
            ImportedFatura::COLUMN_TUR => Abone::COLUMN_TUR_SU
        ]
    )
    ->state(
        ImportedFatura::class,
        Abone::COLUMN_TUR_ELEKTRIK,
        [
            ImportedFatura::COLUMN_TUR => Abone::COLUMN_TUR_ELEKTRIK
        ]
    )
    ->state(
        ImportedFatura::class,
        Abone::COLUMN_TUR_DOGALGAZ,
        [
            ImportedFatura::COLUMN_TUR => Abone::COLUMN_TUR_DOGALGAZ
        ]
    );

