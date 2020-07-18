<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sayac extends Model
{
    protected $table ='sayaclar';
    public $timestamps=false;
    protected $primaryKey='SAYACID';

    protected $guarded =[];
}
