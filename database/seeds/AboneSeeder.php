<?php

use App\Models\Abone;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AboneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   $date = new Carbon();
        $date->setTimezone('Europe/Istanbul');

        Abone::Create([
            "VKNTCKN"=>'12345678911',
            "ABONETIPI"=>'1',
            "ADURUMU"=>true,
            "ATARIH"=>$date->now()
        ]) ;
    }
}
