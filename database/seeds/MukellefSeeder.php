<?php

use App\Models\Mukellef;
use Illuminate\Database\Seeder;

class MukellefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Mukellef::class, 50)->state(Mukellef::COLUMN_VERGI_NO)->create();
        factory(Mukellef::class, 50)->state(Mukellef::COLUMN_TC_KIMLIK_NO)->create();
    }
}
