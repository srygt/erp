<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarife extends Model
{
    protected $table ='tarifeler';
    public $timestamps=false;
    protected $primaryKey='TARIFEID';

    protected $guarded =[];
}
