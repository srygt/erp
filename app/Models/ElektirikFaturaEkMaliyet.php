<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElektirikFaturaEkMaliyet extends Model
{
    protected $table ='elektirikfaturasiekmaliyetler';
    public $timestamps=false;
    protected $primaryKey='EKMALID';

    protected $guarded =[];
}
