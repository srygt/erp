<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->updateOrInsert(
            [
                'username'=>'admin@admin.com',
            ],
            [
                'name'      => 'Serdar',
                'lastname'  => 'Yiğit',
                'password'  => bcrypt('admin')
            ]
        );
    }
}
