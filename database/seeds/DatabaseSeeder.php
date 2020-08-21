<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(AboneSeeder::class);
//        $this->call(MukellefSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(AyarSeeder::class);
    }
}
