<?php

use App\Models\Abone;
use App\Models\Mukellef;
use Illuminate\Database\Seeder;

class AboneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mukellefler = Mukellef::whereNotNull('urn')->get();

        /** @var Mukellef $mukellef */
        foreach ($mukellefler as $mukellef)
        {
            $mukellef->abonelikler()
                ->createMany(
                    factory(Abone::class, 2)->state(Abone::COLUMN_TUR_ELEKTRIK)->make()->toArray()
                );
            $mukellef->abonelikler()
                ->createMany(
                    factory(Abone::class, 2)->state(Abone::COLUMN_TUR_SU)->make()->toArray()
                );
            $mukellef->abonelikler()
                ->createMany(
                    factory(Abone::class, 2)->state(Abone::COLUMN_TUR_DOGALGAZ)->make()->toArray()
                );
        }
    }
}
