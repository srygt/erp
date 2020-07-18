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
    public function run(){
      Mukellef::Create([
          'VKNTCKN'=>'12345678911',
          'UNVAN'=>'Matgis Bilişim Teknoloji',
          'EPOSTA'=>'gorkem@matgis.com.tr',
          'ULKE'=>'TÜRKİYE',
          'IL'=>'KAYSERİ',
          'ILCE'=>'KOCASİNAN'


      ]);
    }
}
