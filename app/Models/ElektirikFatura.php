<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElektirikFatura extends Model
{
    protected $table ='elektirikfaturasi';
    public $timestamps=false;
    protected $primaryKey='ELEKTRIKID';

    protected $guarded =[];
}
